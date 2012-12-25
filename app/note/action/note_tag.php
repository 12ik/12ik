<?php
//帖子标签
defined('IN_IK') or die('Access Denied.');

$tagname = urldecode(trim($_GET['tagname']));

$tagid = aac('tag')->getTagId(t($tagname));

$strTag = $db->once_fetch_assoc("select * from ".dbprefix."tag where tagid='$tagid'");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$url = SITE_URL.ikUrl('note','note_tag',array('tagid'=>$tagid,'page'=>''));

$lstart = $page*30-30;

$arrTagId = $db->fetch_all_assoc("select * from ".dbprefix."tag_note_index where tagid='$tagid' limit $lstart,30");

$note_num = $db->once_fetch_assoc("select count(noteid) from ".dbprefix."tag_note_index where tagid='$tagid'");

$pageUrl = pagination($note_num['count(noteid)'], 30, $page, $url);

foreach($arrTagId as $item){

	$strNote = $db->once_fetch_assoc("select * from ".dbprefix."note where noteid = '".$item['noteid']."'");
	$arrNotes[] = $strNote;
	
}

foreach($arrNotes as $key=>$item){
	$arrNote[] = $item;
	$arrNote[$key]['content'] = getsubstrutf8(t($item['content']),0,50);
	$arrNote[$key]['user'] = aac('user')->getOneUser($item['userid']);
}

//热门tag
$arrTag = $db->fetch_all_assoc("select * from ".dbprefix."tag order by count_note desc limit 10");

$title = $strTag['tagname'].'列表';

include template("note_tag");