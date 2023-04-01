
import MySQLdb
import requests
import os
import json
import sqlite3
from collections import defaultdict

conn = MySQLdb.connect(
    unix_socket = '/Applications/MAMP/tmp/mysql/mysql.sock',
    host = 'localhost',
    port = 8889,
    user = 'root',
    passwd = 'root',
    db = 'youtubedb',
    charset = 'utf8')

cur = conn.cursor()



sql1 = "select * from apis"
cur.execute(sql1)
get_apis = cur.fetchall()
get_apis = list(get_apis)
get_apis = sorted(get_apis, key=lambda x: x[2])

sql2 = f"UPDATE users SET API = '{get_apis[0][1]}';"
cur.execute(sql2)
print({get_apis[0][1]})


conn.commit()

cur.close()
conn.close()
