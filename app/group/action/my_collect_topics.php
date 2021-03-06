<?php 
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){

	//我收藏的帖子 
	case "":

		//用户信息
		$strUser = aac('user')->getOneUser($userid);
		//所在地区
		$strArea = aac('location')->getAreaForApp($strUser['areaid']);		

		$arrCollect = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_collects where userid='".$userid."' order by addtime desc limit 30");

		foreach($arrCollect as $item){

			$strTopic = $db->once_fetch_assoc("select topicid,userid,groupid,title,count_comment,count_view,isphoto,isattach,isvideo,addtime,uptime from ".dbprefix."group_topics where topicid = '".$item['topicid']."'");
			$arrTopics[] = $strTopic;
			
		}

		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}

		$title = '我收藏的话题';

		include template("my_collect_topics");
		
		break;
	
}