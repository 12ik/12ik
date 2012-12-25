<?php
defined('IN_IK') or die('Access Denied.');
//所有小组
$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.ikUrl('group','all',array('page'=>''));
$lstart = $page*20-20;
$arrGroups = $db->fetch_all_assoc("select groupid from ".dbprefix."group order by isrecommend desc limit $lstart,20");
foreach($arrGroups as $key=>$item){
	$arrData[] = $new['group']->getOneGroup($item['groupid']);
}
foreach($arrData as $key=>$item){
	$arrGroup[] =  $item;
	$arrGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,35);
}
$groupNum = $db->once_fetch_assoc("select count(groupid) from ".dbprefix."group");
$pageUrl = pagination($groupNum['count(groupid)'], 20, $page, $url);
if($page > 1){
	$title = '发现小组 - 第'.$page.'页';
}else{
	$title = '发现小组';
}

//我加入的小组
$myGroup = array();
if($IK_USER['user']['userid']){
	$myGroups = $new['group']->findAll('group_users',array(
		'userid'=>$IK_USER['user']['userid'],
	),null,'groupid');	
	foreach($myGroups as $item){
		$myGroup[]=$item['groupid'];
	}
}


//热门帖子
$arrTopic = $db->fetch_all_assoc("select topicid,title,count_comment from ".dbprefix."group_topics order by count_comment desc limit 10");

//最新10个小组
$arrNewGroup = $new['group']->getNewGroup('10');

include template('all');