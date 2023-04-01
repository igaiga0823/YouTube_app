<?php

    require('../library/get_api.php');

    $URL = "http://main.itigo.jp/main.itigo.jp/Youtube_api/index.cgi/youtuber_search?keyword=ヒカキン,{$api}"; //取得したいサイトのURL
    $html_source = file_get_contents($URL);
    $data = json_decode($html_source, true);
    echo htmlspecialchars($data[0]['channel_name']);
    $flag = 0


?>