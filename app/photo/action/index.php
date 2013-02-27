<?php 
defined('IN_IK') or die('Access Denied.');
$page = isset($_GET['page']) ? $_GET['page'] : '1';

$url = SITE_URL."index.php?app=photo&a=index&page=";

$lstart = $page*28-28;

$arrAlbum = $db->fetch_all_assoc("select * from ".dbprefix."photo_album where `isrecommend`='1' order by albumid desc limit $lstart,28");

$albumNum = $db->once_num_rows("select * from ".dbprefix."photo_album  where `isrecommend`='1'");

$pageUrl = pagination($albumNum, 28, $page, $url);



//获取最新的评论
$arrComments = $db->fetch_all_assoc("select * from ".dbprefix."photo_comment order by addtime desc limit 30");
foreach($arrComments as $key=>$item){
	$arrComment[] = $item;
	$arrComment[$key]['user'] = aac('user')->getOneUser($item['userid']);;
}


$title = '推荐相册';
include template("index");