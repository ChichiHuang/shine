<?php
session_start();

function checkToken($token){

  if($token != $_SESSION['token'])
  {

    header("location: ../login/login.php");
    exit(1);

  }


}
function getTokenField(){

  return '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';

}
function getToken(){

  if(!isset($_SESSION['token']))
  {

    $_SESSION['token']=md5(uniqid(mt_rand(), true));
    return $_SESSION['token'];

  }else{

  	return $_SESSION['token'];
  }


}
?>
