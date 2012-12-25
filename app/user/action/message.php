<?php
defined('IN_IK') or die('Access Denied.');
 
//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	//发送消息页面
	case "message_add":
		
		$touserid = intval($_GET['touserid']);
		
		if($userid == $touserid || !$touserid) ikNotice("Sorry！自己不能给自己发送消息的！& 对方为空!");
		
		$strUser = $new['user']->getOneUser($userid);
		
		$strTouser = $new['user']->getOneUser($touserid);

		if(!$strTouser) ikNotice("Sorry！对方不存在!");
		$title = "发送短消息";
		include template("message_add");
		break;
	
	//
	case "message_add_do":
	
		$msg_userid = $_POST['userid'];
		$msg_touserid = $_POST['touserid'];
		$msg_title	= htmlspecialchars(trim($_POST['title']));
		$msg_content = htmlspecialchars(trim($_POST['content']));
		
		if($msg_title=='' || $msg_content=='') qiMsg("标题和内容都不能为空！");
		if(mb_strlen($msg_title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
		if(mb_strlen($msg_content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
		
		aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_title,$msg_content);
		header("Location: ".SITE_URL.ikUrl('message','ikmail',array('ik'=>'outbox')));
		
		break;
}