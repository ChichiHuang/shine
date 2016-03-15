<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/member.php'; 
  require '../model/sales.php'; 
}
//取得會員資訊
$member=getMemberInfo($db,$_GET["member_id"]); 
foreach( $member as $member_info ){
   $name=$member_info["m_name"];
   $username=$member_info["m_username"];
   $phone=$member_info["m_phone"];
   $address=$member_info["m_address"];
   $mail=$member_info["m_mail"];
   $identity=$member_info["m_identity"];
   $sales_id=$member_info["sales_id"];
   $birth=$member_info["m_birth"];
   $member_group_id=$member_info["member_group_id"];
}
//取得寵物
$pets=getMemberPet($db,$_GET["member_id"]); 
//取得所有業務資料
$allsales=getSales($db);
//取得所有會員等級
$membergroups=getMemberGroup($db); 
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link href="../../plugins/select2/select2.min.css" rel="stylesheet">
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
        <section class="content-header">
          <h1>編輯會員資料</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">會員編號 <?php echo $_GET["member_id"];?> </h3>  
            </div>
            <div class="box-body">
             <p>會員帳號: <?php echo $username;?></p>    
             <form id="infoForm" method="post" action="" class="form-horizontal">
              <div class="control-group">
                <label class="control-label" for="parent">負責業務*</label>               
              </div> 
              <select class="form-control parent" id="parent" name="parent" style="width: 100%">
                <?php if($sales_id==0){?>
                <option value="0" selected>無</option>
                <?php }else{?>
                <option value="0">無</option>
                <?php }?>
                <?php foreach( $allsales as $sales ){?>
                <?php if($sales_id==$sales["sales_id"]){?>
                <option value="<?php echo $sales["sales_id"]; ?>" selected><?php echo $sales["s_name"]; ?> (<?php echo $sales["s_number"]; ?>)</option>
                <?php }else{?>
                <option value="<?php echo $sales["sales_id"]; ?>"><?php echo $sales["s_name"]; ?> (<?php echo $sales["s_number"]; ?>)</option>
                <?php }?>
                <?php }?>
              </select>
              <div class="control-group">
                  <label class="control-label" for="member_group">會員等級*</label>               
                </div> 
                <select class="form-control member_group" id="member_group" name="member_group" style="width: 100%">
                  <?php foreach( $membergroups as $membergroup ){?>
                   <?php if($member_group_id==$membergroup["member_group_id"]){?>
                  <option value="<?php echo $membergroup["member_group_id"]; ?>" selected><?php echo $membergroup["member_group_name"]; ?></option>
                  <?php }else{?>
                  <option value="<?php echo $membergroup["member_group_id"]; ?>"><?php echo $membergroup["member_group_name"]; ?></option>
                  <?php }?>
                  <?php }?>
                </select>
              <div class="control-group">
                <label class="control-label" for="name">名稱</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name;?>">  
              </div>       
              <div class="control-group">
                <label class="control-label" for="phone">電話(手機)</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone;?>">                
              </div>                
              <div class="control-group">
                <label class="control-label" for="mail">信箱*</label>
                <input type="text" id="mail" name="mail" class="form-control" value="<?php echo $mail;?>"> 
              </div>       
              <div class="control-group">
                <label class="control-label" for="address">地址</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo $address;?>"> 
              </div>
              <div class="control-group">
                <label class="control-label" for="identity">身分證字號</label>
                <input type="text" id="identity" name="identity" class="form-control" value="<?php echo $identity;?>"> 
              </div>
              <label class="control-label" for="date">生日</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="birth" name="birth" value="<?php echo $birth;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
              </div>
              <div class="control-group">
                <label class="control-label" for="pet">寵物</label>
                <div class="text-right">
                 <button  class="btn btn-primary "  type="button" id="add_field_button"  data-toggle="modal" data-target="#myModal"><i class="fa fa-fw fa-plus-circle"></i></button>  
                </div>   
              <div class="input_wrap_pet">
                <table class="table table-bordered table-striped" id="pet_table">
                <?php foreach( $pets as $pet ){?>
                <tr id="<?php echo $pet["pet_id"]; ?>">
                  <td width="20%">
                  <input type="text" id="pet_<?php echo $pet["pet_id"]; ?>" name="pet_<?php echo $pet["pet_id"]; ?>" class="form-control" value="<?php echo $pet["p_name"]; ?>" placeholder="寵物名稱" style="display:none;"> 
                  <p id="pet_text_<?php echo $pet["pet_id"]; ?>" name="pet_text_<?php echo $pet["pet_id"]; ?>"><?php echo $pet["p_name"]; ?></p>
                  </td>
                  <td  width="80%">
                  <button  class="btn btn-danger btn-sm"  type="button" id="delete_field_button"><i class="fa fa-fw fa-minus-circle"></i></button>
                  <button  class="btn btn-primary btn-sm"  type="button" id="edit_field_button"><i class="fa fa-fw fa-pencil"></i></button>
                  <button  class="btn btn-primary btn-sm"  type="button" id="save_field_button" style="display:none;"><i class="fa fa-fw fa-save"></i></button>
                  </td>
                </tr>
                <?php }?>
                </table>                
               </div>
              <br>
              <!-- 警示顯示 -->
              <div id="result"></div>
              <div class="text-center">
                <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認儲存</button>   
              </div>
              <input type="hidden" name="token" value="<?php echo $token;?>" />
              <input type="hidden" name="member_id" value="<?php echo $_GET["member_id"];?>" />
            </form>
          </div><!-- /.box-body -->
        </section><!-- /.box -->

        <!-- Modal 新增寵物框框 -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">新增寵物</h4>
              </div>
              <div class="modal-body">
                <input type="text" id="newpet" name="newpet" class="form-control" placeholder="寵物名稱" >  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" id="save_pet" class="btn btn-primary">新增儲存</button>
              </div>
            </div>
          </div>
        </div><!-- /.Modal -->

      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php require '../common/footer.php';?>     
      </footer> 
    </div><!-- ./wrapper -->
    <?php require '../common/footer-js.php';?>    
    <script src="../../plugins/lobibox/lobibox.js"></script>
    <script src="../../plugins/select2/select2.min.js"></script>
    <script src="../../plugins/jquery-confirm/jquery.confirm.min.js"></script>
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

    <script>
    $(document).ready(function() {

      var result_content='';
      var token=$('input[name="token"]').val();
      var member_id=$('input[name="member_id"]').val();
      var pet_id;
      var p_name;
      var re1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/; 

      $('.input-group.date').datepicker({
        format: "yyyy-mm-dd",
        language: "zh-TW",
        calendarWeeks: true,
        autoclose: true
      });

      $(".parent").select2();
      //新增寵物
      $('#save_pet').on('click', function () {

        var newpet=$('input[name="newpet"]').val();
        $.ajax({
          url:"../controller/member.php",
          data:{action:'insert_pet',id:member_id,token:token,pet:newpet},
          type : "POST",
          success:function(msg){
            var data=JSON.parse(msg);
            if(data.result==1)
            {
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  //window.location.reload();
                  window.location.href="member_edit.php?token="+token+"&member_id="+member_id;
                   
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
        });//.ajax      
      });//.save_pet   

      //刪除寵物欄位
      $(".input_wrap_pet").on("click","#delete_field_button", function(e){ //user click on remove text     
          
        e.preventDefault(); 
        pet_id=$(this).parent().parent().attr('id');
        p_name=$('input[name="pet_'+pet_id+'"]').val();
        var pet=$(this).parent().parent();
        $.confirm({
          text: "確認刪除寵物： "+p_name+" ?",
          confirm: function(button) {
            $.ajax({
              url:"../controller/member.php",
              data:{action:'delete_pet',id:pet_id,token:token},
              type : "POST",
              success:function(msg){
                var data=JSON.parse(msg);
                if(data.result==1)
                {
                  Lobibox.alert('success', {
                    msg: data.text,
                    callback: function(lobibox, type){

                      //window.location.reload();
                      pet.fadeOut();
                       
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
            });//.ajax 
          },
          cancel: function(button) {
          },
          confirmButton: "確認",
          cancelButton: "取消"
        });//.confirm     
        return false;
      });//.刪除寵物欄位

      //編輯寵物欄位
      $(".input_wrap_pet").on("click","#edit_field_button", function(e){ //user click on remove text     
          
        e.preventDefault(); 
        pet_id=$(this).parent().parent().attr('id');
        
        $('#pet_text_'+pet_id).css("display","none");
        $(this).css("display","none");
        $('#pet_'+pet_id).css("display","block");
        $(this).next().css("display","inline-block");
        
        return false;
      })//.編輯寵物欄位

      //儲存寵物欄位
      $(".input_wrap_pet").on("click","#save_field_button", function(e){ //user click on remove text     
          
        e.preventDefault(); 
        pet_id=$(this).parent().parent().attr('id');
        p_name=$('input[name="pet_'+pet_id+'"]').val();         

        $.ajax({
          url:"../controller/member.php",
          data:{action:'update_pet',id:pet_id,token:token,pet:p_name},
          type : "POST",
          success:function(msg){
            var data=JSON.parse(msg);
            if(data.result==1)
            {
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  $('#pet_text_'+pet_id).css("display","inline-block");
                  $('#pet_text_'+pet_id).html(p_name);
                  $(this).css("display","none");
                  $('#pet_'+pet_id).css("display","none");
                  $(this).prev().css("display","inline-block");
                   
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
        return false;
      })//.儲存寵物欄位

      //確認送出
      $('#submit_form').click(function() {

        $('#result').empty();
        result_content="";

        if(!$('input[name="mail"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫信箱</div>';
          $('#result').html(result_content);
          $('input[name="mail"]').focus();
          return false;
        }
        else if (re1.exec($('input[name="mail"]').val()) == null)
        {
          result_content+='<div class="alert alert-danger" role="alert">信箱格式錯誤</div>';
          $('#result').html(result_content);
          $('input[name="mail"]').focus();
          return false;            
        }
        else{

          var sales_id = $('#parent').find('option:selected').val();
          var member_group_id = $('#member_group').find('option:selected').val();
          var name = $('input[name="name"]').val();
          var username = $('input[name="username"]').val();
          var password = $('input[name="pass"]').val();
          var phone = $('input[name="phone"]').val();
          var mail = $('input[name="mail"]').val();
          var address = $('input[name="address"]').val();
          var identity = $('input[name="identity"]').val();
          var birth = $('input[name="birth"]').val();
         
          $.post("../controller/member.php",{action:'update',token:token,member_group_id:member_group_id,sales_id: sales_id, name: name,phone:phone,mail:mail,address:address,identity:identity,id:member_id,birth:birth},function(msg){
              
            var data=JSON.parse(msg);
            if(data.result==1)
            {
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  location.href="member_list.php?token="+token;
                   
                }
              });
            }
            else
            {
              Lobibox.alert('error', {
                msg: data.text
              });
            }   
          }).fail(function() {
            Lobibox.alert('error', {
              msg: 'Ajax request 發生錯誤'
            });
          });//.ajax   
        }//.else  
      });//.submit click          
    });
 
    </script>
  </body>
</html>
