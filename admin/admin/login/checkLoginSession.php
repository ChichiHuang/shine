<?php
session_start();

function login_check() {

  $now = time(); // Checking the time now when home page starts.

  //Check username
  if(!isset($_SESSION['username']) ){
    session_destroy();
    header("location: ../login/login.php?error=notlogin");
    exit(1);
  } 

  //Check session time expire 
  else if ($now > $_SESSION['expire']) {
     session_destroy();
     header("location: ../login/login.php?error=expire");
     exit(1);
  } 
  else{

    return true;

  }
  
   
}

?>
