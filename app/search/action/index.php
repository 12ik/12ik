<?php 
defined('IN_IK') or die('Access Denied.');
switch($ik){
	case "":
		$title = '搜索';
		break;
	
	//搜索小组
	case "group":
		$title = '搜索小组';
		break;
		
	//搜索帖子
	case "topic":
		$title = '搜索帖子';
		break;
		
	//搜索用户
	case "user":
		$title = '搜索用户';
		break;
	//搜索日志
	case "user":
		$title = '搜索日志';
		break;
	//搜索小站
	case "user":
		$title = '搜索小站';
		break;
		
}

include template("index");