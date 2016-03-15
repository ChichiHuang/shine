<?php 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>響享 -PHP範例</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="http://daiyang.liorsinc.com/_includes/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style type="text/css">
    body{

      font-family:"微軟正黑體";
    }
    </style>
  </head>
  <body class="container">
    <h2>

    </h2>
    <h1>主機相關資訊</h1>
    <pre>
    ftp
    主機：
    帳號：
    密碼：
    </pre>
    <h1>後台資訊</h1>
    <pre>
    後台：
    帳號：admin
    密碼：admin
    </pre>
    <h1>資料庫物件初始化</h1>
    <pre>
    require '_includes/model/config.php';
    </pre>
    <hr></hr>
    <h1>BANNER資訊</h1>
    <pre>
    require '_includes/model/banner.php';

    //BANNER路徑
    $image_dir=constant("BANNER_URL");
    
    所有BANNER列表:  getBanners($db,constant("SITE")); 

    foreach( $banners  as $banner )
    {
      //BANNER id
      echo $banner["banner_id"];
      //圖片
      echo $banner["image"];
    }
    </pre>
    <h1>大記事</h1>
    <pre>
    require '_includes/model/milestone.php';

    單一大紀事資訊:  getMilestoneInfo($db,id);
    所有大紀事列表:  getMilestones($db,constant("SITE"));

    foreach( $milestones  as $milestone )
    {
      //id
      echo $milestone["milestone_id"];
      //日期
      echo $milestone["date"];
      //內容
      echo $milestone["content"];
      //標題
      echo $milestone["title"];

    }
    </pre>
    
    
    <h1>新聞資訊</h1>
    <pre>
    require '_includes/model/news.php';

    單一新聞資訊:  getNewsInfo($db,id); 
    所有新聞列表:  getAllNews($db,constant("SITE")); 

    foreach( $news  as $new )
    {
      //消息id
      $new["news_id"];
      //日期
      $new["date"];
      //標題
      $new["title"];
      //內容
      $new["content"];
    } 
    </pre>

    <h1>影片資訊</h1>
    <pre>
    require '_includes/model/media.php';

    單一影片資訊:  getMediaInfo($db,news_id); 
    所有影片列表:  getMedias($db,'video'); 

    foreach( $medias  as $media )
    {
      //id
      $media["media_id"];
      //日期
      $media["date"];
      //標題
      $media["title"];
      //內容
      $media["content"];
    } 
    </pre>
    
    <h1>照片資訊</h1>
    <pre>
    require '_includes/model/media.php';
    $image_dir=constant("MEDIA_URL");

    單一影片資訊:  getMediaInfo($db,news_id); 
    所有影片列表:  getMedias($db,'image'); 

    foreach( $medias  as $media )
    {
      //id
      $media["media_id"];
      //日期
      $media["date"];
      //標題
      $media["title"];
      //內容
      $media["content"];
    } 
    </pre>
  
    <hr></hr>
    <script src="http://daiyang.liorsinc.com/_includes/dist/js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="http://daiyang.liorsinc.com/_includes/dist/js/bootstrap.min.js"></script>
   
  </body>
</html>

