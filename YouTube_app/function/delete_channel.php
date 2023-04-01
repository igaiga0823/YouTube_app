<?php 
    require('../library/user_check.php');
    require('../library/library.php');
    require('../library/dbconnect.php');

    $db = dbconnect();
    $channel_id = Get_urlparam('channel_id');

    $category_id = Get_urlparam('category_id');
    $category_name = Get_urlparam('category_name');
    // echo htmlspecialchars($category_id);
    $flag = 1;

    $stmt = $db->prepare('select channel_id from channels where user_id = ? and category_id = ?;');
    if (!$stmt) {
        die($db->error);
        $flag = 0;
    }
    $stmt->bind_param('ii', $user,$channel_id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
        $flag = 0;
    }
    $stmt->bind_result($channel_id);
    if (!isset($channel_id)){
        $flag = 0;
    }
  
    if ($flag != 0){
  
        // カテゴリの消去
        $db1 = dbconnect();
        $stmt = $db1->prepare('delete from channels where channel_id = ?;');
        echo $flag;

        if (!$stmt) {
            die($db1->error);
            $flag = 0;
        }

        $stmt->bind_param('i',$channel_id);
        $success = $stmt->execute();

        if (!$success) {
            die($db1->error);
        }
        echo "チャンネルを削除しました。<br>";


        // チャンネルの消去
        $db2 = dbconnect();
        $stmt = $db2->prepare('delete from movies where channel_id = ?;');
        echo $flag;

        if (!$stmt) {
            die($db2->error);
            $flag = 0;
        }

        $stmt->bind_param('i',$channel_id);
        $success = $stmt->execute();

        if (!$success) {
            die($db2->error);
        }
        echo "動画を削除しました。";


        ?>
        <script>        
        setTimeout(function(){
            window.location.href = '../view/view_movies.php?category_id=<?php echo $category_id; ?>&category_name=<?php echo $category_name; ?>"';
          }, 0);</script>
        <?php
        
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
