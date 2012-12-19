<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$id = intval ( $_GET ['id'] );

//根据id获取内容
$strArticle = aac('article')-> find('article_spacenews',array('itemid'=>$id));
$strArticleinfo = aac('article')->find('article_spaceitems',array('itemid'=>$strArticle['itemid']));

//更新统计 被浏览数

$db->query("update ".dbprefix."article_spaceitems set `viewnum`=viewnum+1 where itemid='$strArticle[itemid]'");



include template ( 'show' );