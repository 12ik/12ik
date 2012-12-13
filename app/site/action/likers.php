<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$siteid = intval($_GET['id']);
//加载风格
include_once 'theme.php';

//页面
switch ($ts) {
	case "" :
	//小站管理员
	$adminUser = aac('user')->getOneUser($strSite['userid']);
	//查询喜欢该小站的成员
	$likeUsers = aac('site')->findAll('site_follow', array('follow_siteid'=>$siteid));
	$likesiteNum = 0;
	foreach($likeUsers as $key=>$item) 
	{
		$likesiteNum = $key + 1;
		$arrlikeUser[] = aac('user')->getOneUser($item['userid']);
		
	}
	$title = "喜欢".$strSite['sitename']."的成员(".$likesiteNum.")";	
	include template("likers");
	break;

}