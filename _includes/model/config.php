<?php

$admin_hostname = 'localhost'; 
$admin_username = 'chichi'; 
$admin_password = '12345';
$db_name="shine";

try{
    $db=new PDO("mysql:host=".$admin_hostname.";
                dbname=".$db_name, $admin_username, $admin_password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                //PDO::MYSQL_ATTR_INIT_COMMAND 設定編碼

    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //錯誤訊息提醒
    
} 
catch(PDOException $e){
    print "錯誤訊息: ".$e->getMessage()."\n";
    print "行數: ".$e->getLine()."\n";
    die();
	}
/*SETTING*/	
define("BANNER_URL","http://localhost/shine/image/banner/");
define("MEDIA_URL","http://localhost/shine/image/media/");
define("DB_PREFIX","shine");
//判斷哪個網站
define("SITE","shine");
 
?>