<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

//用户信息
$strUser = aac('user')->getOneUser($userid);
//所在地区
$strArea = aac('location')->getAreaForApp($strUser['areaid']);
	
//小组模式的跳转
//if(intval($IK_APP['options']['ismode'])=='1'){
//	header("Location: ".SITE_URL.U('group','show',array('id'=>'1')));
//	exit;
//}

//我的小组
$myGroup = $new['group']->findAll('group_users',array(
	'userid'=>$userid,
));

if($myGroup != ''){

	//我加入的小组
	/*$myGroups = $new['group']->findAll('group_users',array(
		'userid'=>$userid,
	),null,'groupid',30);
	
	if(is_array($myGroups)){
		foreach($myGroups as $key=>$item){
			$arrMyGroup[] = $new['group']->getOneGroup($item['groupid']);
		}
	}
	//我管理的小组
	$myCreateGroup = $db->fetch_all_assoc("select * from ".dbprefix."group where userid='$userid'");
	if(is_array($myCreateGroup)){
		foreach($myCreateGroup as $key=>$item){
			
			$arrMyAdminGroup[] = $new[group]->getOneGroup($item['groupid']);
			
		}
	}
	*/
	
	//我加入的所有小组的话题
	if(is_array($myGroup)){
		foreach($myGroup as $item){
			$arrGroup[] = $item['groupid'];
		}
	}
	
	$strGroup = implode(',',$arrGroup);
	if($strGroup){
		$arrTopics = $db->fetch_all_assoc("select topicid,userid,groupid,title,count_comment,count_view,istop,isphoto,isattach,isposts,isvideo,addtime,uptime from ".dbprefix."group_topics where groupid in ($strGroup) and isshow='0' order by uptime desc limit 50");
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
			$arrTopic[$key]['photo'] = $new['group']->getOnePhoto($item['topicid']);
		}
	}

}

$title = '我的小组话题';

include template("my_group_topics");