<?php
/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14
 * Time: 下午19:18
 */
set_time_limit(0);
include("Uploader.class.php");

/* 上传配置 */
$config = array(
    "pathFormat" => $CONFIG['catcherPathFormat'],
    "maxSize" => $CONFIG['catcherMaxSize'],
    "allowFiles" => $CONFIG['catcherAllowFiles'],
    "oriName" => "remote.png",
    'qiniu_ak'=>$CONFIG['qiniu_ak'],
    'qiniu_sk'=>$CONFIG['qiniu_sk'],
    'qiniu_bucket'=>$CONFIG['qiniu_bucket'],
    'qiniu_pre'=>$CONFIG['qiniu_pre'],
);

$fieldName = $CONFIG['catcherFieldName'];

/* 抓取远程图片 */
$list = array();
if (isset($_POST[$fieldName])) {
    $source = $_POST[$fieldName];
} else {
    $source = $_GET[$fieldName];
}

foreach ($source as $imgUrl) {
    //由于js配置不能阻止 再次进行断点程序就可以阻止百度编辑器进行远程抓取了
    $item = new Uploader($imgUrl, $config, "remote");
    $info = $item->getFileInfo();
    array_push($list, array(
        "state" => $info["state"],
        "url" => $info["url"],
        "size" => $info["size"],
        "title" => htmlspecialchars($info["title"]),
        "original" => htmlspecialchars($info["original"]),
        "source" => htmlspecialchars($imgUrl)
    ));
}

/* 返回抓取数据 */
return json_encode(array(
    'state'=> count($list) ? 'SUCCESS':'ERROR',
    'list'=> $list
));