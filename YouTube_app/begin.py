
import MySQLdb
import requests
import os
import json
import sqlite3
from collections import defaultdict
import sys

conn = MySQLdb.connect(
unix_socket = '/Applications/MAMP/tmp/mysql/mysql.sock',
host = 'localhost',
port = 8889,
user = 'root',
passwd = 'root',
db = 'youtubedb',
charset = 'utf8')

cur = conn.cursor()

sql2 = "select * from channels ORDER BY created_at DESC;"
cur.execute(sql2)
get_channel_id = cur.fetchall()
get_channel_id = list(get_channel_id[0])
channel_id= get_channel_id[0]

argvs = sys.argv
user_id = argvs[0]
category_id = argvs[1]
channel_url = argvs[2]

sql3 = "select * from users where id = %s;"
cur.execute(sql3, (user_id, ))
user_data = cur.fetchall()
user_data = list(user_data[0])
api_key = user_data[3]

try:
    response = requests.get(f'https://www.googleapis.com/youtube/v3/search?key={api_key}&channelId={channel_url}&part=snippet,id&order=date&maxResults=10')

    data = json.loads(response.text)
    items = data['items']
    if response.status_code == 200:
            # Parse the JSON data from the response
        data = json.loads(response.text)
        items = data['items']

        for item in items:
            title = item['snippet']['title']
            if item["id"]["kind"] != "youtube#video":
                continue
            movie_url = 'https://www.youtube.com/watch?v=' + item['id']['videoId']
            thumbnail = item['snippet']['thumbnails']['high']['url']

            sql4 = "INSERT INTO movies (user_id, category_id, channel_id, movie_url, title, thumbnail) VALUE (%s, %s, %s, %s, %s, %s);"
            cur.execute(sql4, (user_id, category_id, channel_id, movie_url, title, thumbnail, ))

    else:
        # Print an error message if the request was not successful
        print('An error occurred while making the API request')

    print("ok")
except:
    print("not good")

conn.commit()

cur.close()
conn.close()

