<?php 
require '../login/checkAdminSession.php';
if(login_check()==true)
{
  require '../model/config.php';
}
$type=$_GET["type"];
$site_title=set_title($type);
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link rel="stylesheet" href="../../plugins/lobibox/lobibox.min.css" type="text/css" media="screen" />
  </head>
  <body class="hold-transition skin-yellow-light">
    <div class="wrapper">
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 頁面上方 -->
        <section class="content-header" >
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-新增BANNER</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body">         
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="name">名稱</label>
                  <input type="text" id="name" name="name" class="form-control" value="">  
                </div><!-- /.control-group -->
                 <div class="row" style="padding-top:10px;">
                  <div class="col-xs-12">
                     <div class="input-group">
                      <input type="text" name="image" class="form-control" disabled="disabled">
                      <span class="input-group-btn">
                        <button id="uploadBtn" class="btn btn-large btn-primary">選擇圖片</button>
                      </span>
                    </div><!-- /input-group -->
                  </div>
                </div>
                <div class="row" style="padding-top:10px;">
                  <div class="col-xs-12">
                    <div id="progressOuter" class="progress progress-striped active" style="display:none;">
                      <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                  </div>
                </div>
                <div class="row" style="padding-top:10px;">
                  <div class="col-xs-10">
                    <div id="msgBox"></div>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="sort">排序</label>
                  <input type="number" id="sort" name="sort" class="form-control" value="0">  
                </div><!-- /.control-group -->
                <br>
                <div id="result"></div>
                <div class="text-center">
                  <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認新增</button>   
                </div>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
                <input type="hidden" name="type" value="<?php echo $type;?>" />
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer"> </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </section><!-- /.主要內容 -->
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
  <?php require '../common/footer-js.php';?>  
  <script src="../../plugins/simple-upload/SimpleAjaxUploader.js"></script>
  <script src="../../plugins/lobibox/lobibox.js"></script>

  <script>
 
  $(document).ready(function() {
        
    var token=$('input[name="token"]').val();
    var banner_type=$('input[name="type"]').val();
    var result_content='';
    
    $('#submit_form').click(function() {

       $('#result').empty();
       result_content="";

        if(!$('input[name="name"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫名稱</div>';
          $('#result').html(result_content);
          $('input[name="title"]').focus();
          return false;
        }
        else if(!$('input[name="image"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請選擇圖片</div>';
          $('#result').html(result_content);
          $('input[name="image"]').focus();
          return false;
        }
        else if(!$('input[name="sort"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫排序</div>';
          $('#result').html(result_content);
          $('input[name="sort"]').focus();
          return false;
        }
        else{

          var name = $('input[name="name"]').val();
          var image = $('input[name="image"]').val();
          var sort = $('input[name="sort"]').val();

          $.ajax({
            url:"../controller/banner.php",
            data:{action:'insert',title:name,token:token,image:image,sort:sort,type:banner_type},
            type : "POST",
            success:function(msg){

              var data=JSON.parse(msg);
              if(data.result==1)
              {
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    parent.location.href="banner_list.php?token="+token+'&type='+banner_type;
                     
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
                msg: 'Ajax request 發生錯誤',
              });
            }
          });//.ajax 
        }//.else  
    });//submit click

    //上傳圖片
    function escapeTags( str ) {
      return String( str )
               .replace( /&/g, '&amp;' )
               .replace( /"/g, '&quot;' )
               .replace( /'/g, '&#39;' )
               .replace( /</g, '&lt;' )
               .replace( />/g, '&gt;' );
    }

    window.onload = function() {

      var btn = document.getElementById('uploadBtn'),
          progressBar = document.getElementById('progressBar'),
          progressOuter = document.getElementById('progressOuter'),
          msgBox = document.getElementById('msgBox');

      var uploader = new ss.SimpleUpload({
            button: btn,
            url: '../controller/banner_upload.php',
            name: 'uploadfile',
            multipart: true,
            hoverClass: 'hover',
            focusClass: 'focus',
            responseType: 'json',
            startXHR: function() {
                progressOuter.style.display = 'block'; // make progress bar visible
                this.setProgressBar( progressBar );
            },
            onSubmit: function() {
                msgBox.innerHTML = ''; // empty the message box
                btn.innerHTML = '上傳中'; // change button text to "Uploading..."
              },
            onComplete: function( filename, response ) {
                btn.innerHTML = '選擇圖片';
                progressOuter.style.display = 'none'; // hide progress bar when upload is completed

                if ( !response ) {
                    msgBox.innerHTML = '上傳失敗';
                    return;
                }

                if ( response.success === true ) {
                    msgBox.innerHTML = '<strong>' + escapeTags( response.name ) + '</strong>' + ' 上傳成功';
                    $('input[name="image"]').val(response.name);

                } else {
                    if ( response.msg )  {
                        msgBox.innerHTML = escapeTags( response.msg );

                    } else {
                        msgBox.innerHTML = '上傳失敗';
                    }
                }
              },
            onError: function() {
                progressOuter.style.display = 'none';
                msgBox.innerHTML = '上傳失敗';
              }
      });
    };
  });
  </script>
  </body>
</html>
