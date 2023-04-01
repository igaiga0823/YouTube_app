

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
        require('../library/dbconnect.php');

        session_start();


        $name = $_POST['name'];
        echo htmlspecialchars($_POST['password']);
        //$password = password_hash($_POST['password'], PASSWORD_ARGON2I);
        $password = $_POST['password'];


        //DB内でPOSTされたメールアドレスを検索
        $db = dbconnect();

        if ($db->connect_error) {
            echo $db->connect_error;
            exit();
        } else {
            $db->set_charset("utf8");
        }

        $stmt = $db->prepare('select id from users where name = ? AND password = ?');
        if (!$stmt) {
            die($db->error);
        }
            $stmt->bind_param('ss', $name, $password);
            $success = $stmt->execute();

        if (!$success) {
            die($db->error);
        }
        $stmt->bind_result($id);
        $row = $stmt->fetch();




        if (!isset($id)) {
            echo '名前又はパスワードが間違っています。';
            return false;
        }
        else{
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['user_id'] = $id;
            setcookie('user_id',$id,time()+36000);
            echo 'ログインしました' . htmlspecialchars($id);
            ?>
            <script>
                setTimeout(function(){
                    window.location.href = '../index.php';
                }, 0);
            </script>
        <?php
        }
    ?>
</body>

