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
  </head>
  <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet">
  <link rel="stylesheet" href="../../plugins/lobibox/lobibox.min.css" type="text/css" media="screen" />
  <body class="hold-transition skin-yellow-light">
    <div class="wrapper">
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 頁面上方 -->
        <section class="content-header" >
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-新增最新消息</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body"> 
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="title">標題</label>
                  <input type="text" id="title" name="title" class="form-control" value="">  
                </div><!-- /.control-group -->
                <label class="control-label" for="date">日期</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="date" name="date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div><!-- /.input-group -->
                <div class="control-group">
                  <label class="control-label" for="content">內容</label>
                  <textarea id="editor1" name="editor1" rows="20" cols="80" >   
                  </textarea>
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
  <script type="text/javascript" src="../../plugins/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="../../plugins/ckfinder/ckfinder.js"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="../../plugins/lobibox/lobibox.js"></script>

  <script>
 
  $(document).ready(function() {
        
    var result_content='';
    var token=$('input[name="token"]').val();
    var news_type=$('input[name="type"]').val();

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
          url:"../controller/news.php",
          data:{action:'insert',title:title,date:date,content:content,token:token,type:news_type},
          type : "POST",
          success:function(msg){

            var data=JSON.parse(msg);
            if(data.result==1)
            {
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  parent.location.href="news_list.php?token="+token+'&type='+news_type;
                   
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
    });//.submit_form click
  });
  </script>
  </body>
</html>
