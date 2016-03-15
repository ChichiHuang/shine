<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/news.php'; 
}
$type=$_GET["type"];
$site_title=set_title($type);
//取得最新消息資訊
$infos=getAllNews($db,$type); 

?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
     <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../../plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
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
      <!-- =============================================== -->
      <!--真的會改到的內容 -->
      <div class="content-wrapper">
        <!-- 頁面上方 -->
        <section class="content-header">
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-最新消息管理</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">最新消息列表</h3>
              <div class="text-right"> 
               <a class="fancybox fancybox.iframe" href="news_add.php?token=<?php echo $token;?>&type=<?php echo $type;?>"><button class="btn btn-primary btn-sm"><i class="fa fa-fw fa-plus"></i></button></a>
              </div>    
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>標題</th> 
                    <th>操作</th>                   
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $infos  as $info ){ ?>
                  <tr>
                    <td><?php echo $info["date"];?></td>
                    <td><?php echo $info["title"];?></td>
                    <td id="<?php echo $info["news_id"];?>" name="<?php echo $info["title"];?>">
                      <button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" onclick="window.location='news_edit.php?info_id=<?php echo $info["news_id"]; ?>&type=<?php echo $type;?>&token=<?php echo $token;?>';"><i class="fa fa-pencil-square-o"></i></button>
                      <button  class="btn btn-danger btn-sm  delete"  data-toggle="tooltip" title="刪除" id="<?php echo $info["news_id"]; ?>"><i class="fa fa-trash"></i></button>                                     
                    </td>                  
                  </tr>
                  <?php }?>  
                </tbody>
              </table>
            </div><!-- /.box-body -->
            <input type="hidden" name="token" value="<?php echo $token;?>" />
          </div><!-- /.box -->
        </section><!-- /.主要內容 -->
     <!-- =============================================== -->    
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php require '../common/footer.php';?>     
      </footer> 
    </div><!-- ./wrapper -->
    <?php require '../common/footer-js.php';?>    
     <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="../../plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script src="../../plugins/lobibox/lobibox.js"></script>
    <script src="../../plugins/jquery-confirm/jquery.confirm.min.js"></script>
    <!-- page script -->
    <script>
    $(document).ready(function() {

        var token=$('input[name="token"]').val();

        $("#example1").DataTable({
          "order": [[ 0, "desc" ]]
        });

        $(".fancybox").fancybox({
          'width' : 900
        });

        $(".delete").click(function() {

          var news_id=$(this).parent().attr('id');         
          var title=$(this).parent().attr('name');
          var tr=$(this).parent().parent();
          $.confirm({
            text: "確認刪除此消息 #"+title+" ?",
            confirm: function(button) {
    
                $.ajax({
                  url:"../controller/news.php",
                  data:{action:'delete',id:news_id,token:token},
                  type : "POST",
                  success:function(msg){

                    var data=JSON.parse(msg);
                    if(data.result==1)
                    {
                      Lobibox.alert('success', {
                        msg: data.text,
                        callback: function(lobibox, type){

                          tr.fadeOut();
                           
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
              },
              cancel: function(button) {
              },
              confirmButton: "確認",
              cancelButton: "取消"
          });//.confirm 
        });//end delete      
      });
 
    </script>
  </body>
</html>
