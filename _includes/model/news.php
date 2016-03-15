<?php
/*****=====消息======******/

//單一消息資訊
function getNewsInfo($db,$id) 

{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_news WHERE news_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有消息
function getAllNews($db,$type) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_news WHERE site= :type');
  $sth->bindParam(':type',$type, PDO::PARAM_STR);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
?>


