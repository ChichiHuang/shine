<?php
/*****=====BANNER======******/

//新增BANNER
function insertBanner($db,$image,$type,$title,$sort_order)
{
  $sql="INSERT INTO `".constant("DB_PREFIX")."_banner` (`image`,`site`,`title`,`sort_order`) VALUES (:image,:type,:title ,:sort_order)  ";
  $sth = $db->prepare($sql);
  $sth->bindParam(':image',$pre_image, PDO::PARAM_STR);
  $sth->bindParam(':type',$pre_type, PDO::PARAM_STR);
  $sth->bindParam(':title',$pre_title, PDO::PARAM_STR);
  $sth->bindParam(':sort_order',$pre_sort_order, PDO::PARAM_INT);

  $pre_type= $type;
  $pre_sort_order= $sort_order;
  $pre_title= $title;
  $pre_image= $image;

  if ($sth->execute())
  {
    return 1;
  }
  else
  {
    return 0;
  }
  
}
//刪除banner
function deleteBanner($db,$id) 
{
    $sth = $db->prepare('DELETE FROM '.constant("DB_PREFIX").'_banner WHERE  banner_id= :banner_id ');
    $sth->bindParam(':banner_id',$id, PDO::PARAM_INT);
    
    if ($sth->execute())
    {
      return 1;
    }
    else
    {
      return 0;
    }
  
}
//單一banner資訊
function getBannerInfo($db,$id) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_banner WHERE   banner_id= :id ');
  $sth->bindParam(':id',$id, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}
//所有banner
function getBanners($db,$type) 
{
  $sth = $db->prepare('SELECT * FROM '.constant("DB_PREFIX").'_banner WHERE site=:type');
  $sth->bindParam(':type',$type, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);//回傳全部資料
}

?>


