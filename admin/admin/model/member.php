<?php
/*****會員sql處理******/
//新增會員
function insertMember($db,$username,$password,$name,$phone,$mail,$address,$identity,$sales_id,$member_group_id,$birth) {

    $check=getMember($db,$username);

    if($check)
    {
       return "帳號重複";

    }else{

      $sql="INSERT INTO `".constant("DB_PREFIX")."_member` (`m_name`,`m_phone`,`m_identity`,`m_mail`,`m_address`,`sales_id`,`m_username`,`m_password`,`member_group_id`,`m_birth`) VALUES (:name,:phone, :identity,:mail,:address,:sales_id,:username,:password,:member_group_id,:birth  )  ";
      $sth = $db->prepare($sql);
      $sth->bindParam(':username',$pre_username, PDO::PARAM_STR);
      $sth->bindParam(':password',$pre_password, PDO::PARAM_STR);
      $sth->bindParam(':name',$pre_name, PDO::PARAM_STR);
      $sth->bindParam(':phone',$pre_phone, PDO::PARAM_STR);
      $sth->bindParam(':identity',$pre_identity, PDO::PARAM_STR);
      $sth->bindParam(':mail',$pre_mail, PDO::PARAM_STR);
      $sth->bindParam(':sales_id',$pre_sales_id, PDO::PARAM_INT);
      $sth->bindParam(':member_group_id',$pre_member_group_id, PDO::PARAM_INT);
      $sth->bindParam(':address',$pre_address, PDO::PARAM_STR);
      $sth->bindParam(':birth',$pre_birth, PDO::PARAM_STR);

      $pre_username= $username;
      $pre_password = $password;
      $pre_name= $name;
      $pre_phone= $phone;
      $pre_address = $address;
      $pre_mail= $mail;
      $pre_identity = $identity;
      $pre_sales_id= $sales_id;
      $pre_member_group_id= $member_group_id;
      $pre_birth= $birth;

      if ($sth->execute())
      {
        $member_id = $db->lastInsertId();
        return $member_id;
      }
      else
      {
        // failure
        return 0;
      }


    }
  

}
//更新會員
function updateMember($db,$name,$phone,$mail,$address,$identity,$sales_id,$member_id,$member_group_id,$birth) {

    $sql="UPDATE `".constant("DB_PREFIX")."_member` SET `member_group_id` = :member_group_id, `m_name` = :name, `m_phone` = :phone, `m_address` = :address, `m_identity` = :identity, `m_mail` = :mail, `sales_id` = :sales_id , `m_birth` = :birth WHERE   `member_id`= :member_id ";
    $sth = $db->prepare($sql);
    $sth->bindParam(':phone',$phone, PDO::PARAM_STR);
    $sth->bindParam(':name',$name, PDO::PARAM_STR);
    $sth->bindParam(':mail',$mail, PDO::PARAM_STR);
    $sth->bindParam(':address',$address, PDO::PARAM_STR);
    $sth->bindParam(':identity',$identity, PDO::PARAM_STR);
    $sth->bindParam(':sales_id',$sales_id, PDO::PARAM_INT);
    $sth->bindParam(':member_id',$member_id, PDO::PARAM_INT);
    $sth->bindParam(':member_group_id',$member_group_id, PDO::PARAM_INT);
    $sth->bindParam(':birth',$birth, PDO::PARAM_STR);

    if ($sth->execute())
    {
      return 1;
    }
    else
    {
      return 0;
    }
}
//刪除會員
function deleteMember($db,$id) 
{
  $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_member WHERE  member_id= :member_id ');
  $sth->bindParam(':member_id',$id, PDO::PARAM_INT);
  
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
function getMember($db,$username) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_member WHERE   m_username= :username ');
  $sth->bindParam(':username',$username, PDO::PARAM_STR);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//單一會員資訊
function getMemberInfo($db,$id) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_member INNER JOIN dy_member_group ON dy_member.member_group_id=dy_member_group.member_group_id WHERE   member_id= :member_id ');
  $sth->bindParam(':member_id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有會員
function getMembers($db) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_member  INNER JOIN dy_member_group ON dy_member.member_group_id=dy_member_group.member_group_id');
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}


//取得會員總數
function getMemberTotalCount($db) 
{
  $sth = $db->prepare('SELECT count(*) FROM '.constant("DB_PREFIX").'_member');
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}

//密碼產生器
function MembergenerateHashWithSalt($password,$username) 
{
  $password=sha1($password);
  $salt=md5($username);
  $pepper="shine-liors";
  $passfinal=$salt.$password.$pepper;
  return $passfinal;
}
?>


