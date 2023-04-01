
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



sql1 = "select * from channels where seen = 1;"
cur.execute(sql1)
get_channel = cur.fetchall()
get_channel = list(get_channel)

now_data = dict()
sql2 = "select * from movies;"
cur.execute(sql2)
data = cur.fetchall()
data = list(data)
for i in range(len(data)):
    category_id = data[i][2]
    movie_url = data[i][4]
    if (category_id, movie_url) not in now_data:
        now_data[(category_id, movie_url)] = 1
print(get_channel)

for i in range(len(get_channel)):
    channel_id= get_channel[i][0]
    channel_name = get_channel[i][1]
    user_id = get_channel[i][2]
    category_id = get_channel[i][3]
    channel_url = get_channel[i][5]
    print(user_id,category_id)

    sql3 = "select * from users where id = %s;"
    cur.execute(sql3, (user_id, ))
    user_data = cur.fetchall()
    user_data = list(user_data[0])
    api_key = user_data[3]


    try:
        response = requests.get(f'https://www.googleapis.com/youtube/v3/search?key={api_key}&channelId={channel_url}&part=snippet,id&order=date&maxResults=10')
        data = json.loads(response.text)
        items = data['items']
        print("Yes")
        if response.status_code == 200:
            for item in items:
                title = item['snippet']['title']
                if item["id"]["kind"] != "youtube#video":
                    continue
                movie_url = 'https://www.youtube.com/watch?v=' + item['id']['videoId']
                thumbnail = item['snippet']['thumbnails']['high']['url']
                movie_at = item['snippet']['publishedAt']

                sql4 = "INSERT INTO movies (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at) VALUE (%s, %s, %s, %s, %s, %s, %s, %s);"
                if (category_id, movie_url) in now_data:
                    continue
                cur.execute(sql4, (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at, ))
                print(title)
                print("add")
                print("")
            sql6 = f"UPDATE apis SET cnt_begin = cnt_begin + 1 where API = '{api_key}';"
            print(sql6)
            cur.execute(sql6)

        else:
            # Print an error message if the request was not successful
            print('An error occurred while making the API request')

        print("ok")
    except:
        try:
            api_key = "AIzaSyAw2ow2sqwNeyw9V1V_b3BMRhxgMVim4ZI"
            response = requests.get(f'https://www.googleapis.com/youtube/v3/search?key={api_key}&channelId={channel_url}&part=snippet,id&order=date&maxResults=10')
            data = json.loads(response.text)
            items = data['items']
            print("Yes")
            if response.status_code == 200:
                for item in items:
                    title = item['snippet']['title']
                    if item["id"]["kind"] != "youtube#video":
                        continue
                    movie_url = 'https://www.youtube.com/watch?v=' + item['id']['videoId']
                    thumbnail = item['snippet']['thumbnails']['high']['url']
                    movie_at = item['snippet']['publishedAt']

                    sql4 = "INSERT INTO movies (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at) VALUE (%s, %s, %s, %s, %s, %s, %s, %s);"
                    if (category_id, movie_url) in now_data:
                        continue
                    cur.execute(sql4, (user_id, category_id, channel_id, channel_name, movie_url, title, thumbnail, movie_at, ))
                    print(title)
                    print("add")
                    print("")
                sql6 = f"UPDATE apis SET cnt_begin = cnt_begin + 1 where API = '{api_key}';"
                print(sql6)
                cur.execute(sql6)
        
            else:
                # Print an error message if the request was not successful
                print('An error occurred while making the API request')

            print("ok2")
        except:
            print("not good")

sql5 = "UPDATE channels SET seen = 2;"
cur.execute(sql5)

conn.commit()

cur.close()
conn.close()
