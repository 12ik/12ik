<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//用户是否登录
$userid = aac('user')->isLogin();

$siteid = intval($_GET['siteid']);
$strSite = aac('site')->getOneSite($siteid);
//定义返回json
$arrJson = array();
//检查用户能否创建房间 以及创建数量
$roomNum = aac('site') -> findCount('site_room',array('siteid'=>$siteid));

if($roomNum < 5)
{	 
	 $arrJson['r'] = 0;
	 $arrJson['code'] = 'go_ahead';
	 header("Content-Type: application/json", true);
	 echo json_encode($arrJson); 
	 
}else if($roomNum ==5){
	
	 $arrJson['r'] = 1;
	 $arrJson['code'] = 'not_enough';
	 $arrJson['error'] = '<div style="text-align: center;"> <h3 style="margin-bottom: 8px; font-size: 14px"> 本小站没有足够的客豆</h3> <p style="color: #aaa"> 增加一个房间上限需要从小站处扣减10颗客豆。你可以用"捐赠应用"将自己的部分客豆转移到小站上。';
	 header("Content-Type: application/json", true);
	 echo json_encode($arrJson); 
	 
}