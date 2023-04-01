<?php 
    require('../library/user_check.php');
    require('../library/dbconnect.php');
    require('../library/library.php');
    $db = dbconnect();

?>
<?php
    $stmt = $db->prepare('select category_id, category_name, created_at from categories where user_id = ?');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('i', $user);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }
    $stmt->bind_result($category_id,$category_name,$created_at);
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="http://main.itigo.jp/main.itigo.jp/YouTube_app/img/icon.png" />
    <title>YouTubeカテゴリ一覧</title>
</head>

<header class="text-gray-50 body-font bg-indigo-500">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl text-gray-50">YouTube movies</span>
    </a>
    <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
      <a href="../function/add_list.php" class="mr-5 hover:text-gray-900">新規リスト追加</a>

    </nav>
    <button onclick="location.href='../library/logout_do.php'" class="inline-flex items-center bg-gray-400 border-0 py-1 px-3 focus:outline-none hover:bg-gray-500 rounded text-base mt-4 md:mt-0">logout
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>

<body>

<section class="text-gray-600 body-font bg-gray-800">
  <div class="container px-5 py-24 mx-auto">

    <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
      <h1 class="text-4xl font-semibold title-font mb-2 text-gray-50">登録カテゴリ一覧</h1>
      <p class="text-xl lg:w-1/2 w-full leading-relaxed text-gray-50">どのリストを視聴したいか選択してください</p>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
    <?php while ($stmt->fetch()): ?>
      <div class="group relative text-center">
        <div class="min-h-45 aspect-auto w-auto overflow-hidden border-4 border-sky-800 border-opacity-70 p-6 rounded-3xl bg-white bg-opacity-10">
          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
          </div>
          <h1 class="text-4xl text-gray-50 font-medium title-font mb-2"><a href="view_movies.php?category_id=<?php echo $category_id; ?>&category_name=<?php echo $category_name; ?>"><?php echo fillOrTrimJapaneseString(htmlspecialchars($category_name)); ?></a></h1>
          <p class="leading-relaxed text-base text-gray-50"><?php echo htmlspecialchars($created_at); ?></p>
          <button class="flex mx-auto mt-2 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">準備中</button>
        </div>
      </div>
      <?php endwhile; ?>
    </div>



  </div>
</section>


</body>
</html
