# -*- coding: utf-8 -*-
from flask import Flask , render_template, request
import json

app = Flask(__name__)


@app.route('/')
def hello():
    return 'ok'

@app.route('/youtuber_search', methods=["GET"])
def hello1():
    try:
        req = request.args
        content = req.get("keyword")
        keyword, api = map(str,content.split(','))
        response = Youtuber_search(keyword,api)
        return response
    except:

        return 'sorry1'


@app.route('/render')
def index():
    return render_template('render.html')



from apiclient.discovery import build
import os

# API情報




def Youtuber_search(key_word,API_KEY):
    YOUTUBE_API_SERVICE_NAME = 'youtube'
    YOUTUBE_API_VERSION = 'v3'
    try:
        youtube = build(
            YOUTUBE_API_SERVICE_NAME, 
            YOUTUBE_API_VERSION,
            developerKey=API_KEY
            )

        search_response = youtube.search().list(
        q='['+key_word+']',
        part='id,snippet',
        maxResults=5
        ).execute()

        channels = list()

        for search_result in search_response.get("items", []):
            if search_result["id"]["kind"] == "youtube#channel":
                channels.append({"channel_name":search_result["snippet"]["title"],"channel_id":search_result["id"]["channelId"]})
        if len(channels)==0:
            try:
                API_KEY = os.environ.get("Youtube_API_KEY")
                youtube = build(
                    YOUTUBE_API_SERVICE_NAME, 
                    YOUTUBE_API_VERSION,
                    developerKey=API_KEY
                    )

                search_response = youtube.search().list(
                q='['+key_word+']',
                part='id,snippet',
                maxResults=5
                ).execute()

                channels = []
                for search_result in search_response.get("items", []):
                    if search_result["id"]["kind"] == "youtube#channel":
                        channels.append([search_result["snippet"]["title"],
                                                search_result["id"]["channelId"]])
                if len(channels)==0:
                    API_KEY = os.environ.get("Youtube_API_KEY1")
                    youtube = build(
                        YOUTUBE_API_SERVICE_NAME, 
                        YOUTUBE_API_VERSION,
                        developerKey=API_KEY
                        )

                    search_response = youtube.search().list(
                    q='['+key_word+']',
                    part='id,snippet',
                    maxResults=5
                    ).execute()

                    channels = []
                    for search_result in search_response.get("items", []):
                        if search_result["id"]["kind"] == "youtube#channel":
                            channels.append([search_result["snippet"]["title"],
                                                    search_result["id"]["channelId"]])
            except:
                pass
            

 
    except:
        try:
            #API_KEY = os.environ.get("Youtube_API_KEY")
            API_KEY = "AIzaSyCkrd8svoDBtCEgl-ep7MXCmL1Xc9ETyC0"
            youtube = build(
                YOUTUBE_API_SERVICE_NAME, 
                YOUTUBE_API_VERSION,
                developerKey=API_KEY
                )

            search_response = youtube.search().list(
            q='['+key_word+']',
            part='id,snippet',
            maxResults=5
            ).execute()

            channels = []
            for search_result in search_response.get("items", []):
                if search_result["id"]["kind"] == "youtube#channel":
                    channels.append([search_result["snippet"]["title"],
                                            search_result["id"]["channelId"]])
        except:
            #API_KEY = os.environ.get("Youtube_API_KEY1")
            API_KEY = "AIzaSyCUSsywZ71ajGfX9NeaQb-W43sKmh64shs"
            youtube = build(
                YOUTUBE_API_SERVICE_NAME, 
                YOUTUBE_API_VERSION,
                developerKey=API_KEY
                )

            search_response = youtube.search().list(
            q='['+key_word+']',
            part='id,snippet',
            maxResults=5
            ).execute()

            channels = []
            for search_result in search_response.get("items", []):
                if search_result["id"]["kind"] == "youtube#channel":
                    channels.append([search_result["snippet"]["title"],
                                            search_result["id"]["channelId"]])

    return json.dumps(channels, ensure_ascii=False, indent=2)



if __name__ == '__main__':
    app.run(debug=True)