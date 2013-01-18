<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
//用户信息
$strUser = aac('user')->getOneUser($userid);
//所在地区
$strArea = aac('location')->getAreaForApp($strUser['areaid']);	

$myGroup = $db->fetch_all_assoc("select * from ".dbprefix."group_users where userid='$userid'");


//我加入的小组
if(is_array($myGroup)){
	$count_mygroup = 0;
	foreach($myGroup as $key=>$item){
		$arrMyGroup[] = aac('group')->getOneGroup($item['groupid']);
		$count_mygroup ++;
	}
}

$myCreateGroup = $db->fetch_all_assoc("select * from ".dbprefix."group where userid='$userid'");
//我管理的小组
if(is_array($myCreateGroup)){
	$count_Admingroup = 0;
	foreach($myCreateGroup as $key=>$item){
		
		$arrMyAdminGroup[] = aac('group')->getOneGroup($item['groupid']);
		$count_Admingroup ++;
		
	}
}

$title = '我管理/加入的小组';

include template("mine");