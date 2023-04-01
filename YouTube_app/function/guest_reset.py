
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



sql1 = "delete from movies where user_id = 21;"
cur.execute(sql1)

sql2 = f"delete from channels where user_id = 21;"
cur.execute(sql2)

sql3 = f"delete from categories where user_id = 21;"
cur.execute(sql3)

conn.commit()

cur.close()
conn.close()
