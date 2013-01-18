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

		$title='我回应的话题';

		include template("my_replied_topics");
	
		break;
	
}