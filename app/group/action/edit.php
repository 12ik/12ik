<?php
//编辑小组信息
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

$groupid = intval($_GET['groupid']);

//小组信息
$strGroup = $new['group']->getOneGroup($groupid);



//判断该用户是否有权限编辑
if($userid != $strGroup['userid']) header("Location: ".SITE_URL);

switch($ts){
	
	//编辑小组基本信息
	case "base":
		
		$title = '编辑小组基本信息';
		include template("edit_base");
		
		break;
	
	//编辑小组头像
	case "icon":

		$title = '修改小组头像';
		include template("edit_icon");
		
		break;
	
	//修改访问权限
	case "privacy":

		$title = '编辑小组权限';
		include template("edit_privacy");
		
		break;
	
	//友情小组
	case "friends":

		$title = '编辑友情小组';
		include template("edit_friends");
		
		break;
	
		
	//帖子分类
	case "type":
		//调出类型
		$arrGroupType = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_type where groupid='".$strGroup['groupid']."'");
		
		$title = '编辑帖子分类';
		include template("edit_type");
		
		break;
	
}