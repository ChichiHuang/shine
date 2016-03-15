<?php
/*****=====BANNER======******/

//所有banner
function getBanners($db,$type) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_banner WHERE site=:type');
  $sth->bindParam(':type',$type, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}

?>


