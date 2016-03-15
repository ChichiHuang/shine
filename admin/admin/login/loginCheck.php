<?php
require '../model/config.php'; 
session_start();
//檢查 TOKEN
if($_POST['token'] != $_SESSION['token'])
{
  $result="登入失敗:"."Token錯誤";
  $response=json_encode(array('result'=> 0,'text'=>$result));

}
else
{
  if( isset($_POST['username']) && isset($_POST['password'])) 
  {
    //產生密碼
    $login_password=generateHashWithSalt($_POST['password'],$_POST['username']);
    $member=getMember($db,$_POST['username']);
    //檢查有無帳號
    if(!$member)
    {
      $result="登入失敗:"."帳號或密碼錯誤";
      $response=json_encode(array('result'=> 0,'text'=>$result));
    }
    else
    {
      foreach( $member  as $memberdata )
      {
        $username=$memberdata["admin_username"];
        $password_db=$memberdata["admin_password"];
      }
      //檢查密碼
      if($login_password != $password_db)
      {
        $result="登入失敗:"."帳號或密碼錯誤";
        $response=json_encode(array('result'=> 0,'text'=>$result));
      }
      else
      {
        //檢查驗證碼
        $REG = "/^[a-z0-9]{4,8}$/i";
        if(!preg_match($REG , $_POST['captcha'])) 
        {
          //return fail
          $result="登入失敗:"."驗證碼錯誤";
          $response=json_encode(array('result'=> 0,'text'=>$result));
        }

        if($_POST['captcha'] != $_SESSION['cap_code'])
        {
          $result="登入失敗:"."驗證碼錯誤";
          $response=json_encode(array('result'=> 0,'text'=>$result));

        }
        else
        {
          $response=json_encode(array('result'=> 1,'text'=>'登入成功'));

          $_SESSION['username'] = $username;

          $_SESSION['start'] = time(); // Taking now logged in time.
          // Ending a session in 30 minutes from the starting time.
          $_SESSION['expire'] = $_SESSION['start'] + (60 * 360);
          
        }//.檢查驗證碼

      }//.檢查密碼

    }//.檢查是否有此帳號  

  }//.檢查是否輸入帳號密碼

}//.檢查TOKEN
//密碼產生器
function generateHashWithSalt($password,$username) {

    $password=sha1($password);
    $salt=md5($username);
    $pepper="shine-liors";
    $passfinal=$salt.$password.$pepper;
    return $passfinal;
}
//查詢帳號
function getMember($db,$username) {

    $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_admin WHERE   admin_username= :username ');
    $sth->bindParam(':username',$username, PDO::PARAM_STR);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料

}

echo $response;

?>