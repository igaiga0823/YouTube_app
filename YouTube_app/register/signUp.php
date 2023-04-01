

<?php
session_start();
require('../library/dbconnect.php');

//データベースへ接続、テーブルがない場合は作成
$name = $_POST['name'];
$password = $_POST['password'];
$mail = $_POST['mail'];
$API = $_POST['API'];

$mysqli = dbconnect();

if ($mysqli->connect_error) {
  echo $mysqli->connect_error;
  exit();
} else {
  $mysqli->set_charset("utf8");
}

if (!$mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,100}+\z/i', $_POST['password'])) {
  //$password = password_hash($_POST['password'], PASSWORD_ARGON2I);
  $password = $_POST['password'];
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  return false;
}
//登録処理
try {
  $stmt = $mysqli->prepare("insert into users (name, password, API, mail) value (?, ?, ?, ?)");
  $stmt->bind_param('ssss', $name, $password, $API, $mail);
  $stmt->execute();
  echo '登録完了';

  $stmt_2 = $mysqli->prepare('select id from users where name = ? AND password = ?');
  if (!$stmt_2) {
      die($mysqli->error);
  }
      $stmt_2->bind_param('ss', $name, $password);
      $success = $stmt_2->execute();

  if (!$success) {
      die($mysqli->error);
  }
  $stmt_2->bind_result($id);
  $row = $stmt_2->fetch();
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  // 所定のセッションを削除
  unset($_SESSION['user_id']);
  $_SESSION['user_id'] = $id;

  setcookie('user_id',$id,time()+3600);
  echo 'ログインします' . htmlspecialchars($id);
  ?>
  <script>
    setTimeout(function(){
      window.location.href = '../index.php';
    }, 2*1000);
  </script>
  <?php
} catch (\Exception $e) {
  echo '登録済みのメールアドレスです。';
}

?>
