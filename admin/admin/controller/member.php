<?php
/*****會員******/
session_start();
require '../login/checkLoginSession.php'; 
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/member.php'; 
  }
else
{
  exit(1);
}  
//檢查token是否有誤
if($_POST['token'] != $_SESSION['token'])
{
  $result="執行失敗:"."Token錯誤";
  $response=json_encode(array('result'=> 0,'text'=>$result));
}
else
{
  if(isset($_POST["id"]))
  {
    $id=$_POST["id"];
  }
  if(isset($_POST["action"]))
  {
    $action=$_POST["action"];
  }
  //刪除會員
  if($action=="delete")
  {
    $r1=deleteMember($db,$id);
    deleteMemberPet($db,$id);
    if($r1==1)
    {
      $response=json_encode(array('result'=> 1,'text'=>'刪除成功'));
    }
    else
    {
      $result="刪除失敗:".$r1;
      $response=json_encode(array('result'=> 0,'text'=>$result));
    }

  }
  //刪除寵物
  if($action=="delete_pet")
  {
    $r1=deletePet($db,$id);
    if($r1==1)
    {
      $response=json_encode(array('result'=> 1,'text'=>'刪除成功'));
    }
    else
    {
      $result="刪除失敗:".$r1;
      $response=json_encode(array('result'=> 0,'text'=>$result));
    }
  }
  //更新會員
  if($action=="update")
  {
    $r1=updateMember($db,$_POST["name"],$_POST["phone"],$_POST["mail"],$_POST["address"],$_POST["identity"],$_POST["sales_id"],$id,$_POST["member_group_id"],$_POST["birth"]);   
    if($r1==1 )
    {
      $response=json_encode(array('result'=> 1,'text'=>'更新成功'));
    }
    else
    {
      $result="更新失敗:".$r1;
      $response=json_encode(array('result'=> 0,'text'=>$result));
    }
  }
  //新增會員
  if($action=="insert")
  {
    $password=MembergenerateHashWithSalt($_POST["password"],$_POST["username"]);
    $r1=insertMember($db,$_POST["username"],$password,$_POST["name"],$_POST["phone"],$_POST["mail"],$_POST["address"],$_POST["identity"],$_POST["sales_id"],$_POST["member_group_id"],$_POST["birth"]);  
    $member=getMember($db,$username);
    /*foreach( $member as $member )
    {
      $member_id=$member["member_id"];
    }*/
    $member_id=$r1;
    //寵物新增
    foreach( $_POST["pet"] as $pet )
    {
      insertPet($db,$pet,$member_id);
    }
    if($r1!=0 )
    {
      $response=json_encode(array('result'=> 1,'text'=>'新增成功'));
    }
    else
    {
      $result="新增失敗";
      $response=json_encode(array('result'=> 0,'text'=>$result));
    }   
  }
  
}
echo $response;

?>