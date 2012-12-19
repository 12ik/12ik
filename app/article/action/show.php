<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$id = intval ( $_GET ['id'] );
echo $id;
//根据id获取内容
$strArticle = aac('article')-> find('article_spacenews',array('itemid'=>$id));

//更新统计 被浏览数
$arrData = array('viewnum'=> $strArticle['viewnum']+1);
aac('article')->update('article_spaceitems',array('itemid'=>$itemid),$arrData);	



include template ( 'show' );