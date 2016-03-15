<?php 
require '../login/checkAdminSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/media.php';
}
//網站分類
$type=$_GET["type"];
$site_title=set_title($type);
//檢查id
$id=checkidlength($_GET["media_id"]);
$media=getMediaInfo($db,$id); 
//影音資料
foreach( $media as $media_info )
{
  $title=$media_info["title"];
  $caption=$media_info["caption"];
  $date=$media_info["date"];
  $url=$media_info["url"];
  $thumb=$media_info["thumb"];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link rel="stylesheet" href="../../plugins/lobibox/lobibox.min.css" type="text/css" media="screen" />
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet">
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
        <section class="content-header" >
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-編輯照片</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body">         
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="name">名稱</label>
                  <input type="text" id="name" name="name" class="form-control" value="<?php echo $title;?>">  
                </div><!-- /.control-group -->
                <div class="control-group">
                  <label class="control-label" for="caption">說明</label>
                  <input type="text" id="caption" name="caption" class="form-control" value="<?php echo $caption;?>">  
                </div><!-- /.control-group -->
                <label class="control-label" for="date">日期</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="date" name="date" value="<?php echo $date;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div><!-- /.input-group -->
                <div class="row" style="padding-top:10px;">
                  <div class="col-xs-12">
                    <div class="input-group" id="image_part">
                      <input type="text" name="image" class="form-control" disabled="disabled" value="<?php echo $url;?>">
                      <input type="hidden" name="thumb_image" class="form-control" value="<?php echo $thumb;?>">
                      <span class="input-group-btn">
                        <button id="uploadBtn" class="btn btn-large btn-primary">選擇圖片</button>
                      </span>
                    </div><!-- /input-group -->
                  </div>
                </div>
                <br>
                <div id="result"></div>
                <div class="text-center">
                  <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認新增</button>   
                </div>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
                <input type="hidden" name="type" value="<?php echo $type;?>" />
                <input type="hidden" name="media_id" value="<?php echo $id;?>" />
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer"> </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </section><!-- /.主要內容 -->
      </div><!-- /.content-wrapper -->

  <?php require '../common/footer-js.php';?>  
  <script src="../../plugins/simple-upload/SimpleAjaxUploader.js"></script>
  <script src="../../plugins/lobibox/lobibox.js"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

  <script>
 
  $(document).ready(function() {
        
    var token=$('input[name="token"]').val();
    var id=$('input[name="media_id"]').val();
    var result_content='';

    $('.input-group.date').datepicker({
      format: "yyyy-mm-dd",
      language: "zh-TW",
      calendarWeeks: false,
      autoclose: true
    });
 
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
        else{

          var name = $('input[name="name"]').val();
          var url = $('input[name="image"]').val();
          var thumb = $('input[name="thumb_image"]').val();
          var caption = $('input[name="caption"]').val();
          var date = $('input[name="date"]').val();

          
          $.ajax({
            url:"../controller/media.php",
            data:{action:'update',title:name,token:token,url:url,thumb:thumb,type:'image',caption:caption,date:date,id:id},
            type : "POST",
            success:function(msg){

              var data=JSON.parse(msg);
              if(data.result==1)
              {
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    parent.location.href="image_list.php?token="+token;
                     
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
    })//submit click

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
            url: '../controller/image_upload.php',
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
                    $('input[name="thumb_image"]').val(response.thumb);


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
