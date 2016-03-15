<?php
/*****影音******/
session_start();
require '../login/checkLoginSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/media.php'; 
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
  //刪除影音
  if($action=="delete")
  {   
    $r1=deleteMedia($db,$id); 
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
  //更新影音
  if($action=="update")
  {
    $r1=updateMedia($db,$_POST["title"],$_POST["caption"],$_POST["url"],$_POST["thumb"],$_POST["date"],$id); 
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
  //新增影音
  if($action=="insert")
  {
    $r1=insertMedia($db,$_POST["title"],$_POST["caption"],$_POST["type"],$_POST["url"],$_POST["thumb"],$_POST["date"]); 

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