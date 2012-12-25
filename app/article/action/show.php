<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$id = intval ( $_GET ['id'] );

//根据id获取内容
$strArticle = aac('article')-> find('article_spacenews',array('nid'=>$id));
$strArticleinfo = aac('article')->find('article_spaceitems',array('itemid'=>$strArticle['itemid']));


//获取评论
$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
$url = SITE_URL . tsUrl ( 'article', 'show', array ('id' => $id, 'page' => '' ) );
$lstart = $page * 10 - 10;
$arrComments = $db->fetch_all_assoc("select * from ".dbprefix."article_comments where `nid`='$id' order by addtime desc limit $lstart,10");
foreach ( $arrComments as $key => $item ) {
	$arrComment [] = $item;
	$arrComment [$key] ['user'] = aac ( 'user' )->getOneUser ( $item ['userid'] );
	$arrComment [$key] ['recomment'] = aac('article')->getRecomment($item['referid']);
}


//更新统计 被浏览数
$db->query("update ".dbprefix."article_spaceitems set `viewnum`=viewnum+1 where itemid='$strArticle[itemid]'");


$title = $strArticleinfo['subject'];
include template ( 'show' );