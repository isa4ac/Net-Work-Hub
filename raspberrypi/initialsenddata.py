import mariadb
import requests
import os
import sys
import time
import socket
import uuid
import datetime
from dotenv import load_dotenv

load_dotenv()

def send_device_data():

    #get data
    try:
        #wan
        wanip = requests.get('https://checkip.amazonaws.com').text.strip()
        #lan
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        s.connect(('8.8.8.8', 0))
        lanip = s.getsockname()[0]
        #mac
        dirtymac = uuid.getnode()
        mac = ':'.join(("%012X" % dirtymac)[i:i+2] for i in range(0, 12, 2))
        #activation time
        time = datetime.datetime.now()
        
    except Exception as err:
        print('Error: ', err)
        return None
    
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

    query = f"UPDATE device_Data SET deviceData_Address_MAC = '{mac}', deviceData_Address_IP_LAN = '{lanip}', deviceData_Address_IP_WAN = '{wanip}', deviceData_Activated_Datetime = '{time}' WHERE deviceData_Id_PK='{os.environ.get('PI_UUID')}'"
    print(query)
    try: 
        cur.execute(query) 
    except mariadb.Error as err: 
        print(f"Error: {err}")
 
    conn.commit()
    print(f"Last Row ID: {cur.lastrowid}")
    conn.close()
    return 'success'

def main():
     while True:
          send_device_data()
          print('success')
          exit(1)

if __name__ == '__main__':
    main()
