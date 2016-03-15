<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/banner.php'; 
}
$type=$_GET["type"];
$banners=getBanners($db,$type); 
$site_title=set_title($type);

//圖片路徑
$image_dir=constant("BANNER_URL");
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
      <div class="content-wrapper">
        <!-- 頁面上方 -->
        <section class="content-header">
          <h1><span style="color:#FF7634;"><?php echo $site_title;?></span>-BANNER管理</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">BANNER列表</h3>
              <div class="text-right"> 
               <a class="fancybox fancybox.iframe" href="banner_add.php?token=<?php echo $token;?>&type=<?php echo $type;?>"><button class="btn btn-primary btn-sm"><i class="fa fa-fw fa-plus"></i></button></a>
              </div>    
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>縮圖</th>
                    <th>名稱</th>  
                    <th>排序</th>  
                    <th>操作</th>                   
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $banners  as $banner ){ ?>
                  <tr>
                    <td><img src="<?php echo $image_dir.$banner["image"]; ?>" height="50"></td>
                    <td><?php echo $banner["title"];?></td> 
                    <td><?php echo $banner["sort_order"];?></td> 
                    <td id="<?php echo $banner["banner_id"];?>" name="<?php echo $banner["title"];?>">
                      <a class="fancybox fancybox.iframe" href="banner_info.php?banner_id=<?php echo $banner["banner_id"]; ?>&token=<?php echo $token;?>"><button class="btn btn-info btn-sm" data-toggle="tooltip" title="瀏覽"><i class="fa fa-eye"></i></button></a>
                      <button  class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="刪除" ><i class="fa fa-trash"></i></button>                                     
                    </td>                  
                  </tr>
                  <?php }?>  
                </tbody>
              </table>
            </div>
            <input type="hidden" name="token" value="<?php echo $token;?>" />
            <!-- /.box-body -->
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

        $("#example1").DataTable();
        $(".fancybox").fancybox({
            'width' : 900
        });
        $(".delete").click(function() {
          var banner_id=$(this).parent().attr('id');
          var name=$(this).parent().attr('name');
          var tr=$(this).parent().parent();
          $.confirm({
            text: "確認刪除此BANNER #"+name+" ?",
            confirm: function(button) {
    
                $.ajax({
                  url:"../controller/banner.php",
                  data:{action:'delete',id:banner_id,token:token},
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
        });//.delete     
      });
 
    </script>
  </body>
</html>
