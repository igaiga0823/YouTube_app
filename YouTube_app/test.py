import MySQLdb
import requests
import os
import json
import sqlite3
from collections import defaultdict


channel_url = "UCuhPVNbY5AATKsU5RSEhbCQ"
api_key = "AIzaSyDv_EW0T7rTLaGQ4ActbLlUn-iREWCrhYI"
response = requests.get(f'https://www.googleapis.com/youtube/v3/search?key={api_key}&channelId={channel_url}&part=snippet,id&order=date&maxResults=1')

data = json.loads(response.text)
items = data['items']

for item in items:
    print(item)
    print("")

