<?php 
    require('../library/user_check.php');
    require('../library/library.php');
    require('../library/dbconnect.php');
    require('../library/get_api.php');

    $db = dbconnect();
    $category_name = $_POST['category_name'];
    $flag = 0;

    if(isset($_POST['category_name'])){
        $URL = "http://main.itigo.jp/main.itigo.jp/Youtube_api/index.cgi/youtuber_search?keyword=ヒカキン,{$api}"; //取得したいサイトのURL
        $html_source = file_get_contents($URL);
        $data = json_decode($html_source, true);
        echo htmlspecialchars($data[0]['channel_name']);
        if(isset($data[0])){$flag = 1}
    }

?>
<?php


    if(isset($category_name)){


        $stmt = $db->prepare('insert into categories (category_name, user_id) value(?,?)');
        if (!$stmt) {
            die($db->error);
        }
        $stmt->bind_param('si', $category_name,$user);
        $success = $stmt->execute();
        if (!$success) {
            die($db->error);
        }
        $test_alert = "<script type='text/javascript'>alert('リストが作成できました。');</script>";
        echo $test_alert;
        ?><script>
        setTimeout(function(){
            window.location.href = '../view/view_list.php';
          }, 0);
    </script>
    <?php
    }


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャンネルの追加</title>
</head>
<body>
<form action="" method="post">
        <div>
            <label for="category_name">チャンネル名</label>
            <input type="text" id="category_name" name="category_name">
        </div>

        <input type="submit" value="送信する">
    </form>

    <?php 
        forearch($channel as &$data){
            echo htmlspecialchars($channel['channel_name']);
        }
    
    ?>
</body>
</html>