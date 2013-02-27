<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12IK爱客网 APP单入口
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//APP模板CSS,IMG,INC
$IK_APP ['tpl'] = array ('skin' => 'app/' . $app . '/skins/', 'js' => 'app/' . $app . '/js/' );

//system系统管理模板CSS,IMG
$IK_APP ['system'] = array ('skin' => 'app/system/skins/', 'js' => 'app/system/js/' );

//加载APP应用首页和配置文件
if (is_file ( 'app/' . $app . '/action/' . $a . '.php' )) {
	
	//加载系统缓存文件 
	$IK_SITE ['base'] = fileRead ( 'data/system_options.php' );
	
	$_SGLOBAL = $_SCONFIG = $IK_SITE ['base'];
	$_SGLOBAL['db'] = $db;
	$_SGLOBAL['timestamp'] = time();
	$_SGLOBAL['supe_uid'] = $IK_USER['admin']['userid'];
	$_SGLOBAL['supe_username'] = $IK_USER['admin']['username'];
	
	//配置
	$_SCONFIG['timeoffset'] = 8;//设置时区 默认中国香港
	$_SCONFIG['thumbarray'] = array('news' => array($_SCONFIG['thumbwidth'],$_SCONFIG['thumbheight']));//设置文章页面图片高宽

	
	//设置时区
	date_default_timezone_set ( $IK_SITE ['base'] ['timezone'] );
	
	//加载APP导航
	$IK_SITE ['appnav'] = fileRead ( 'data/system_appnav.php' );
	
	define ( 'SITE_URL', $IK_SITE ['base'] ['site_url'] );
	
	//定义全局附件路径默认 uploadfile/attachments
	define ( 'IKUPLOADPATH', $_SCONFIG['attachmentdir'] );//上传附件地址
	define ( 'ATT_URL', SITE_URL.IKUPLOADPATH);
	
	
	//主题
	$site_theme = $IK_SITE ['base'] ['site_theme'];
	
	//加载APP配置缓存文件
	if ($app != 'system') {
		
		$IK_APP ['options'] = fileRead ( 'data/' . $app . '_options.php' );
				
		if ($IK_APP ['options'] ['isenable'] == '1' && $a != 'admin') {
			qiMsg ( $app . "应用关闭，请开启后访问！" );
		}
	
	}
	
	//加载APP数据库操作类并建立对象
	include_once 'app/'.$app.'/config.php';
	include_once 'app/'.$app.'/class.'.$app.'.php';
	$new[$app] = new $app($db);
	
	
	//控制前台ADMIN访问权限
	if ($a == 'admin' && $IK_USER ['admin'] ['isadmin'] != 1 && $app != 'system') {
		header ( "Location: " . SITE_URL );
		exit ();
	}
	
	//控制后台访问权限
	if ($IK_USER ['admin'] ['isadmin'] != 1 && $app == 'system' && $a != 'login') {
		header ( "Location: " . SITE_URL . U ( 'system', 'login' ) );
		exit ();
	}
	
	//控制插件设置权限
	if ($IK_USER ['admin'] ['isadmin'] != 1 && $in == 'edit') {
		header ( "Location: " . SITE_URL . U ( 'system', 'login' ) );
		exit ();
	}

	
	//运行统计结束
	$time_end = getmicrotime ();
	
	$runTime = $time_end - $time_start;
	$runTime = number_format ( $runTime, 6 );
	
	
	//用户自动登录
	if ($IK_USER ['user'] == '' && $_COOKIE ['ik_email'] != '' && $_COOKIE ['ik_pwd'] != '') {
		
		$loginUserNum = $new [$app]->findCount ( 'user', array ('email' => $_COOKIE ['ik_email'], 'pwd' => $_COOKIE ['ik_pwd'] ) );
		
		if ($loginUserNum > 0) {
			
			$loginUserData = $new [$app]->find ( 'user_info', array ('email' => $_COOKIE ['ik_email'] ), 'userid,username,areaid,path,face,count_score,isadmin,uptime' );
			
			//用户session信息
			$_SESSION ['ikuser'] = $loginUserData;
			$IK_USER = array ('user' => $_SESSION ['ikuser'] );
			
			//更新登录时间
			$new [$app]->update ( 'user_info', array ('uptime' => time () ), array ('userid' => $loginUserData ['userid'] ) );
		
		}
	}

	//开始执行APP action
	include $app . '/action/' . $a . '.php';

} else {
	//header("Location: http://www.12ik.com/home/404/");
	echo '您访问的Action页面不存在！';
	exit ();
}