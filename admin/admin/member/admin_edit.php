<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/admin.php'; 
}
$admin=getAdminInfo($db,$_GET["admin_id"]); 
foreach( $admin as $admin_info )
{
  $name=$admin_info["admin_name"];
  $username=$admin_info["admin_username"];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link href="../../plugins/select2/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../plugins/lobibox/lobibox.min.css" type="text/css" media="screen" />
  </head>
  <body class="hold-transition skin-yellow-light">
    <div class="wrapper">
      <header class="main-header">
        <?php require '../common/header.php';?>
      </header>
      <aside class="main-sidebar">
        <?php require '../common/menu.php';?>
      </aside>
      <div class="content-wrapper">
        <!-- 頁面上方 -->
        <section class="content-header">
          <h1>編輯管理員資料</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
          <!-- 白色底的框框 -->
          <div class="box">
          <!-- Button trigger modal -->
            <div class="box-header with-border">
              <h3 class="box-title">管理員帳號: <?php echo $username;?></h3>  
            </div>
            <div class="box-body">  
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="name">名稱*</label>
                  <input type="text" id="name" name="name" class="form-control" value="<?php echo $name;?>">  
                </div>       
                <div class="control-group">
                  <label class="control-label" for="username">帳號*</label>
                  <input type="text" id="username" name="username" class="form-control" value="<?php echo $username;?>"> 
                </div>
                <div class="control-group">
                  <label class="control-label" for="pass">密碼*</label>
                  <input type="password" id="pass" name="pass" class="form-control" value=""> 
                </div>
                <div class="control-group">
                  <label class="control-label" for="pass2">確認密碼*</label>
                  <input type="password" id="pass2" name="pass2" class="form-control" value=""> 
                </div>    
                <hr></hr>     
                <br>
                <!-- 警示顯示 -->
                <div id="result"></div>
                <div class="text-center">
                  <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認儲存</button>   
                </div>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
                <input type="hidden" name="admin_id" value="<?php echo $_GET["admin_id"];?>" />
              </form>      
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </section><!-- /.主要內容 -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php require '../common/footer.php';?>     
      </footer> 
    </div><!-- ./wrapper -->
    <?php require '../common/footer-js.php';?>    
    <script src="../../plugins/jquery-confirm/jquery.confirm.min.js"></script>
    <script src="../../plugins/lobibox/lobibox.js"></script>

    <script>
    $(document).ready(function() {

      var token=$('input[name="token"]').val();

      //確認送出
      $('#submit_form').click(function() {

        $('#result').empty();
        var result_content="";

        if(!$('input[name="name"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫名稱</div>';
          $('#result').html(result_content);
          $('input[name="name"]').focus();
          return false;
        }
        else if(!$('input[name="username"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫帳號</div>';
          $('#result').html(result_content);
          $('input[name="username"]').focus();
          return false;
        }
        else if(!$('input[name="pass"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫密碼</div>';
          $('#result').html(result_content);
          $('input[name="pass"]').focus();
          return false;
        }
        else if(!$('input[name="pass2"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請確認密碼</div>';
          $('#result').html(result_content);
          $('input[name="pass2"]').focus();
          return false;
        }
        else if($('input[name="pass2"]').val()!=$('input[name="pass"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">密碼有誤，請重新輸入</div>';
          $('#result').html(result_content);
          $('input[name="pass2"]').val('');
          $('input[name="pass"]').val('');
          $('input[name="pass"]').focus();
          return false;
        }
        else{

          var username=$('input[name="username"]').val();
          var name=$('input[name="name"]').val();
          var pass1=$('input[name="pass"]').val();
          var admin_id=$('input[name="admin_id"]').val();

          $.ajax({
            url:"../controller/admin.php",
            data:{action:'update',id:admin_id,token:token,name:name,username:username,password:pass1},
            type : "POST",
            success:function(msg){

              var data=JSON.parse(msg);
              if(data.result==1)
              {
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    window.location.href = 'admin_list.php?token='+token;
                     
                  }
                });
              }
              else
              {
                Lobibox.alert('error', {
                  msg: data.text
                });
              }                           
            },
            error:function(xhr){
              Lobibox.alert('error', {
                msg: 'Ajax request 發生錯誤'
              });
            }
          });          
        }  
      });           
    });
 
    </script>
  </body>
</html>
