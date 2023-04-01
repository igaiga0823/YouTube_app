<?php 
    require('../library/user_check.php');
    require('../library/dbconnect.php');
    require('../library/library.php');
    $db = dbconnect();
    require('../library/logout.php');

    $category_id = Get_urlparam('category_id');
    $category_name = Get_urlparam('category_name');

?>
<?php
    $stmt = $db->prepare('select channel_name, channel_id from channels where category_id = ?');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('i', $category_id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }
    $stmt->bind_result($channel_name,$channel_id);
    echo htmlspecialchars($category_id);
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="http://main.itigo.jp/main.itigo.jp/YouTube_app/img/icon.png" />
    <title>登録チャンネル一覧</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($category_name); ?></h1>
    <a href="../function/add_channel.php?category_id=<?php echo $category_id;?>&category_name=<?php echo $category_name;?>" class="">新規チャンネル追加</a><br>
    <?php while ($stmt->fetch()): ?>
        <div>
            <h2><a href="#?channel_id=<?php echo $channel_id; ?>&category_name=<?php echo $channel_name; ?>"><?php echo htmlspecialchars(mb_substr($channel_name, 0, 50)); ?></a></h2>
            <button onclick="location.href='../function/delete_channel.php?channel_id=<?php echo $channel_id;?>&category_id=<?php echo $category_id;?>&category_name=<?php echo $category_name; ?>'">削除</button>
        </div>
        <hr>
    <?php endwhile; ?>

    
</body>
</html
