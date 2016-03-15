<?php
/*****=====影音======******/

//新增影音
function insertMedia($db,$title,$caption,$type,$url,$thumb,$date)
{
  $sql="INSERT INTO `".constant("DB_PREFIX")."_media` ( `title`, `caption`, `type`, `url`, `thumb` ,`date`) VALUES (:title,:caption, :type ,:url,:thumb,:date)  ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':title',$pre_title, PDO::PARAM_STR);
  $sth->bindParam(':caption',$pre_caption, PDO::PARAM_STR);
  $sth->bindParam(':type',$pre_type, PDO::PARAM_STR);
  $sth->bindParam(':url',$pre_url, PDO::PARAM_STR);
  $sth->bindParam(':thumb',$pre_thumb, PDO::PARAM_STR);
  $sth->bindParam(':date',$pre_date, PDO::PARAM_STR);

  $pre_title= $title;
  $pre_caption= $caption;
  $pre_type= $type;
  $pre_url= $url;
  $pre_thumb= $thumb;
  $pre_date= $date;

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
  
}
//更新影音
function updateMedia($db,$title,$caption,$url,$thumb,$date,$id) 
{
  $sql="UPDATE `".constant("DB_PREFIX")."_media` SET `title` = :title , `caption` = :caption, `url` = :url, `thumb` = :thumb  , `date` = :date WHERE   `media_id`= :media_id ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':title',$title, PDO::PARAM_STR);
  $sth->bindParam(':caption',$caption, PDO::PARAM_INT);
  $sth->bindParam(':media_id',$id, PDO::PARAM_INT);
  $sth->bindParam(':url',$url, PDO::PARAM_STR);
  $sth->bindParam(':thumb',$thumb, PDO::PARAM_STR);
  $sth->bindParam(':date',$date, PDO::PARAM_STR);

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
}
//刪除影音
function deleteMedia($db,$id) 
{
    $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_media WHERE  media_id= :media_id ');
    $sth->bindParam(':media_id',$id, PDO::PARAM_INT);
    
    if ($sth->execute())
    {
      return 1;
    }
    else
    {
      return 0;
    }
  
}
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


