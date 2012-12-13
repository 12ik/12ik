<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//用户是否登录
$userid = aac('user')->isLogin();

$siteid = intval($_GET['siteid']);
$roomid = intval($_GET['roomid']);
$roomname = htmlspecialchars(trim($_POST['name']));
//定义返回json
$arrJson = array();

//开始创建room
$arrData = array(		
			'name' => $roomname ,
			'addtime' => time(),
		 );
		 
$isupdate = $db->updateArr($arrData,dbprefix.'site_room','where siteid='.$siteid.' and roomid='.$roomid);
if($isupdate)
{
	$arrJson['r'] = 0;
	header("Content-Type: application/json", true);
	echo json_encode($arrJson); 
}

	 
