<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

$arrToUsers = $db->fetch_all_assoc("select userid from ".dbprefix."message where userid > '0' and touserid='$userid' group by userid");

if(is_array($arrToUsers)){
	foreach($arrToUsers as $key=>$item){
		$arrToUser[] = $item;
		$arrToUser[$key]['user'] = aac('user')->getOneUser($item['userid']);
		$arrToUser[$key]['count'] = $db->once_num_rows("select * from ".dbprefix."message where touserid='$userid' and userid='".$item['userid']."' and isread='0'");
	}
}

//统计系统消息
$systemNum = $db->once_num_rows("select * from ".dbprefix."message where userid='0' and touserid='$userid' and isread='0'");


	include template("my");
