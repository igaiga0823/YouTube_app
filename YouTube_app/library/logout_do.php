<?php
    session_start();
    unset($_SESSION['user_id']);
    setcookie('user_id',$id,time()-100);
    require('user_check.php');
?>