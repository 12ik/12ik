<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
/**
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
**/
switch($ik){

	//收件箱
	case "inbox":
	$sql = "select * from ".dbprefix."message where touserid='$userid' and isspam<>1 and isinbox='0' order by addtime desc LIMIT 0 , 10";
	$unreadnum = aac('message')->findCount('message',array('touserid'=>$userid,'isread'=>'0','isinbox'=>'0'));//未读邮件数目
	$spamnum = aac('message')->findCount('message',array('touserid'=>$userid,'isspam'=>'1','isinbox'=>'0'));//垃圾邮件数目
	$arrMessages = $db->fetch_all_assoc($sql);

	foreach($arrMessages as $key=>$item){
		$arrMessage[] = $item;
		$arrMessage[$key]['user']	 = aac('user')->getOneUser($item['userid']);
		$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
		$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
	}
	$title = '我的收件箱';
	include template("inbox");
	break;
	
	//收件箱
	case "unread":
	$sql = "select * from ".dbprefix."message where touserid='$userid' and isread='0' and isinbox='0' order by addtime desc LIMIT 0 , 10";
	$unreadnum = aac('message')->findCount('message',array('touserid'=>$userid,'isread'=>'0','isinbox'=>'0'));//未读邮件数目
	$spamnum = aac('message')->findCount('message',array('touserid'=>$userid,'isspam'=>'1','isinbox'=>'0'));//垃圾邮件数目
	$arrMessages = $db->fetch_all_assoc($sql);

	foreach($arrMessages as $key=>$item){
		$arrMessage[] = $item;
		$arrMessage[$key]['user']	 = aac('user')->getOneUser($item['userid']);
		$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
		$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
	}
	$title = '我的收件箱';
	include template("inbox");
	break;	
	
	//收件箱
	case "spam":
	$sql = "select * from ".dbprefix."message where touserid='$userid' and isspam='1' and isinbox='0' order by addtime desc LIMIT 0 , 10";
	$unreadnum = aac('message')->findCount('message',array('touserid'=>$userid,'isread'=>'0','isinbox'=>'0'));//未读邮件数目
	$spamnum = aac('message')->findCount('message',array('touserid'=>$userid,'isspam'=>'1','isinbox'=>'0'));//垃圾邮件数目
	$arrMessages = $db->fetch_all_assoc($sql);

	foreach($arrMessages as $key=>$item){
		$arrMessage[] = $item;
		$arrMessage[$key]['user']	 = aac('user')->getOneUser($item['userid']);
		$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
		$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
	}
	$title = '我的收件箱';
	include template("inbox");
	break;		
	
	case "outbox":
	$sql = "select * from ".dbprefix."message where userid='$userid' and isoutbox='0' order by addtime desc LIMIT 0 , 10";
	$arrMessages = $db->fetch_all_assoc($sql);

	foreach($arrMessages as $key=>$item){
		$arrMessage[] = $item;
		$arrMessage[$key]['touser']	 = aac('user')->getOneUser($item['touserid']);
		$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
		$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
	}

	$title = '我的发件箱';
	include template("outbox");
	break;

	case "notification":

	$title = '我的提醒';
	include template("notification");
	break;
	
	case "choose":
	$followUsers = $db->fetch_all_assoc("select userid_follow from ".dbprefix."user_follow where userid='$userid' order by addtime");
	if(is_array($followUsers)){
		foreach($followUsers as $item){
			$arrFollowUser[] =  aac('user')->getOneUser($item['userid_follow']);
		}
	}

	$title = '写信-选择收件人';
	include template("choose");
	break;						
}