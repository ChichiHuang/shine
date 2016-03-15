<?php
/*****BANNER******/
session_start();
require '../login/checkLoginSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/banner.php';   
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
  //刪除banner
  if($action=="delete")
  {   
    $r1=deleteBanner($db,$id); 
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
  //新增banner
  if($action=="insert")
  {
    $r1=insertBanner($db,$_POST["image"],$_POST["type"],$_POST["title"],$_POST["sort"]); 

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