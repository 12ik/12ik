<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//用户是否登录
$userid = aac('user')->isLogin();

$siteid = intval($_GET['siteid']);
//定义返回json
$arrJson = array();

//初始化 room
$arrData = array(
			'siteid' => $siteid,
			'userid' => $userid,
			'name' => '未命名房间',
			'addtime' => time(),
		 );
		 
$roomid    = $db->insertArr($arrData,dbprefix.'site_room');
$ordertext = aac('site')->getNavOrderBysiteId($siteid);
$ordertext = $ordertext['ordertext'].','.$roomid;
//初始化导航
$NavOrderId = $db->updateArr(array('ordertext'=>$ordertext),dbprefix.'site_room_navorder','where siteid='.$siteid);

if($roomid > 0 && $NavOrderId > 0)
{
	$arrJson['r'] = 0;
	$arrJson['room'] = SITE_URL.U('site','room',array('roomid'=>$roomid, 'siteid'=>$siteid));
	header("Content-Type: application/json", true);
	echo json_encode($arrJson); 
}

	 
