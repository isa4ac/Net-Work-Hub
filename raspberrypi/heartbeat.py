import datetime
import mariadb
import time as t
import os
import sys
import logging
from dotenv import load_dotenv

load_dotenv()
logging.basicConfig(level=logging.DEBUG, filename='heartbeat.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')

def send_heartbeat():
    
    time = datetime.datetime.now()

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

    query = f"UPDATE device_Data SET deviceData_Updated_Datetime = '{time}' WHERE deviceData_Id_PK='{os.environ.get('PI_UUID')}'"
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
     
    time = datetime.datetime.now()

    while True:
        send_heartbeat()
        print(f'{time}: Update sent')
        t.sleep(60)

if __name__ == '__main__':
    main()
