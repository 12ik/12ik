<?php
defined('IN_IK') or die('Access Denied.');

/* 
 * 小组话题内容页
 */

$topicid = intval($_GET['id']);

$strTopic = $new['group']->getOneTopic($topicid);
	
//帖子分类
if($strTopic['typeid'] != '0'){
	$strTopic['type'] = $db->once_fetch_assoc("select * from ".dbprefix."group_topics_type where typeid='".$strTopic['typeid']."'");
}

//小组
$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid='".$strTopic['groupid']."'");

//判断会员是否加入该小组
$groupid = intval($strGroup['groupid']);
$userid = intval($IK_USER['user']['userid']);

$isGroupUser = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");

//浏览方式
if($strGroup['isopen']=='1' && $isGroupUser=='0'){
	
	$title = $strTopic['title'];
	include template("topic_isopen");
	
}else{
	
	//上一篇帖子
	$upTopic = $new['group']->find('group_topics','topicid<'.$topicid.' and groupid='.$groupid,'topicid,title');
	
	//下一篇帖子
	$downTopic = $new['group']->find('group_topics','topicid>'.$topicid.' and groupid='.$groupid,'topicid,title');
	
	//匹配本地图片
	$strcontent = $strTopic['content'];	
	preg_match_all ( '/\[(图片)(\d+)\]/is', $strcontent, $photos );		
	foreach ($photos [2] as $item) {
		$strPhoto = aac('group')->getPhotoByseq($topicid,$item);
		$htmlTpl = '<div class="img_'.$strPhoto['align'].'">
						<img alt="'.$strPhoto['photodesc'].'" src="'.$strPhoto['photo_500'].'" />
						<span class="img_title" >'.$strPhoto['photodesc'].'</span>
					</div><div class="clear"></div>';

		$strcontent = str_replace ( '[图片'.$item.']', $htmlTpl, $strcontent );
	}
	//匹配链接
	preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
	$strcontent, $contenturl);
	foreach($contenturl[2] as $c1)
	{	
		$strcontent = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $strcontent);
		$strcontent = str_replace ( "[/url]", '</a>', $strcontent);
	}	
	

	//帖子标签
	$strTopic['tags'] = aac('tag')->getObjTagByObjid('topic','topicid',$topicid);
	$strTopic['content'] = $strcontent;
	$strTopic['user']	= aac('user')->getOneUser($strTopic['userid']);
	$strTopic['user']['signed'] = hview($strTopic['user']['signed']);
	$title = $strTopic['title'];
	
	//评论列表开始
	$sc = isset($_GET['sc']) ? $_GET['sc'] : 'asc';
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	//倒序asc
	if($sc=='asc'){
		$url = SITE_URL.ikUrl('group','topic',array('id'=>$topicid,'sc'=>$sc,'page'=>''));
	}else{
		$url = SITE_URL.ikUrl('group','topic',array('id'=>$topicid,'page'=>''));
	}
	
	
	$lstart = $page*15-15;
	
	$arrComment = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_comments where `topicid`='$topicid' order by addtime $sc limit $lstart,15");
	foreach($arrComment as $key=>$item){
		$arrTopicComment[] = $item;
		$arrTopicComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
		$arrTopicComment[$key]['content'] = editor2html($item['content']);
		$arrTopicComment[$key]['recomment'] = $new['group']->recomment($item['referid']);
	}
	
	$commentNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."group_topics_comments where `topicid`='$topicid'");
	
	$pageUrl = pagination($commentNum['count(*)'], 15, $page, $url);
	//评论列表结束
	
	
	//判断会员是否加入该小组
	$userid = intval($IK_USER['user']['userid']);
	$isGroupUser = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='".$strTopic['groupid']."'");

	
	$groupid = $strTopic['groupid'];
	
	//小组成员
	$strGroupUser = $db->once_fetch_assoc("select * from ".dbprefix."group_users where userid='$userid' and groupid='".$strTopic['groupid']."'");
	
	//最新帖子
	$newTopics = $db->fetch_all_assoc("select topicid,userid,title from ".dbprefix."group_topics where groupid='$groupid' and isshow='0' order by addtime desc limit 6");
	
	foreach($newTopics as $key=>$item){
		$newTopic[] = $item;
		$newTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
	}
	
	($page > 1) ? $titlepage = "_第".$page."页" : $titlepage='';
	
	$title = $title.$titlepage.'_'.$strGroup['groupname'];
	
	include template('topic');
	
	//增加浏览次数
	$new['group']->update('group_topics',array(
		'topicid'=>$topicid,
	),array(
		'count_view'=>$strTopic['count_view']+1,
	));
	
}