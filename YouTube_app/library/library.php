<?php 
    function Get_urlparam($keyword){
        if(isset($_GET[$keyword])) { 
            $result = $_GET[$keyword];
            return $result;
       }
    };

    function iso8601ToJST_Date($datetime) {
        $dateTimeObject = new DateTime($datetime, new DateTimeZone('Asia/Tokyo'));
        $dateTimeObject->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        return $dateTimeObject->format('m月d日');
      };

    function iso8601ToJST_Time($datetime) {
        $dateTimeObject = new DateTime($datetime, new DateTimeZone('Asia/Tokyo'));
        $dateTimeObject->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        return $dateTimeObject->format('H時i分');
      };

    function fillOrTrimJapaneseString($str) {
      $len = mb_strlen($str, 'UTF-8');
      if ($len < 12) {
        $whitespace = str_repeat(' ', 12 - $len);
        $str = $str . $whitespace;
      } else {
        $str = mb_substr($str, 0, 12, 'UTF-8');
      }
      return $str;
    }
      
    
    function get_youtube_id($url) {
      $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=))([\w-]{11})(?:\S+)?$#';
      preg_match($pattern, $url, $matches);
      return isset($matches[1]) ? $matches[1] : false;
    }
      
      
?>