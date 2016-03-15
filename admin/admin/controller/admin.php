<?php
/*****管理員******/
session_start();
require '../login/checkLoginSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/admin.php';  
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
  if(isset($_POST["username"]))
  {
    $username=$_POST["username"];
  }
  if(isset($_POST["password"]))
  {
    $password=$_POST["password"];
  }
  if(isset($_POST["name"]))
  {
    $name=$_POST["name"];
  }
  //刪除管理員
  if($action=="delete")
  {
    $r1=deleteAdmin($db,$id);
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
  //更新管理員
  if($action=="update")
  {
    $password=generateHashWithSalt($password,$username);
    $r1=updateAdmin($db,$username,$name,$password,$id);
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
  //新增管理員
  if($action=="insert")
  {
    $password=generateHashWithSalt($password,$username);
    $r1=insertAdmin($db,$username,$name,$password);
    if($r1==1 )
    {
      $response=json_encode(array('result'=> 1,'text'=>'新增成功'));
    }
    else
    {
      $result="新增失敗:".$r1;
      $response=json_encode(array('result'=> 0,'text'=>$result));
    } 
  } 
}
echo $response;

?>