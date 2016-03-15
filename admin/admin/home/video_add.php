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
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet">
  </head>
  <body class="hold-transition skin-yellow-light">
    <div class="wrapper">
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 頁面上方 -->
        <section class="content-header" >
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-新增影片</h1>  
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
                <div class="control-group">
                  <label class="control-label" for="caption">說明</label>
                  <input type="text" id="caption" name="caption" class="form-control" value="">  
                </div><!-- /.control-group -->
                <label class="control-label" for="date">日期</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="date" name="date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div><!-- /.input-group -->
                 <div class="control-group">      
                    <label class="control-label" for="caption">影片網址</label>                                  
                    <input id="video_part"  type="text" name="video" class="form-control" placeholder="請出入影片網址">      
                 </div> 
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
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

  <script>
 
  $(document).ready(function() {
        
    var token=$('input[name="token"]').val();
    var result_content='';

    $('.input-group.date').datepicker({
      format: "yyyy-mm-dd",
      language: "zh-TW",
      calendarWeeks: true,
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
        else if(!$('input[name="video"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫影片網址</div>';
          $('#result').html(result_content);
          $('input[name="video"]').focus();
          return false;
        }
        else{

          var name = $('input[name="name"]').val();
          var url = $('input[name="video"]').val();
          var thumb = '';   
          var caption = $('input[name="caption"]').val();
          var date = $('input[name="date"]').val();

          
          $.ajax({
            url:"../controller/media.php",
            data:{action:'insert',title:name,token:token,url:url,thumb:thumb,type:'video',caption:caption,date:date},
            type : "POST",
            success:function(msg){

              var data=JSON.parse(msg);
              if(data.result==1)
              {
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    parent.location.href="video_list.php?token="+token;
                     
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
