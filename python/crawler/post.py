import os
import sys
import pymysql.cursors
import pandas as pd
import numpy as np
import crawler
import subprocess
from dotenv import load_dotenv

# Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"
# subprocess.Popen('/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"')

load_dotenv(verbose=True)

MYSQL_HOST = '127.0.0.1'
MYSQL_USER = os.getenv('MYSQL_USER')
MYSQL_PASSWORD = os.getenv('MYSQL_PASSWORD')
MYSQL_DB = os.getenv('MYSQL_DB')
MYSQL_PORT = 9922

conn = pymysql.connect(host=MYSQL_HOST,
                             user=MYSQL_USER,
                             password=MYSQL_PASSWORD,
                             database=MYSQL_DB,
                             port=MYSQL_PORT,
                             charset='utf8',
                             cursorclass=pymysql.cursors.DictCursor)

def getList(limit):
    with conn.cursor() as cursor:
        sql = "SELECT * FROM g5_write_product WHERE wr_10 IS NULL OR wr_10 = '' ORDER BY wr_id DESC LIMIT %s"
        cursor.execute(sql, (limit))
        result = cursor.fetchall()
        return result

def update(data, wr_id):
    with conn.cursor() as cursor:
        sql = "UPDATE g5_write_product SET wr_10 = %s WHERE wr_id = %s"
        result = cursor.execute(sql, (data, wr_id))
        print(wr_id)
        print(result)
        conn.commit()

def makePost(limit=10):
    list = getList(limit)
    for row in list:
        result = crawler.run(row['wr_link1'])
        update(result['html'], row['wr_id'])

if __name__ == "__main__":
    try:
        limit =  int(sys.argv[1])
    except:
        limit = 10

    makePost(limit)