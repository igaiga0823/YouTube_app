<?php
    session_start();
//DB内でPOSTされたメールアドレスを検索
    require('dbconnect.php');
    
    $db = dbconnect();
    $user = $_SESSION['user_id'];
  
    $stmt = $db->prepare('select API from users where id = ?');
    if (!$stmt) {
        die($db->error);
    }
        $stmt->bind_param('s', $user);
        $success = $stmt->execute();

    if (!$success) {
        die($db->error);
    }
    $stmt->bind_result($api);
    $row = $stmt->fetch();


    if (!isset($api)) {
        echo 'apiが存在していません';
        return false;
    }

?>