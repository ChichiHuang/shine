<?php
/*****=====大紀事======******/

//新增大紀事
function insertMilestone($db,$title,$content,$newsdate,$type) 
{
  $sql="INSERT INTO `".constant("DB_PREFIX")."_milestone` (`title`,`content`,`site`,`date`) VALUES (:title,:content,:type,:newsdate )";
  $sth = $db->prepare($sql);
  $sth->bindParam(':title',$pre_title, PDO::PARAM_STR);
  $sth->bindParam(':newsdate',$pre_newsdate, PDO::PARAM_STR);
  $sth->bindParam(':type',$pre_type, PDO::PARAM_STR);
  $sth->bindParam(':content',$pre_content, PDO::PARAM_STR);

  $pre_title= $title;
  $pre_newsdate= $newsdate;
  $pre_type= $type;
  $pre_content= $content;

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
  
}
//更新大紀事
function updateMilestone($db,$title,$content,$newsdate,$id) 
{
  $sql="UPDATE `".constant("DB_PREFIX")."_milestone` SET `title` = :title , `content` = :content, `date` = :newsdate WHERE   `milestone_id`= :milestone_id ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':title',$title, PDO::PARAM_STR);
  $sth->bindParam(':newsdate',$newsdate, PDO::PARAM_STR);
  $sth->bindParam(':milestone_id',$id, PDO::PARAM_INT);
  $sth->bindParam(':content',$content, PDO::PARAM_STR);

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
}
//刪除大紀事
function deleteMilestone($db,$id) 
{
  $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_milestone WHERE  news_id= :milestone_id ');
  $sth->bindParam(':milestone_id',$id, PDO::PARAM_INT);
  
  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
  
}
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


