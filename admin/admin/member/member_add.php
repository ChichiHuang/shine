<?php 
require '../login/checkAdminSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/sales.php';
  require '../model/member.php';
}
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
      <!--真的會改到的內容 -->
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 頁面上方 -->
        <section class="content-header" >
          <h1>新增會員</h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body">
              <form id="infoForm" method="post" action="" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="parent">負責業務*</label>               
                </div> 
                <select class="form-control parent" id="parent" name="parent" style="width: 100%">
                  <option value="0" selected>無</option>
                  <?php foreach( $allsales as $sales ){?>
                  <option value="<?php echo $sales["sales_id"]; ?>"><?php echo $sales["s_name"]; ?> (<?php echo $sales["s_number"]; ?>)</option>
                  <?php }?>
                </select>
                <div class="control-group">
                  <label class="control-label" for="member_group">會員等級*</label>               
                </div> 
                <select class="form-control member_group" id="member_group" name="member_group" style="width: 100%">
                  <?php foreach( $membergroups as $membergroup ){?>
                  <option value="<?php echo $membergroup["member_group_id"]; ?>"><?php echo $membergroup["member_group_name"]; ?></option>
                  <?php }?>
                </select>
                <div class="control-group">
                  <label class="control-label" for="name">名稱*</label>
                  <input type="text" id="name" name="name" class="form-control" value="">  
                </div>       
                <div class="control-group">
                  <label class="control-label" for="phone">電話(手機)*</label>
                  <input type="text" id="phone" name="phone" class="form-control" value="">                
                </div>                
                <div class="control-group">
                  <label class="control-label" for="mail">信箱*</label>
                  <input type="text" id="mail" name="mail" class="form-control" value=""> 
                </div>       
                <div class="control-group">
                  <label class="control-label" for="address">地址*</label>
                  <input type="text" id="address" name="address" class="form-control" value=""> 
                </div>
                <div class="control-group">
                  <label class="control-label" for="identity">身分證字號</label>
                  <input type="text" id="identity" name="identity" class="form-control" value=""> 
                </div>
                <label class="control-label" for="date">生日*</label>
                <div class="input-group date">
                 <input type="text" class="form-control" id="birth" name="birth"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <div class="control-group">
                  <label class="control-label" for="username">帳號*</label>
                  <input type="text" id="username" name="username" class="form-control" value=""> 
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
                 <div class="control-group">
                  <label class="control-label" for="pet">寵物</label>
                  <div class="text-right">
                   <button  class="btn btn-primary "  type="button" id="add_field_button"><i class="fa fa-fw fa-plus-circle"></i></button>  
                  </div>   
                  <div class="input_wrap_pet">
                    <div class="row" style="margin-top:20px;">
                      <div class="col-xs-9">
                       <input type="text" id="pet" name="pets[]" class="form-control" value="" placeholder="寵物名稱" >  
                      </div>
                      <div class="col-xs-3">
                       <div class="text-right">
                        <button  class="btn btn-danger "  type="button" id="delete_field_button"><i class="fa fa-fw fa-minus-circle"></i></button>  
                       </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <!-- 警示顯示 -->
                <div id="result"></div>
                <div class="text-center">
                  <button  class="btn btn-success btn-lg"  type="button" id="submit_form">確認新增</button>   
                </div>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer"> </div><!-- /.box-footer-->
          </div><!-- /.box -->
          <!-- 白色底的框框 -->
        </section><!-- /.主要內容 --> 
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
   <?php require '../common/footer-js.php';?>  

  <script src="../../plugins/select2/select2.min.js"></script>
  <script src="../../plugins/lobibox/lobibox.js"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <script> 
    $(document).ready(function() {
        
      var token=$('input[name="token"]').val();
      $(".parent").select2();
      $(".member_group").select2();
      var re1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/; 

      $('.input-group.date').datepicker({
        format: "yyyy-mm-dd",
        language: "zh-TW",
        calendarWeeks: true,
        autoclose: true
      });
      
      //寵物欄位新增
      var pet_wrapper  = $(".input_wrap_pet"); //Fields wrapper   
      var x = 1; //initlal text box count

      $("#add_field_button").click(function(e){ //on add input button click
        e.preventDefault();
        x++; //text box increment
        var review ='<div class="row" style="margin-top:20px;">';
        review  += '<div class="col-xs-9">';
        review  += '<input type="text" id="pet" name="pets[]" class="form-control" value="" placeholder="寵物名稱" >';
        review  += '</div>';
        review  += '<div class="col-xs-3">';
        review  += '<div class="text-right">';
        review  += '<button  class="btn btn-danger "  type="button" id="delete_field_button"><i class="fa fa-fw fa-minus-circle"></i></button>  ';
        review  += '</div>';
        review  += '</div>';
        review  += '</div>';
       
        $(".input_wrap_pet").append(review); //add input box
      });//.寵物欄位新增

      //刪除寵物欄位
      $(pet_wrapper).on("click","#delete_field_button", function(e){ //user click on remove text     
        e.preventDefault(); 
        $(this).parent('div').parent('div').parent('div').remove(); 
        x--;
        return false;
      });//.刪除寵物欄位

      //確認送出
      $('#submit_form').click(function() {

        $('#result').empty();
        result_content="";

        if(!$('input[name="name"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫名稱</div>';
          $('#result').html(result_content);
          $('input[name="name"]').focus();
          return false;
        }
        else if(!$('input[name="phone"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫電話</div>';
          $('#result').html(result_content);
          $('input[name="phone"]').focus();
          return false;
        }
        else if(!$('input[name="mail"]').val()) {
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
        else if(!$('input[name="address"]').val()) {
          result_content+='<div class="alert alert-danger" role="alert">請填寫地址</div>';
          $('#result').html(result_content);
          $('input[name="address"]').focus();
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

          var pet_arr=[];
          //寵物名稱
          $('input[name="pets[]"]').each(function() { 
            var aValue = $(this).val();  
            if(aValue !=''){
              pet_arr.push(aValue);
            }
          });
          //var info={"type": slider_type, "caption": image_caption,"image":image,"sort":image_order,"thumbnail":thumbnail};
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
          var info={ "sales_id": sales_id, "name": name,"username":username,"password":password,"phone":phone,"mail":mail,"address":address,"identity":identity};

          $.post("../controller/member.php",{action:'insert',token:token,member_group_id:member_group_id,sales_id: sales_id, name: name,username:username,password:password,phone:phone,mail:mail,address:address,identity:identity,pet:pet_arr,birth:birth},function(msg){

            var data=JSON.parse(msg);
            if(data.result==1)
            {
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  parent.location.href="member_list.php?token="+token;
                   
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
          });//.post   
        }//.else  
      });//.submit click
    });
   </script>
  </body>
</html>
