<?php
$typeArr = array("jpg", "png", "gif");//允许上传文件格式
//$path =  $_SERVER['DOCUMENT_ROOT'] . "/Uploads/gimg/";//上传路径
//$path =  "/xampp/htdocs/heilan/Uploads/gimg/";//上传路径
$tt = isset($_GET["tt"])?$_GET["tt"]:"";
if(empty($tt)){
    $tt = "default";
}
$picPath = '/Public/Upload/' . $tt . '/' . date('Ymd') . '/';
$path = $_SERVER['DOCUMENT_ROOT'] . '/Public/Upload/' . $tt . '/' . date('Ymd') . '/';

if (! is_dir($path)) {
	mkdir($path,0777,true);
}

if (isset($_POST)) {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $name_tmp = $_FILES['file']['tmp_name'];
    if (empty($name)) {
        echo json_encode(array("error"=>"您还未选择图片"));
        exit;
    }
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
    
    if (!in_array($type, $typeArr)) {
        echo json_encode(array("error"=>"清上传jpg,png或gif类型的图片！"));
        exit;
    }
    if ($size > (5000 * 1024)) {
        echo json_encode(array("error"=>"图片大小已超过5MB！"));
        exit;
    }
    
    $pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
    $pic_url = $path . $pic_name;//上传后图片路径+名称
    
    $picPath .= $pic_name;

    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
        echo json_encode(array("error"=>"0","pic"=>$pic_url,"name"=>$pic_name, 'pic_path'=>$picPath));
    } else {
        echo json_encode(array("error"=>"上传有误，清检查服务器配置！"));
    }
}




?>