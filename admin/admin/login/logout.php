<?php 
session_start();
session_destroy();
sleep(2);
echo '<meta http-equiv=REFRESH CONTENT=1;url=../login/login.php>';
//header("location: ../login.php");

?>