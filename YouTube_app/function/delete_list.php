<?php 
    require('../library/user_check.php');
    require('../library/library.php');
    require('../library/dbconnect.php');

    $db = dbconnect();
    $category_id = Get_urlparam('category_id');
    // echo htmlspecialchars($category_id);
    $flag = 1;

    $stmt = $db->prepare('select category_id, category_name, created_at from categories where user_id = ? and category_id = ?;');
    if (!$stmt) {
        die($db->error);
        $flag = 0;
    }
    $stmt->bind_param('ii', $user,$category_id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
        $flag = 0;
    }
    $stmt->bind_result($category_id,$category_name,$created_at);
    if (!isset($category_id)){
        $flag = 0;
    }
  
    if ($flag != 0){
  
        // カテゴリの消去
        $db1 = dbconnect();
        $stmt = $db1->prepare('delete from categories where category_id = ?;');
        echo $flag;

        if (!$stmt) {
            die($db1->error);
            $flag = 0;
        }

        $stmt->bind_param('i',$category_id);
        $success = $stmt->execute();

        if (!$success) {
            die($db1->error);
        }
        echo "削除しました。<br>";


        // チャンネルの消去
        $db2 = dbconnect();
        $stmt = $db2->prepare('delete from channels where category_id = ?;');
        echo $flag;

        if (!$stmt) {
            die($db2->error);
            $flag = 0;
        }

        $stmt->bind_param('i',$category_id);
        $success = $stmt->execute();

        if (!$success) {
            die($db2->error);
        }
        echo "チャンネルを削除しました。";

        //動画の消去
        $db3 = dbconnect();
        $stmt = $db3->prepare('delete from movies where category_id = ?;');
        echo $flag;

        if (!$stmt) {
            die($db3->error);
            $flag = 0;
        }

        $stmt->bind_param('i',$category_id);
        $success = $stmt->execute();

        if (!$success) {
            die($db3->error);
            ?>
            <script>        
            setTimeout(function(){
                window.location.href = '../view/view_list.php';
              }, 0);</script>
            <?php
        }
        echo "動画を削除しました。";
    }
    else {

        ?>
        <script>        
        setTimeout(function(){
            window.location.href = '../index.php';
          }, 0);</script>
        <?php
    }
    
?>
