<?php
/*****=====影音======******/

//單一影音資訊
function getMediaInfo($db,$id) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_media WHERE   media_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有影音
function getMedias($db,$type) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_media WHERE type=:type');
  $sth->bindParam(':type',$type, PDO::PARAM_STR);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}

?>


