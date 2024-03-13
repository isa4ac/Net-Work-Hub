from flask import Flask, jsonify
import mysql.connector
from mysql.connector import Error
import re
import nmap
import socket
import uuid
import subprocess
import config

app = Flask(__name__)

def get_range():

        filter = r'\.[0-9]{1,3}$'
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        s.connect(('8.8.8.8', 0))
        currentip = s.getsockname()[0]
        currentrange = re.sub(filter, '.0/24', currentip)
        return currentrange

def get_mac():

        mac = uuid.getnode()
        mac = ':'.join(("%012X" % mac)[i:i+2] for i in range(0, 12, 2))
        return mac

def get_vpnstatus():

        status = subprocess.call(["systemctl", "is-active", "--quiet", "openvpn.service"])
        if status == 0:
                return("active")
        else:
                return("inactive")

def port_scan():

    ips = get_range()
    nm = nmap.PortScanner()
    nm.scan(hosts=ips, arguments='-A')
    results = []

    for host in nm.all_hosts():
        host_data = {
                'ip': host,
                'hostname': nm[host].hostname(),
                'state': nm[host].state()
        }

        if 'tcp' in nm[host]:
            host_data['ports'] = list(nm[host]['tcp'].keys())
        else:
            host_data['ports'] = []

        results.append(host_data)

    return results

def host_scan():

    ips = get_range()
    nm = nmap.PortScanner()
    nm.scan(hosts=ips, arguments='-sn')
    results = []

    for host in nm.all_hosts():
        host_data = {
                'ip': host,
                'hostname': nm[host].hostname()
        }

        results.append(host_data)

    return results

def create_connection():
    """Create a database connection to a MySQL database"""
    connection = None
    try:
        connection = mysql.connector.connect(
            host = config.host,
            user = config.username,
            passwd = config.password,
            database = config.database
        )
        print("Connection to MySQL DB successful")
    except Error as e:
        print(f"The error '{e}' occurred")

    return connection

def insert_data(connection, query, values):
    """Insert data into a table"""
    cursor = connection.cursor()
    try:
        cursor.execute(query, values)
        connection.commit()
        print("Query executed successfully")
    except Error as e:
        print(f"The error '{e}' occurred")

@app.route('/')
def index():
    return """
    <p>networkHub API :p</p>
    <a href="/scan">scan</a>
    """

@app.route('/portscan')
def portscan():
    try:
        scan_results = port_scan()
        return jsonify(scan_results)
    except Exception as err:
        return jsonify({'error': str(err)}), 500

@app.route('/hosts')
def hostscan():
    try:
        scan_results = host_scan()
        return jsonify(scan_results)
    except Exception as err:
        return jsonify({'error': str(err)}), 500

def insert_Nmap_Data():
    # Establish a database connection
    conn = create_connection(host, user, password, database)

    if conn is not None:
        # Insert data
        insert_query = "INSERT INTO job_Messages (jobMessage_Id_PK, jobMessage_jobDetail_Id_FK, jobMessage_Sender_UserId_FK, jobMessage_Text) VALUES (%s, %s, %s, %s)"
        data_to_insert = ('test123', 'jobidtest', 'senderidtest', 'test message')

        insert_data(conn, insert_query, data_to_insert)

        # Close the connection
        conn.close()

if __name__ == '__main__':
    app.run(host='0.0.0.0') #makes available on local network
