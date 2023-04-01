

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
        session_start();
        $user1 = $_COOKIE['user_id'];
        $user = $_SESSION['user_id'];


        //$user=$_SESSION['user_id'];
        if (isset($user)){
            $_SESSION['user_id'] = $user;
            $rec = "User_id：" . htmlspecialchars($user) . ' こんにちは';
            ?><script>
            setTimeout(function(){
                window.location.href = './view/view_list.php';
            }, -1);
        </script>
        <?php

        } else if (isset($user1)){
            $_SESSION['user_id'] = $user1;
            $rec = "User_id：" . htmlspecialchars($user1) . ' こんにちは';
            ?><script>
            setTimeout(function(){
                window.location.href = './view/view_list.php';
            }, -1);
            </script>
        <?php
        } else {
            $rec = "初めてご利用の方はログインしてください。";
            ?>
            <script>        
            setTimeout(function(){
                window.location.href = './login/login.php';
            }, -1);
            </script>
            <?php
        }
    ?>

    <?php 
        echo $rec;
    ?>
</body>
</html>