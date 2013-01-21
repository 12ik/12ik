<?php
defined('IN_IK') or die('Access Denied.');

	$tag = isset($_GET['tagid']) ? trim($_GET['tagid']) : '';
	$tag = urldecode($tag);

	//所有小组
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	if(!empty($tag))
	{
		$tagid = aac('tag')->getTagId($tag);
		$tagname = aac('tag')->getOneTag($tagid);
		$url = SITE_URL.ikUrl('group','explore',array('tag'=>$tag,'page'=>''));
		$lstart = $page*20-20;
		$all_groudid = aac('tag')->findAll('tag_group_index',array('tagid'=>$tagid),null, 'groupid',$lstart.',20');
		foreach($all_groudid as $key => $item)
		{
			$arrData[] = aac('group')->getOneGroup($item['groupid']);
		}
		foreach($arrData as $key=>$item){
			$exploreGroup[] =  $item;
			$exploreGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,45);
		}	

		$groupNum = $new['group']->findCount('tag_group_index', array('tagid'=>$tagid));

		$pageUrl = pagination($groupNum, 20, $page, $url);		
		
		$title = $tag.'相关的小组';
		
	}else{
		
		$url = SITE_URL.ikUrl('group','explore',array('page'=>''));
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
			
	}
	
include template("explore");