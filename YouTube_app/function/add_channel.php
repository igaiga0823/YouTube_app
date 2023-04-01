
<?php 
    require('../library/user_check.php');
    require('../library/library.php');

    require('../library/get_api.php');

    $db = dbconnect();
    $category_id = Get_urlparam('category_id');
    $category_name = Get_urlparam('category_name');

    $flag = 0;
    $api = "AIzaSyDPShdEbIevCLf5IG41CY4bKafy9cQkE20";
    if(isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
        $URL = "http://main.itigo.jp/main.itigo.jp/Youtube_api/index.cgi/youtuber_search?keyword={$keyword},$api"; //取得したいサイトのURL
        $html_source = file_get_contents($URL);

        $data1 = json_decode($html_source, true);
        if(isset($data1[0]['channel_name'])){$flag = -1;}
        else{$flag = 1;}
    }        




?>
<?php



?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャンネルの検索</title>
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
      <a href="../view/view_list.php" class="mr-5 hover:text-gray-900">リストに戻る</a>

    </nav>
    <button onclick="location.href='../library/logout_do.php'" class="inline-flex items-center bg-gray-400 border-0 py-1 px-3 focus:outline-none hover:bg-gray-500 rounded text-base mt-4 md:mt-0">logout
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>

<body>


<section class="text-gray-600 body-font bg-gray-800 justify-center">
  <div class=" px-5 py-12 mx-auto">

    <div class="flex flex-wrap w-full mb-1 flex-col items-center text-center">
      <h1 class="text-4xl font-semibold title-font mb-2 text-gray-50">新規チャンネル検索</h1>
      <p class="text-xl lg:w-1/2 w-full leading-relaxed text-gray-50">どのチャンネルを追加したいか入力してください</p>
      <br>
      <form action="" method="post">
      <div class="mt-6 flex max-w-md gap-x-4">
          <label for="keyword" class="sr-only">チャンネル名</label>
          <input id="keyword" name="keyword" type="text" required class="min-w-0 flex-auto rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="チャンネル名">
          <button type="submit" class="flex-none rounded-md bg-indigo-500 py-2.5 px-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">検索する</button>
        </div>
      </form>
    </div>

  </div>

  <div class="items-center text-center container mx-auto">
    <?php 

        foreach($data1 as $channel){
            ?>

            <form action="add_channel_python.php" method="post">
                <div class="p-4 justify-center">
                    <div class="border-4 border-sky-800 border-opacity-70 p-6 rounded-3xl bg-white bg-opacity-10 justify-center">
                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                        <input type="hidden" id="user_id" name="user_id" value = "<?php echo htmlspecialchars($user);?>">
                        <input type="hidden" id="category_id" name="category_id" value = "<?php echo htmlspecialchars($category_id);?>">
                        <input type="hidden" id="channel_name" name="channel_name" value ="<?php echo htmlspecialchars($channel['channel_name']);?>">
                        <input type="hidden" id="channel_url" name="channel_url" value = "<?php echo htmlspecialchars($channel['channel_id']);?>">
                    </div>
                    <h1 class="text-4xl text-gray-50 font-medium title-font mb-2"><?php echo htmlspecialchars($channel['channel_name']) ;?></h1>
                    <p class="leading-relaxed text-base text-gray-50"><?php echo htmlspecialchars($created_at); ?></p>
                    <button type="submit" class="flex mx-auto mt-3 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                    </div>
                </div>  
            </form>
        <?php
        }
    ?>
    </div>

</section>

</body>
</html>