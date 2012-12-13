<?php
defined('IN_IK') or die('Access Denied.');

$userid = intval($_GET['userid']);

$strUser = $new['user']->getOneUser($userid);

if($strUser == '') header("Location: ".SITE_URL."index.php");

//关注我的人
$followedUsers = $db->fetch_all_assoc("select userid from ".dbprefix."user_follow where userid_follow='$userid' order by addtime");


if(is_array($followedUsers)){
	foreach($followedUsers as $key=> $item){
		$arrFollowedUser[$key] =  $new['user']->getOneUser($item['userid']);
		$isfollow = $db->fetch_all_assoc("select userid from ".dbprefix."user_follow where userid ='$userid' and userid_follow='$item[userid]' order by addtime");
		$arrFollowedUser[$key]['isfollow'] = empty($isfollow)?0:1;
	}
}

	if($userid == $IK_USER['user']['userid'])
	{
		$title = '关注我的人';
	}else{
		$title = '关注'.$strUser['username'].'的人';
	}
	
include template('followed');