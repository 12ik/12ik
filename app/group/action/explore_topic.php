<?php
defined('IN_IK') or die('Access Denied.');

	//发现新的话题 根据标签
	$tag = isset($_GET['tagid']) ? trim($_GET['tagid']) : '';
	$tag = urldecode($tag);

	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	
	if(!empty($tag))
	{
		$tagid = aac('tag')->getTagId($tag);
		$tagname = aac('tag')->getOneTag($tagid);
		$url = SITE_URL.ikUrl('group','explore_topic',array('tag'=>$tag,'page'=>''));
		$lstart = $page*20-20;
		$all_id = aac('tag')->findAll('tag_topic_index',array('tagid'=>$tagid),null, 'topicid',$lstart.',20');	
		
		foreach($all_id as $key => $item)
		{
			$arrData[] = aac('group')->getOneTopic($item['topicid']);
		}
		foreach($arrData as $key=>$item){
			$arrTopic[] =  $item;
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}	
				
		$groupNum = $new['group']->findCount('tag_topic_index', array('tagid'=>$tagid));

		$pageUrl = pagination($groupNum, 20, $page, $url);		
		
		$title = $tag.'相关的话题';
			
	}else{
	
		$arrTopics = aac('group')->getHotTopics($page, 20);
	
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		}	
		
		$title = '发现话题';	
	}

include template("explore_topic");