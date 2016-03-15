<?php
require('Uploader.php');
//上傳路徑
$upload_dir = '../../../image/media/';
//重新命名
$filename='media-image-'.date('Y-m-d-H-i-s');
$uploader = new FileUpload('uploadfile');
$uploader->newFileName = $filename.'.png';
// Handle the upload
$result = $uploader->handleUpload($upload_dir);
if (!$result) 
{
  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
}
else
{
  $path = $uploader->getSavedFile();
  $thumb=ImageResize($path , $upload_dir.$filename.'_small',$filename);
  echo json_encode(array('success' => true,'name' =>$filename,'thumb' =>$thumb));

}

//產生縮圖
function ImageResize($from_filename, $save_filename,$thumb, 
               $in_width=400, $in_height=300, $quality=100)
{
    // 首先取得來源圖檔的資訊
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    $sub_name = $t = '';
    // 利用mime屬性來判斷要產生什麼格式的新image
    list($t, $sub_name) = explode('/', $mime);

    // 取得縮在此範圍內的比例
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);
    $image = null;
    if ($sub_name == "jpeg") {
        $image = imagecreatefromjpeg($from_filename);
        $sub_name = ".jpg";
    } else if ($sub_name == "png") {
        $image = imagecreatefrompng($from_filename);
        $sub_name = ".png";
    } else if ($sub_name == "gif") {
        $image = imagecreatefromgif($from_filename);
        $sub_name = ".gif";
    }
    // 利用imagecopyresampled函式來縮圖
    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, 
                                              $new_height, $width, $height);
    // 產生圖檔到指定路徑
    imagejpeg($image_new, $save_filename.$sub_name, $quality);


    return $thumb."_small".$sub_name;
}

function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}