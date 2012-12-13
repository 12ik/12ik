<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

$groupid = intval($_GET['groupid']);

$strGroup = $new['group']->getOneGroup($groupid);

$title = $strGroup['groupname'];

/*
 *获取小组全部内容列表
 */
 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$url = SITE_URL.tsUrl('group','recovery',array('groupid'=>$groupid,'page'=>''));

$lstart = $page*30-30;

$arrTopic = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where groupid='$groupid' and isshow='1' order by addtime desc  limit $lstart,30");

$topicNum = $db->once_num_rows("select * from ".dbprefix."group_topics where groupid='$groupid' and isshow='1' ");

$pageUrl = pagination($topicNum, 30, $page, $url);

if($page > '1'){
	$titlepage = " - 第".$page."页";
}else{
	$titlepage='';
}

$title =$title.'小组的回收站'.$titlepage;

include template("group_recovery");