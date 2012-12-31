<?php 
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){

	//我发起的话题
	case "topic":
	
		$arrTopics = $db->fetch_all_assoc("select topicid,groupid,userid,title,count_comment,isvideo,addtime,uptime from ".dbprefix."group_topics where userid='".$userid."' and groupid > 0 order by addtime desc limit 30");
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}

		$title = '我发起的话题';

		include template("my_topic");
	
		break;
		
	//回应的话题 
	case "reply":
		
		$myTopics = $db->fetch_all_assoc("select topicid from ".dbprefix."group_topics_comments where userid='".$IK_USER['user']['userid']."' group by topicid order by addtime desc limit 30");


		foreach($myTopics as $item){

			$strTopic = $db->once_fetch_assoc("select topicid,userid,groupid,title,count_comment,count_view,isphoto,isattach,isvideo,addtime,uptime from ".dbprefix."group_topics where topicid = '".$item['topicid']."'");
			$arrTopics[] = $strTopic;
			
		}

		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}

		$title='我最近回复的话题';

		include template("my_reply");
		
		break;
		
	//我收藏的帖子 
	case "collect":
		
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

		include template("my_collect");
		
		break;
}