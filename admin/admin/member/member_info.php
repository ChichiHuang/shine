<?php 
require '../login/checkAdminSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/member.php'; 
  require '../model/sales.php'; 
  require '../model/contract.php'; 
  require '../model/life-order.php'; 
}
//取得會員資訊
$member=getMemberInfo($db,$_GET["member_id"]); 
foreach( $member as $member_info )
{
   $name=$member_info["m_name"];
   $username=$member_info["m_username"];
   $phone=$member_info["m_phone"];
   $address=$member_info["m_address"];
   $mail=$member_info["m_mail"];
   $identity=$member_info["m_identity"];
   $sales_id=$member_info["sales_id"];
   $birth=$member_info["m_birth"];
   $member_group_name=$member_info["member_group_name"];
}
//取得寵物
$pets=getMemberPet($db,$_GET["member_id"]); 
//取得業務資料
$sales=getSalesInfo($db,$sales_id);
foreach( $sales as $sales_info )
{
   $sales_name=$sales_info["s_name"];
   $sales_number=$sales_info["s_number"];
}
//取得訂單-生前契約
$life_orders=getLifeOrdersByMemberId($db,$_GET["member_id"]); 
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require '../common/head.php';?>
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
  </head>
  <body>
    <div class="wrapper">
      <div style="width:100%;    margin-left: auto; margin-right: auto;" >
        <!-- 頁面上方 -->
        <section class="content-header" >
          <h1>會員資訊-<?php echo $name;?></h1>  
        </section>
        <!-- 主要內容 -->
        <section class="content" >
          <div class="box">
            <div class="box-body">
              <ul id = "myTab" class = "nav nav-tabs">
                <li class = "active"><a href = "#info" data-toggle = "tab">基本資料</a></li>       
                <li><a href = "#contract" data-toggle = "tab">生前契約</a></li>
                <li><a href = "#reserve" data-toggle = "tab">預約紀錄</a></li>
                <li><a href = "#buy" data-toggle = "tab">購物紀錄</a></li>   
              </ul>
              <div id = "myTabContent" class = "tab-content">
                <div class = "tab-pane fade in active" id = "info">
                  <hr></hr>
                  <h4>會員編號: #<?php echo $_GET["member_id"]?></h4>
                  <table class="table table-bordered">
                    <tr>
                      <td><b>名稱</b>│<?php echo $name;?></td>
                      <td><b>生日</b>│<?php echo $birth;?></td>
                      <td><b>身分證字號</b>│<?php echo $identity;?></td>
                    </tr>
                    <tr>
                      <td><b>電話</b>│<?php echo $phone;?></td>
                      <td><b>信箱</b>│<?php echo $mail;?></td>
                      <td><b>地址</b>│<?php echo $address;?></td>
                    </tr>
                    <tr>
                      <td><b>帳號</b>│<?php echo $username;?></td>
                      <td><b>等級</b>│<?php echo $member_group_name;?></td>
                      <td><b>負責業務</b>│<?php echo $sales_name;?> (<?php echo $sales_number;?>)</td>
                    </tr>
                  </table>
                  <hr></hr>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>寵物編號</th>
                        <th>寵物名稱</th>                    
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach( $pets as $pet ){?>
                      <tr>
                        <td>#<?php echo $pet["pet_id"];?></td>
                        <td><?php echo $pet["p_name"];?></td>               
                      </tr>
                      <tr>
                      <?php }?>  
                    </tbody>
                  </table>
                </div><!-- /.info -->              
                <div class = "tab-pane fade" id = "contract">
                  <hr></hr> 
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>訂單編號</th>
                        <th>契約名稱</th>
                        <th>寵物名稱</th> 
                        <th>金額</th>   
                        <th>簽約日期</th>                 
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach( $life_orders  as $life_order ){ ?>
                      <tr>
                        <td><?php echo $life_order["life_order_number"]; ?></td>
                        <td>
                         <?php 
                          //取得契約資訊
                          $contract=getContractInfo($db,$life_order["contract_id"]); 
                          foreach( $contract as $contract_info )
                          {
                            $c_name=$contract_info["c_name"];
                          }
                        ?>
                         <a class="fancybox fancybox.iframe" href="../life/contract_info.php?contract_id=<?php echo $life_order["contract_id"]; ?>&token=<?php echo $token;?>"><?php echo $c_name;?></a>                     
                        </td>
                        <?php 
                          //取得寵物資訊
                          $pet=getPetInfo($db,$life_order["pet_id"]); 
                          foreach( $pet as $pet_info )
                          {
                            $p_name=$pet_info["p_name"];
                          }
                        ?>
                        <td><?php echo $p_name;?></td>
                        <td><?php echo $life_order["order_date"];?></td>
                        <td><?php echo $life_order["amount"];?></td>                                
                      </tr>
                      <?php }?>  
                    </tbody>
                  </table> 
                </div><!-- /.contract --> 
                <div class = "tab-pane fade" id = "reserve">
                  <hr></hr>
                </div><!-- /.reserve --> 
                <div class = "tab-pane fade" id = "buy">
                  <hr></hr>
                </div><!-- /.buy -->  
              </div>              
            </div><!-- /.box-body -->
            <div class="box-footer"> </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </section><!-- /.主要內容 --> 
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->

   <?php require '../common/footer-js.php';?>  
  <!-- DataTables -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script>
  $(document).ready(function() {
    $("#example1").DataTable();   
  });
   </script>
  </body>
</html>
