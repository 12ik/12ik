<?php
defined('IN_IK') or die('Access Denied.');

	$tag = isset($_GET['tag']) ? trim($_GET['tag']) : '';

	//所有小组
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	if(!empty($tag))
	{
		$url = SITE_URL.ikUrl('group','explore',array('tag'=>$tag,'page'=>''));
	}else{
		$url = SITE_URL.ikUrl('group','explore',array('page'=>''));
	}
	$lstart = $page*20-20;
	
	$arrGroups = $new['group']->findAll('group',null,'isrecommend desc','groupid',$lstart.',20');
	
	foreach($arrGroups as $key=>$item){
		$arrData[] = $new['group']->getOneGroup($item['groupid']);
	}
	foreach($arrData as $key=>$item){
		$exploreGroup[] =  $item;
		$exploreGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,45);
	}
	
	$groupNum = $new['group']->findCount('group');
	
	$pageUrl = pagination($groupNum, 20, $page, $url);
	

$title = '发现小组';
include template("explore");