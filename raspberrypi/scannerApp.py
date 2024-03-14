import re
import time
import nmap
import socket
import uuid
import subprocess
import config
import os
import mariadb
import sys
import requests
from dotenv import load_dotenv

load_dotenv()

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

#returns ip, hostname, state, and port of machines on the network
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

#returns ips, hostnames, macs, and ports
def host_scan():
     
    ips = get_range()
    nm = nmap.PortScanner()
    nm.scan(hosts=ips, arguments='--privileged -sS')
    results = []

    for host in nm.all_hosts():
        host_data = {
                'ip': host,
                'hostname': nm[host].hostname()
        }

        #add mac addresses
        if 'addresses' in nm[host]:
            addresses = nm[host]['addresses']
            if 'mac' in addresses:
                host_data['mac_address'] = addresses['mac']

        #add ports
        if 'tcp' in nm[host]:
            host_data['ports'] = list(nm[host]['tcp'].keys())
        else:
            host_data['ports'] = []

        results.append(host_data)

    return results

def insert_data(connection, query, values):
    """Insert data into a table"""
    cursor = connection.cursor()
    try:
        cursor.execute(query, values)
        connection.commit()
        print("Query executed successfully")
    except Error as e:
        print(f"The error '{e}' occurred")

def portscan():
    try:
        scan_results = port_scan()
        return scan_results
    except Exception as err:
        return {'error': str(err)}, 500

def hostscan():
    try:
        scan_results = host_scan()
        return scan_results
    except Exception as err:
        return {'error': str(err)}, 500

def insert_Nmap_Data(data):

    try:
        conn = mariadb.connect(
            user=os.environ.get('DB_USER'),
            password=os.environ.get('DB_PASS'),
            host=os.environ.get('DB_HOST'),
            port=int(os.environ.get('DB_PORT')),
            database=os.environ.get('DB_NAME')

        )

    except mariadb.Error as e:
        print(f"Error connecting to MariaDB Platform: {e}")
        sys.exit(1)

    cur = conn.cursor()
    #todo finish query
    query = "INSERT INTO device_Data (deviceData_Id_PK, deviceData_Address_MAC, deviceData_Address_IP_LAN, ...)
    try: 
        cur.execute(query, data) 
    except mariadb.Error as e: 
        print(f"Error: {e}")

    conn.commit() 
    print(f"Last Inserted ID: {cur.lastrowid}")
    
    conn.close()
    return 'success'

def main():
     while True:
          hostscan()
#timer run this every 7200 seconds
          time.sleep(7200)

if __name__ == '__main__':
    main()
