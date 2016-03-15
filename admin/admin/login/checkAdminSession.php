<?php
session_start();
$token=getToken();
//取得Token
function getToken()
{
  if(!isset($_SESSION['token']))
  {
    $_SESSION['token']=md5(uniqid(mt_rand(), true));
    return $_SESSION['token'];
  }
  else
  {
  	return $_SESSION['token'];
  }
}
//確認參數是不是數字
function int_check($id) 
{
  if (!is_int($id))
  { 
    session_destroy();
    header("location: ../login/login.php?error=notlogin");
    exit(1);
  }    
  else
  { 
     return true;
  }    
}

function login_check() 
{
  $now = time(); // Checking the time now when home page starts.

  //Check username
  if(!isset($_SESSION['username']) )
  {
    session_destroy();
    header("location: ../login/login.php?error=notlogin");
    exit(1);
  } 

  //Check session time expire 
  else if ($now > $_SESSION['expire']) 
  {
    session_destroy();
    header("location: ../login/login.php?error=expire");
    exit(1);
  } 
  //Check token
  else if($_GET['token']!=$_SESSION['token'] )
  {
    session_destroy();
    header("location: ../login/login.php?error=token");
    exit(1);
  }
  else
  {
    return true;
  }    
}
//取得網站TITLE
function set_title($type)
{
  if($type=="shine"){
    return "響享文創";
  }
  else
  {
    return "巴洛克";
  }
}
//檢查id是否為數字
function checkidlength($id)
{
  if(is_numeric ($id))
  {
    if (strlen($id)>11)
    {
      return substr($id,0,11);
    }
    else
    {
      return $id ;
    }
  }
  else
  {
       return 0 ;
  } 
}
?>
