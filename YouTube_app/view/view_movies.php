<?php 
    require('../library/user_check.php');
    require('../library/library.php');
    require('../library/dbconnect.php');

    $db = dbconnect();
    $category_id = Get_urlparam('category_id');
    $category_name = Get_urlparam('category_name');
    $movie_param = Get_urlparam('movie_url');
    $movie_name = Get_urlparam('movie_title');
    $channel_name_param = Get_urlparam('channel_name');
?>
<?php

    $stmt = $db->prepare('select channel_name,movie_url,title,thumbnail,movie_at  from movies where category_id = ? order by movie_at desc');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('i', $category_id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }
    $stmt->bind_result($channel_name,$movie_url,$title,$thumbnail,$movie_at);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="http://main.itigo.jp/main.itigo.jp/YouTube_app/img/icon.png" />
    <title><?php echo htmlspecialchars($category_name);?></title>
</head>

<header class="text-gray-50 body-font bg-indigo-500">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl text-gray-50">YouTube Categorizer</span>
    </a>
    <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
      <a href="../function/add_channel.php?category_id=<?php echo $category_id;?>&category_name=<?php echo $category_name;?>" class="mr-5 hover:text-gray-900">新規チャンネル追加</a>
      <a href="view_channel.php?category_id=<?php echo $category_id;?>&category_name=<?php echo $category_name;?>" class="mr-5 hover:text-gray-900">チャンネル一覧</a>
      <a href="view_list.php" class="mr-5 hover:text-gray-900">リスト一覧へ</a>
    </nav>
    <button onclick="location.href='../library/logout_do.php'" class="inline-flex items-center bg-gray-400 border-0 py-1 px-3 focus:outline-none hover:bg-gray-500 rounded text-base mt-4 md:mt-0">logout
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>

<body>

<div class="bg-gray-800">
  <div class="mx-auto max-w-2xl py-16 px-4 sm:py-16 sm:px-6 lg:max-w-6xl lg:px-8">
    <h1 class="text-3xl font-bold text-gray-50" ><?php echo htmlspecialchars($category_name);?></h1>

    <?php
      if(isset($movie_param)){
        $movie_id = get_youtube_id($movie_param);
        echo $channel_name_param;
        echo "<iframe style='min-height: 60vh;' class ='w-full rounded-2xl my-1.5' ' src='https://www.youtube.com/embed/{$movie_id}' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>";
        echo  "<h1 class='text-xl font-bold text-gray-50'>{$movie_name}</h1><p class='text-lg text-gray-400 '>{$channel_name_param}</p><br>";
        }
    ?>

    <h2 class="text-3xl font-bold tracking-tight text-gray-50">Contents</h2>

    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
      
    <?php while ($stmt->fetch()): ?>
      <div class="group relative">
        <div class="min-h-45 aspect-auto w-auto overflow-hidden rounded-xl bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-45">
          <img src="<?php echo htmlspecialchars($thumbnail)?>" alt="Front of men&#039;s Basic Tee in black." class=" w-full object-cover object-center lg:w-full"/>
        </div>
        <div class="mt-4 flex justify-between">
          <div>
            <h3 class="text-sm text-gray-100">
              <a href="../view/view_movies.php?category_id=<?php echo $category_id; ?>&category_name=<?php echo $category_name; ?>&movie_url=<?php echo $movie_url; ?>&movie_title=<?php echo $title; ?>&channel_name=<?php echo $channel_name; ?>" >
                <span aria-hidden="true" class="absolute inset-0"></span>
                <?php echo htmlspecialchars(mb_substr($title, 0, 50)); ?>
              </a>
            </h3>
            <p class="mt-1 text-sm  text-gray-200"><?php echo htmlspecialchars($channel_name);?>
            <br>
            投稿日：<?php echo htmlspecialchars(iso8601ToJST_Date($movie_at)) . ' ' . htmlspecialchars(iso8601ToJST_Time($movie_at)); ?>
            </p>

          </div>
          <br>
          <p class="text-sm font-medium 0 text-white"></p>
        </div>
      </div>
    <?php endwhile; ?>

    </div>
  </div>
</div>



</body>
</html>
