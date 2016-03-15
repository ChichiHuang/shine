<?php 
session_start();
require '../login/formTokenCheck.php'; 
//取得Token
$token=getToken();
if($_GET['error']=='token')
{     
 echo "<script>alert('Token已過期，請重新登入');</script>";
}
if($_GET['error']=='expire')
{     
 echo "<script>alert('登入狀態已過期，請重新登入');</script>";
}
if($_GET['error']=='notlogin')
{  
 echo "<script>alert('尚未登入');</script>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>響享文創後台| 登入</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- validetta -->
    <link href="../../plugins/validetta/validetta.css" rel="stylesheet" type="text/css" media="screen" >
    <link rel="stylesheet" href="../../plugins/lobibox/lobibox.min.css" type="text/css" media="screen" />     
  </head>
  <body class="hold-transition login-page">
    <div class="login-box"> 
      <div class="login-box-body">
        <p class="login-box-msg">響享文創 後台登入</p>
        <div id="alert"></div>
        <form method="post" id="exm">
          <div class="form-group has-feedback">
            <input type="name" name="name" class="form-control" placeholder="帳號" data-validetta="required" maxlength="20">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="密碼" name="password" data-validetta="required" maxlength="20">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <img src="captcha.php"/>
            <input type="text" name="captcha" id="captcha" maxlength="6" size="6" data-validetta="required">        
          </div>
          <div class="row">       
            <div class="col-xs-4">
              <input type="hidden" class="form-control"  name="refer" value="<?php echo $refer; ?>">
              <?php  echo getTokenField(); ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">登入</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- 驗證模組 -->
    <script type="text/javascript" src="../../plugins/validetta/validetta.js"></script>
    <!-- 警示模組 -->
    <script src="../../plugins/lobibox/lobibox.js"></script>
     
    <script>
      $(function () {
        //驗證表單
        $('#exm').validetta({

          onValid : function( event ) {

            event.preventDefault();
            var name=$('input[name="name"]').val();
            var password=$('input[name="password"]').val();
            var captcha=$('input[name="captcha"]').val();
            var token=$('input[name="token"]').val();        
            $.ajax({
              url:"loginCheck.php",
              data:"username="+name+"&password="+password+"&captcha="+captcha+"&token="+token,
              type : "POST",
              beforeSend:function(){
                 
              },
              success:function(msg){
                
                var data=JSON.parse(msg);     
                if(data.result==1)
                {
                  $('#alert').empty();
                  Lobibox.alert('success', {
                    msg: data.text,
                    callback: function(lobibox, type){

                      window.location = "../common/index.php?token=<?php echo $token;?>";
                       
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
                  alert('Ajax request 發生錯誤');
              },
              complete:function(){
                  
              }
            });//.ajax     
          },
          onError : function( event ){
              $('#alert').empty()
                  .append('<div class="alert alert-danger">出現錯誤！</div>');
          }
        });  
      });
    </script>
  </body>
</html>
