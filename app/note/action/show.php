<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$noteid = intval ( $_GET ['noteid'] );

//根据noteid获取内容
$strNote = aac('note')-> getOneNote($noteid);
$strNote['tags'] = aac('tag')->getObjTagByObjid('note','noteid',$noteid); //标签
$strNote ['content'] = editor2html ( $strNote ['content'] );
$strNote ['user'] = aac ( 'user' )->getOneUser ( $strNote ['userid'] );

//获取评论
$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
$url = SITE_URL . ikUrl ( 'note', 'show', array ('noteid' => $noteid, 'page' => '' ) );
$lstart = $page * 10 - 10;
$arrComments = $db->fetch_all_assoc("select * from ".dbprefix."note_comment where `noteid`='$noteid' order by addtime desc limit $lstart,10");

foreach ( $arrComments as $key => $item ) {
	$arrComment [] = $item;
	$arrComment [$key] ['user'] = aac ( 'user' )->getOneUser ( $item ['userid'] );
	$arrComment [$key] ['recomment'] = $new['note']->getRecomment($item['referid']);
}
//获取评论数量
$commentNum = aac('note')->getCommnetnum($noteid);

$pageUrl = pagination ( $commentNum, 10, $page, $url );

if ($page > 1) {
	$title = $strNote ['title'] . ' - 第' . $page . '页 - ' . $strNote ['cate'] ['catename'];
} else {
	$title = $strNote ['title'] . ' - ' . $strNote ['cate'] ['catename'];
}

//更新统计 被浏览数
$userid = intval($_SESSION['ikuser']['userid']); //回话userid
if($userid != $strNote['userid']){
	$arrData = array('count_view'=> $strNote['count_view']+1);
	$new['note']->update('note',array('noteid'=>$noteid),$arrData);	
}


include template ( 'show' );