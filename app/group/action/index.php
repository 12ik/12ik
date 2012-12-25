<?php
defined('IN_IK') or die('Access Denied.');

//小组首页

if($IK_USER['user'] == ''){

	//所有小组
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$url = SITE_URL.ikUrl('group','all',array('page'=>''));
	$lstart = $page*20-20;
	
	$arrGroups = $new['group']->findAll('group',null,'isrecommend desc','groupid',$lstart.',20');
	
	foreach($arrGroups as $key=>$item){
		$arrData[] = $new['group']->getOneGroup($item['groupid']);
	}
	foreach($arrData as $key=>$item){
		$arrRecommendGroup[] =  $item;
		$arrRecommendGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,35);
	}
	
	$groupNum = $new['group']->findCount('group');
	
	$pageUrl = pagination($groupNum, 20, $page, $url);


	//最新10个小组
	$arrNewGroup = $new['group']->getNewGroup('10');
	
	//热门帖子
	$arrTopic = $new['group']->findAll('group_topics',null,'count_comment desc','topicid,title,count_comment',10);
	
	
	$title = '小组';

	include template("index");
	
}else{

	$userid = intval($IK_USER['user']['userid']);
	
	if($userid == '0') header("Location: ".SITE_URL."index.php");
	
	//小组模式的跳转
	if(intval($IK_APP['options']['ismode'])=='1'){
		header("Location: ".SITE_URL.ikUrl('group','show',array('id'=>'1')));
		exit;
	}
	
	//我的小组
	$myGroup = $new['group']->findAll('group_users',array(
		'userid'=>$userid,
	));
	
	if($myGroup != ''){
	
		//我加入的小组
		$myGroups = $new['group']->findAll('group_users',array(
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
		
		//我加入的所有小组的话题
		if(is_array($myGroup)){
			foreach($myGroup as $item){
				$arrGroup[] = $item['groupid'];
			}
		}
		
		$strGroup = implode(',',$arrGroup);
		if($strGroup){
			$arrTopics = $db->fetch_all_assoc("select topicid,userid,groupid,title,count_comment,count_view,istop,isphoto,isattach,isposts,addtime,uptime from ".dbprefix."group_topics where groupid in ($strGroup) and isshow='0' order by uptime desc limit 50");
			foreach($arrTopics as $key=>$item){
				$arrTopic[] = $item;
				$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
				$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
				$arrTopic[$key]['photo'] = $new['group']->getOnePhoto($item['topicid']);
			}
		}
	
	}
	
	$title = '我的小组';
	
	include template("my_group");
	
}