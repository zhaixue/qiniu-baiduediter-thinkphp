<?php
require_once './autoload.php';
echo '<pre>';

// 引入鉴权类
use Qiniuuediter\Auth;

// 引入上传类
use Qiniuuediter\Storage\UploadManager;

// 需要填写你的 Access Key 和 Secret Key
$accessKey = 'tRr7JYPf2I-lHZGz78SZUUVq13OpepdQpjbo796e';
$secretKey = 'gavGZV2sBiOP1AZc66Pk2nrzaFDaHc6QDsl6vX9v';

// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);

// 要上传的空间
$bucket = 'ybcf-forum01';

//var_dump($_FILES['upfile']);
// 要上传文件的本地路径
$filePath = $_FILES['upfile']['tmp_name'];
$hz = substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.')+1);
$key=date('Y-m-d',time()).'/'.time().rand(100,999).'.'.$hz;

//var_dump($newfilename);
//exit;
// 生成上传 Token
$token = $auth->uploadToken($bucket);
//var_dump($token);exit;

// 上传到七牛后保存的文件名


// 初始化 UploadManager 对象并进行文件的上传
$uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
echo "\n====> putFile result: \n";
if ($err !== null) {
    var_dump($err);
} else {
    var_dump($ret);
}
