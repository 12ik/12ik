<?php 
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){

	//我发起的话题
	case "":

		//用户信息
		$strUser = aac('user')->getOneUser($userid);
		//所在地区
		$strArea = aac('location')->getAreaForApp($strUser['areaid']);	

		$arrTopics = $db->fetch_all_assoc("select topicid,groupid,userid,title,count_comment,isvideo,addtime,uptime from ".dbprefix."group_topics where userid='".$userid."' and groupid > 0 order by addtime desc limit 30");
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}

		$title = '我发起的话题';

		include template("my_topics");
	
		break;
	
}