<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/milestone.php'; 
}
$type=$_GET["type"];
$site_title=set_title($type);
//取得新聞資訊
$info=getMilestoneInfo($db,$_GET["info_id"]); 
foreach( $info as $info_info )
{
  $title=$info_info["title"];
  $date=$info_info["date"];
  $content=$info_info["content"];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet">
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
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-編輯大紀事內容</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
          <div class="box">
            <div class="box-body">
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="title">標題</label>
                  <input type="text" id="title" name="title" class="form-control" value="<?php echo $title;?>">  
                </div><!-- /.control-group -->
                <label class="control-label" for="date">日期</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="date" name="date" value="<?php echo $date;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div><!-- /.input-group -->
                <div class="control-group">
                  <label class="control-label" for="content">內容</label>
                  <textarea id="editor1" name="editor1" rows="20" cols="80" >   
                  <?php echo $content;?>
                  </textarea>
                </div><!-- /.control-group -->
                <br>

                <!-- 警示顯示 -->
                <div id="result"></div>
                <div class="text-center">
                  <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認儲存</button>   
                </div>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
                <input type="hidden" name="type" value="<?php echo $type;?>" />
                <input type="hidden" name="info_id" value="<?php echo $_GET["info_id"];?>" />
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
    <script type="text/javascript" src="../../plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="../../plugins/ckfinder/ckfinder.js"></script>
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="../../plugins/lobibox/lobibox.js"></script>
    <!-- page script -->
    <script>
    $(document).ready(function() {

      var token=$('input[name="token"]').val();
      var info_id=$('input[name="info_id"]').val();
      var milestone_type=$('input[name="type"]').val();
      var result_content='';

      $('.input-group.date').datepicker({
        format: "yyyy-mm-dd",
        language: "zh-TW",
        calendarWeeks: true,
        autoclose: true
      });

      //CKEDITOR
      if (typeof CKEDITOR == 'undefined') 
      {
       document.write('加载CKEditor失败');
      }
      else 
      {
       var editor1 = CKEDITOR.replace('editor1');//info  
       editor1.config.height = 400;   
       CKFinder.setupCKEditor( editor1, '../../plugins/ckfinder/');
      } 
      
      $('#submit_form').click(function() {

        $('#result').empty();
        result_content="";

        if(!$('input[name="title"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫標題</div>';
          $('#result').html(result_content);
          $('input[name="title"]').focus();
          return false;
        }
        else if(!$('input[name="date"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫日期</div>';
          $('#result').html(result_content);
          $('input[name="date"]').focus();
          return false;
        }
        else if(editor1.getData()=='') {
          result_content+='<div class="alert alert-danger" role="alert">請填寫內容</div>';
          $('#result').html(result_content);
          return false;
        }

        else{

          var title = $('input[name="title"]').val();
          var date = $('input[name="date"]').val();
          var content = editor1.getData();

          $.ajax({
            url:"../controller/milestone.php",
            data:{action:'update',title:title,date:date,content:content,token:token,id:info_id},
            type : "POST",
            success:function(msg){

              var data=JSON.parse(msg);
              if(data.result==1)
              {
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    location.href="milestone_list.php?token="+token+'&type='+milestone_type;
                     
                  }
                });
              }
              else
              {
                Lobibox.alert('error', {
                  msg: data.text,
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
      });//.submit click        
    });
 
    </script>
  </body>
</html>
