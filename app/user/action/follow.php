<?php
defined('IN_IK') or die('Access Denied.');
	/* 
	 * 用户被跟随
	 */

	$userid = intval($_GET['userid']);
	
	$strUser = $new['user']->getOneUser($userid);
	
	if($strUser == '') header("Location: ".SITE_URL."index.php");
	
	//我关注的人
	$followUsers = $db->fetch_all_assoc("select userid_follow from ".dbprefix."user_follow where userid='$userid'");
	echo $followUsersNum;
	
	if(is_array($followUsers)){
		foreach($followUsers as $item){
			$arrFollowUser[] =  $new['user']->getOneUser($item['userid_follow']);
		}
	}
	
	if($userid == $IK_USER['user']['userid'])
	{
		$title = '我关注的人';
	}else{
		$title = $strUser['username'].'关注的人';
	}
	include template("follow");