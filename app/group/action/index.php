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
	header("Location: ".SITE_URL.ikUrl('group','my_group_topics'));	
}