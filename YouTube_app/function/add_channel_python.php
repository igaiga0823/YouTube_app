<!DOCTYPE html>
<html lang="ja">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="http://main.itigo.jp/main.itigo.jp/YouTube_app/img/icon.png" />
    <title>YouTube Categorizer</title>
</head>
<body class = "bg-gray-800">

    <?php 
        require('../library/user_check.php');
        require('../library/library.php');
        require('../library/dbconnect.php');

        // user
        // category
        // channel_url

        session_start();

        //データベースへ接続、テーブルがない場合は作成
        $user_id = $_POST['user_id'];
        $category_id = $_POST['category_id'];
        $channel_url = $_POST['channel_url'];
        $channel_name = $_POST['channel_name'];

        echo htmlspecialchars($user_id);
        echo htmlspecialchars($category_id);
        echo htmlspecialchars($channel_url);

        $mysqli = dbconnect();
        
        if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
        } else {
        $mysqli->set_charset("utf8");
        }

        $value = 1;
        $stmt = $mysqli->prepare("insert into channels (channel_name, user_id, category_id, channel_url, seen) value (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $channel_name, $user_id, $category_id, $channel_url, $value);
        $stmt->execute();
        echo '登録完了';


        echo htmlspecialchars($channel_name) . " チャンネル登録が完了しました<br>";

    ?>
    <script>        
    setTimeout(function(){
        window.location.href = '../view/view_list.php';
        }, -1);</script>

</body>

