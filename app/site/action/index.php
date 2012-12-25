<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ik) {
	case "" :
		//未创建小站
		//$userid = aac('user')->isLogin();
		$title = "我的小站";
		include template("index");
		break;
	case "user" :
		$userid = intval ( $_GET ['userid'] );
		//获取用户信息
		
		include template ( 'index' );
		break;

}