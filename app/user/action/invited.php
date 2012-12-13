<?php
defined('IN_IK') or die('Access Denied.');

//确认邀请码
$saltmail = trim($_GET['confirmation']);

$invitedUser = aac('user')->find('user_invited',array('saltmail'=>$saltmail));

if($invitedUser)
{		
	$title = '爱客网邀请您加入';
	include template("invited");
}else{
	header ( "Location: ".SITE_URL);
}



