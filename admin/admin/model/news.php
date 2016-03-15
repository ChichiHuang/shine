<?php
/*****=====消息======******/

//新增消息
function insertNews($db,$title,$content,$newsdate,$type) 
{
  $sql="INSERT INTO `".constant("DB_PREFIX")."_news` (`title`,`content`,`site`,`date`) VALUES (:title,:content,:type,:newsdate )";
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
//更新消息
function updateNews($db,$title,$content,$newsdate,$id) 
{
  $sql="UPDATE `".constant("DB_PREFIX")."_news` SET `title` = :title , `content` = :content, `date` = :newsdate WHERE   `news_id`= :news_id ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':title',$title, PDO::PARAM_STR);
  $sth->bindParam(':newsdate',$newsdate, PDO::PARAM_STR);
  $sth->bindParam(':news_id',$id, PDO::PARAM_INT);
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
//刪除消息
function deleteNews($db,$id) 
{
  $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_news WHERE  news_id= :news_id ');
  $sth->bindParam(':news_id',$id, PDO::PARAM_INT);
  
  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
  
}
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


