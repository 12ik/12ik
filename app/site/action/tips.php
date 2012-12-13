<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
//用户是否登录
$userid = aac('user')->isLogin();

//修改提示层
$siteid = intval($_GET['siteid']);
$isSetting = intval($_POST['isSetting']);
//定义返回json
$arrJson = array();

//开始创建room
$arrData = array(		
			'issetting' => $isSetting
		 );
		 
$isupdate = $db->updateArr($arrData,dbprefix.'site','where siteid='.$siteid);
if($isupdate)
{
	$arrJson['r'] = 0;
	header("Content-Type: application/json", true);
	echo json_encode($arrJson); 
}