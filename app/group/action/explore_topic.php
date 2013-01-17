<?php
defined('IN_IK') or die('Access Denied.');

//发现新的话题 根据标签
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$arrTopics = aac('group')->getHotTopics($page, 20);

	foreach($arrTopics as $key=>$item){
		$arrTopic[] = $item;
		$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
	}

	

$title = '发现话题';
include template("explore_topic");