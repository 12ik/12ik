<?php 
defined('IN_IK') or die('Access Denied.');
$arrPhotos = $db->fetch_all_assoc("select * from ".dbprefix."photo where `isrecommend`='1' order by photoid desc limit 60");

foreach($arrPhotos as $key=>$item){
	$arrPhoto[] = $item;
	$arrPhoto[$key]['user'] = aac('user')->getOneUser($item['userid']);
}

$title = '精彩图片';

include template("new");