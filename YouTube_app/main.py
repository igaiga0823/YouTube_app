
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

sql = "select * from channels"

cur.execute(sql)

rows = cur.fetchall()

sql2 = "select movie_url from movies"
cur.execute(sql2)
data = cur.fetchall()
now_data = dict()
for i in data:
    for j in i:
        now_data[j] = 1

add_data = defaultdict(list)
for row in rows:
    row = list(row)
    print(row)
    user_id = row[2]
    category_id = row[3]
    channel_id = row[0]
    channel_name = row[1]
    channel_url = row[5]

    sql3 = "select * from users where id = %s"
    cur.execute(sql3, (user_id, ))
    user_data = cur.fetchall()
    user_data = list(user_data[0])

    api_key = user_data[3]

    if channel_url in add_data:
        movie_url = add_data[channel_url][0]
        title = add_data[channel_url][1]
        thumbnail = add_data[channel_url][2]
        movie_at = add_data[channel_url][3]
        sql4 = "INSERT INTO movies (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at) VALUE (%s, %s, %s, %s, %s, %s, %s, %s);"
        cur.execute(sql4, (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at, ))
    else:
        response = requests.get(f'https://www.googleapis.com/youtube/v3/search?key={api_key}&channelId={channel_url}&part=snippet,id&order=date&maxResults=1')

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
                movie_at = item['snippet']['publishedAt']

                if movie_url in now_data:
                    print(title)
                    print("exist")
                    print("")
                    continue       
                else:
                    sql4 = "INSERT INTO movies (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at) VALUE (%s, %s, %s, %s, %s, %s, %s, %s);"
                    cur.execute(sql4, (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at, ))
                    print(title)
                    print("add")
                    print("")
                    add_data[channel_url] = [movie_url, title, thumbnail, movie_at]
        else:
            # Print an error message if the request was not successful
            print('An error occurred while making the API request')


cur.close()
conn.commit()
conn.close()

