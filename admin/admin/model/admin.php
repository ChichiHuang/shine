<?php
/*****管理員sql處理******/

//新增管理員
function insertAdmin($db,$username,$name,$password) 
{
  $check=getAdminMember($db,$username);
  if($check)
  {
    return "帳號重複";
  }
  else
  {
    $sql="INSERT INTO `".constant("DB_PREFIX")."_admin` (`admin_name`,`admin_username`,`admin_password`) VALUES (:name,:username, :password  )  ";
    $sth = $db->prepare($sql);
    $sth->bindParam(':username',$pre_username, PDO::PARAM_STR);
    $sth->bindParam(':password',$pre_password, PDO::PARAM_STR);
    $sth->bindParam(':name',$pre_name, PDO::PARAM_STR);

    $pre_username= $username;
    $pre_password = $password;
    $pre_name= $name;

    if ($sth->execute())
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }
}
//更新管理員
function updateAdmin($db,$username,$name,$password,$id) 
{
  $sql="UPDATE `".constant("DB_PREFIX")."_admin` SET `admin_username` = :username , `admin_name` = :name, `admin_password` = :password WHERE   `admin_id`= :admin_id ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':username',$username, PDO::PARAM_STR);
  $sth->bindParam(':password',$password, PDO::PARAM_STR);
  $sth->bindParam(':name',$name, PDO::PARAM_STR);
  $sth->bindParam(':admin_id',$id, PDO::PARAM_INT);

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
}
//刪除管理員
function deleteAdmin($db,$id) 
{
  $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_admin WHERE  admin_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  
  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
}
//確認是否有重複帳號
function getAdminMember($db,$username) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_admin WHERE   admin_username= :username ');
  $sth->bindParam(':username',$username, PDO::PARAM_STR);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//單一管理員資訊
function getAdminInfo($db,$id) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_admin WHERE   admin_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有管理員
function getAdmins($db) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_admin');
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//密碼產生器
function generateHashWithSalt($password,$username) 
{
  $password=sha1($password);
  $salt=md5($username);
  $pepper="shine-liors";
  $passfinal=$salt.$password.$pepper;
  return $passfinal;
}
?>


