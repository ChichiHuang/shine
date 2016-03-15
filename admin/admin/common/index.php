<?php 
require '../login/checkAdminSession.php';
if(login_check()==true)
{
  require '../model/config.php';
} 

?>
<!DOCTYPE html>
<html>
  <head>
      <?php require '../common/head.php';?>
  </head>
  <body class="hold-transition skin-yellow-light sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
          <?php require '../common/header.php';?>
      </header>
      <aside class="main-sidebar">
           <?php require '../common/menu.php';?>
      </aside>
      <!-- =============================================== -->
      <!--真的會改到的內容 -->
      <div class="content-wrapper">
        <!-- 頁面上方 -->
        <section class="content-header">
          <h4>首頁</h4>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
     
     

        </section><!-- /.主要內容 -->

     <!-- =============================================== -->    
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <?php require '../common/footer.php';?>     
      </footer>
  
    </div><!-- ./wrapper -->

   <?php require '../common/footer-js.php';?>     
  </body>
</html>
