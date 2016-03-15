<?php
/*****最新消息******/
session_start();
require '../login/checkLoginSession.php';
if(login_check()==true)
{
  require '../model/config.php';
  require '../model/news.php'; 
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
  //刪除消息
  if($action=="delete")
  {   
    $r1=deleteNews($db,$id); 
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
  //更新消息
  if($action=="update")
  {
    $r1=updateNews($db,$_POST["title"],$_POST["content"],$_POST["date"],$id); 
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
  //新增消息
  if($action=="insert")
  {
    $r1=insertNews($db,$_POST["title"],$_POST["content"],$_POST["date"],$_POST["type"]); 

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