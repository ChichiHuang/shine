<?php
/*****=====大紀事======******/

//單一大紀事資訊
function getMilestoneInfo($db,$id) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_milestone WHERE milestone_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有大紀事
function getAllMilestones($db,$type) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_milestone WHERE site= :type');
  $sth->bindParam(':type',$type, PDO::PARAM_STR);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
?>


