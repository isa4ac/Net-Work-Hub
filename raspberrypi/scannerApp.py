import hashlib
import re
import datetime
import time as t
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
import logging

load_dotenv()

logging.basicConfig(level=logging.DEBUG, filename='app.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')

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
    nm.scan(hosts=ips, arguments='--privileged -sS')

    allports = []

    try:
        conn = mariadb.connect(
            user=os.environ.get('DB_USER'),
            password=os.environ.get('DB_PASS'),
            host=os.environ.get('DB_HOST'),
            port=int(os.environ.get('DB_PORT')),
            database=os.environ.get('DB_NAME')
        )

    except mariadb.Error as err:
        print(f"Error connecting to database: {err}")
        sys.exit(1)

    cur = conn.cursor()

    for host in nm.all_hosts():

        #get open ports
        if 'tcp' in nm[host]:
            for port, port_info in nm[host]['tcp'].items():
                port_number = port

                #get mac address
                if 'addresses' in nm[host]:
                    addresses = nm[host]['addresses']
                    if 'mac' in addresses:
                        host_mac_address = addresses['mac']

                hashthis = f'{host_mac_address}{port_number}'
                result = hashlib.md5(hashthis.encode())
                macporthash = (result.hexdigest())

                allports.append((macporthash, host_mac_address, port_number))
        else:
            port_number = []

    for macporthash, macaddress, portnumber in allports:
        try:
            cur.execute(f"INSERT INTO ports (port_id, port_number, host_mac_address_FK) VALUES ('{macporthash}', '{portnumber}', '{macaddress}')")
        except mariadb.Error as err:
            print(f"Error: {err}")

        conn.commit()
    conn.close()
    return 'success'

#returns ips and hostnames (if found) on network
def host_scan():

    ips = get_range()
    nm = nmap.PortScanner()
    nm.scan(hosts=ips, arguments='--privileged -sS')

    #connect to db
    try:
        conn = mariadb.connect(
            user=os.environ.get('DB_USER'),
            password=os.environ.get('DB_PASS'),
            host=os.environ.get('DB_HOST'),
            port=int(os.environ.get('DB_PORT')),
            database=os.environ.get('DB_NAME')
        )

    except mariadb.Error as err:
        print(f"Error connecting to database: {err}")
        sys.exit(1)

    #get cursor for db writing
    cur = conn.cursor()

    for host in nm.all_hosts():

        host_ip = host
        host_name = nm[host].hostname()
        #add mac addresses
        if 'addresses' in nm[host]:
            addresses = nm[host]['addresses']
            if 'mac' in addresses:
                host_mac_address = addresses['mac']

        insertquery = f"INSERT INTO hosts (host_name, host_ip_address, host_mac_address, deviceData_Id_FK) VALUES ('{host_name}', '{host_ip}', '{host_mac_address}', '{os.environ.get('PI_UUID')}')"
        try:
            cur.execute(insertquery)
        except mariadb.Error as err:
            print(f"Error: {err}")

        updatequery = f"UPDATE hosts SET host_name = '{host_name}', host_ip_address = '{host_ip}' WHERE deviceData_Id_FK= '{os.environ.get('PI_UUID')}' AND host_mac_address = '{host_mac_address}'"
        try:
            cur.execute(updatequery)
        except mariadb.Error as err:
            print(f"Error: {err}")

        conn.commit()
    conn.close()
    return 'success'

def main():

     time = datetime.datetime.now()
     while True:
        host_scan()
        logging.debug(f'{time}: hosts input complete')
        t.sleep(15)
        logging.debug(f'{time}: starting ports input')
        port_scan()
        logging.debug(f'{time}: updates complete')
        logging.debug(f'{time}: sleeping for 7200 seconds...')
        t.sleep(7200)

if __name__ == '__main__':
    main()
