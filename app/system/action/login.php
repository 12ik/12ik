<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik爱客网 用户登录
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//登录
switch ($ik) {
	case "" :
		
		$title = '登录后台';
		include template ( "login" );
		break;
	
	case "do" :
		
		$email = trim ( $_POST ['email'] );
		$pwd = trim ( $_POST ['pwd'] );
		$cktime = $_POST ['cktime'];
		
		if ($email == '' || $pwd == '')
			qiMsg ( "所有输入项都不能为空^_^" );
		
		$countAdmin = $db->once_fetch_assoc ( "select count(*) from " . dbprefix . "user where `email`='$email'" );
		
		if ($countAdmin ['count(*)'] == 0)
			qiMsg ( '用户Email不存在！' );
		
		$strAdmin = $db->once_fetch_assoc ( "select * from " . dbprefix . "user where `email`='$email'" );
		
		if (md5 ( $strAdmin ['salt'] . $pwd ) !== $strAdmin ['pwd'])
			ikNotice ( '用户密码错误！' );
		
		$strAdminInfo = $db->once_fetch_assoc ( "select userid,username,isadmin from " . dbprefix . "user_info where email='$email'" );
		
		if ($strAdminInfo ['isadmin'] != 1)
			qiMsg ( "你无权登录后台管理！" );

		$_SESSION ['ikadmin'] = $strAdminInfo;
		
		$_SGLOBAL['admin_uid'] = $strAdminInfo['userid'];
		$_SGLOBAL['admin_username'] = $strAdminInfo['username'];

		header ( "Location: " . SITE_URL . "index.php?app=system" );
		
		break;
	
	//退出 
	case "out" :
		unset ( $_SESSION ['ikadmin'] );
		
		header ( "Location: " . SITE_URL . "index.php?app=system&a=login" );
		
		break;
}