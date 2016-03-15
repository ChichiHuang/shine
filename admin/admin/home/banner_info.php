<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/banner.php'; 
}
//圖片路徑
$image_dir=constant("BANNER_URL");
//取得契約資訊
$banner=getBannerInfo($db,$_GET["banner_id"]); 
foreach( $banner as $banner_info )
{
  $name=$banner_info["title"];
  $image=$banner_info["image"];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link href="../../plugins/select2/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../../plugins/drift/drift-basic.min.css">
    <style type="text/css">

      .drift-demo-trigger {
        width: 40%;
        float: left;
      }

      .detail {
        position: relative;
        width: 55%;
        margin-left: 5%;
        float: left;
      }

      .ix-link {
        display: block;
        margin-bottom: 3em;
      }

      @media (max-width: 900px) {
        .detail, .drift-demo-trigger {
          float: none;
        }

        .drift-demo-trigger {
          max-width: 100%;
          width: auto;
          margin: 0 auto;
        }

        .detail {
          margin: 0;
          width: auto;
        }
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body">
              <h4>名稱：<?php echo $name;?></h4>
              <div class="wrapper">
                <img class="drift-demo-trigger" data-zoom="<?php echo $image_dir.$image; ?>?w=1200&amp;ch=DPR&amp;dpr=2" src="<?php echo $image_dir.$image; ?>?w=400&amp;ch=DPR&amp;dpr=2">
                <div class="detail"></div>
              </div>         
            </div><!-- /.box-body -->
            <div class="box-footer"> </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </section><!-- /.主要內容 --> 
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->

   <?php require '../common/footer-js.php';?>  

  <script src="../../plugins/select2/select2.min.js"></script>
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="../../plugins/drift/Drift.min.js"></script>

  <script>
  new Drift(document.querySelector('.drift-demo-trigger'), {
        paneContainer: document.querySelector('.detail'),
        inlinePane: 900,
        inlineOffsetY: -85,
        containInline: true
      });
  $(document).ready(function() {

  });
   </script>
  </body>
</html>
