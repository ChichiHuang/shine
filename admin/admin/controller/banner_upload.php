<?php
require('Uploader.php');

$upload_dir = '../../../image/banner/';
$filename='banner-'.date('Y-m-d-H-i-s').'.jpg';
$uploader = new FileUpload('uploadfile');
$uploader->newFileName = $filename;
// Handle the upload
$result = $uploader->handleUpload($upload_dir);

if (!$result) {
  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
}

echo json_encode(array('success' => true,'name' =>$filename));
