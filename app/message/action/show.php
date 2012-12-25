<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
$messageid = intval($_GET['messageid']);

$arrMessages = aac('message')->find('message',array('messageid'=>$messageid));
$arrMessages['addtime'] = date('Y-m-d H:i',$arrMessages['addtime']);

if($arrMessages['userid'] == $userid)
{
	//发往对方
	if($arrMessages['isoutbox']==1){ header("Location: ".SITE_URL.ikUrl('message','ikmail',array('ik'=>'inbox')));  }
	$touser = aac('user')->getOneUser($arrMessages['touserid']);//来自哪位用户
	$touserArea = aac('location')->getAreaForApp($touser['areaid']);//来自哪位用户的地址
	$touserArea = empty($touserArea['three']['areaname']) ? '火星' : $touserArea['three']['areaname'];
	$strUserinfo = '<span class="m">发往：'.$touser['username'].'（'.$touserArea.'）</span>';
	$type = 'outbox';
	$title = '我发送的消息';	
}

if($arrMessages['touserid'] == $userid)
{
	//接收的信息
	if($arrMessages['isinbox']==1){ header("Location: ".SITE_URL.ikUrl('message','ikmail',array('ik'=>'inbox')));  }
	$touser = aac('user')->getOneUser($arrMessages['userid']);//来自哪位用户
	$touserArea = aac('location')->getAreaForApp($touser['areaid']);//来自哪位用户的地址
	$touserArea = empty($touserArea['three']['areaname']) ? '火星' : $touserArea['three']['areaname'];
	$strUserinfo = '<span class="m">来自：'.$touser['username'].'（'.$touserArea.'）</span>';
	$type = 'inbox';
	//isread设为已读
	$db->query("update ".dbprefix."message set `isread`='1' where touserid='$userid' and `isread`='0' and messageid='$messageid' ");	
	
	$title = '我接收的消息';
}

if($arrMessages['userid'] == 0 && $arrMessages['touserid']==$userid)
{
	//接收的信息 系统消息
	if($arrMessages['isinbox']==1){ header("Location: ".SITE_URL.ikUrl('message','ikmail',array('ik'=>'inbox'))); }
	$strUserinfo = '<span class="m">来自：<span class="sys_doumail_big">系统邮件</span> </span>';
	$touser = aac('user')->getOneUser($arrMessages['userid']);//来自哪位用户;
	//isread设为已读
	$db->query("update ".dbprefix."message set `isread`='1' where userid='0' and touserid='$userid' and `isread`='0' and messageid='$messageid'  ");	
	$title = '我接收的系统消息';
}




include template("show");
