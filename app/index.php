<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12IK爱客网 APP单入口
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//判断升级
if (is_file ( 'data/up.php' ))
	$app = 'upgrade';

if ($app == 'upgrade' && ! is_file ( 'data/up.php' ))
	$app = 'group';

//APP模板CSS,IMG,INC
$IK_APP ['tpl'] = array ('skin' => 'app/' . $app . '/skins/', 'js' => 'app/' . $app . '/js/' );

//system系统管理模板CSS,IMG
$IK_APP ['system'] = array ('skin' => 'app/system/skins/', 'js' => 'app/system/js/' );

//加载APP应用首页和配置文件
if (is_file ( 'app/' . $app . '/action/' . $ac . '.php' )) {
	
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
	$IK_theme = isset ( $_COOKIE ['ik_theme'] ) ? $_COOKIE ['ik_theme'] : '';
	if ($IK_theme) {
		if (is_file ( 'theme/' . $IK_theme . '/preview.gif' )) {
			$site_theme = $IK_theme;
		} else {
			$site_theme = $IK_SITE ['base'] ['site_theme'];
		}
	} else {
		$site_theme = $IK_SITE ['base'] ['site_theme'];
	}
	
	//加载APP配置缓存文件
	if ($app != 'system') {
		
		$IK_APP ['options'] = fileRead ( 'data/' . $app . '_options.php' );
				
		if ($IK_APP ['options'] ['isenable'] == '1' && $ac != 'admin') {
			qiMsg ( $app . "应用关闭，请开启后访问！" );
		}
	
	}
	
	//加载APP数据库操作类并建立对象
	include_once 'app/'.$app.'/config.php';
	include_once 'app/'.$app.'/class.'.$app.'.php';
	$new[$app] = new $app($db);
	
	
	//控制前台ADMIN访问权限
	if ($ac == 'admin' && $IK_USER ['admin'] ['isadmin'] != 1 && $app != 'system') {
		header ( "Location: " . SITE_URL );
		exit ();
	}
	
	//控制后台访问权限
	if ($IK_USER ['admin'] ['isadmin'] != 1 && $app == 'system' && $ac != 'login') {
		header ( "Location: " . SITE_URL . tsUrl ( 'system', 'login' ) );
		exit ();
	}
	
	//控制插件设置权限
	if ($IK_USER ['admin'] ['isadmin'] != 1 && $in == 'edit') {
		header ( "Location: " . SITE_URL . tsUrl ( 'system', 'login' ) );
		exit ();
	}
	
	//判断用户是否上传头像
	if ($IK_SITE ['base'] ['isface'] == 1 && $IK_USER ['user'] != '' && $app != 'system' && $ac != 'admin') {
		
		$faceUser = $new [$app]->find ( 'user_info', array ('userid' => intval ( $IK_USER ['user'] ['userid'] ) ) );
		
		if ($faceUser ['face'] == '' && $ts != 'face') {
			header ( "Location: " . SITE_URL . tsUrl ( 'user', 'set', array ('ts' => 'face' ) ) );
		}
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
			$_SESSION ['tsuser'] = $loginUserData;
			$IK_USER = array ('user' => $_SESSION ['tsuser'] );
			
			//更新登录时间
			$new [$app]->update ( 'user_info', array ('uptime' => time () ), array ('userid' => $loginUserData ['userid'] ) );
		
		}
	}
	
	$tsHooks = array ();
	
	if ($app != 'system' && $app != 'pubs') {
		
		//加载公用插件 
		if (is_file ( 'data/pubs_plugins.php' )) {
			$public_plugins = fileRead ( 'data/pubs_plugins.php' );
			
			if ($public_plugins && is_array ( $public_plugins )) {
				foreach ( $public_plugins as $item ) {
					if (is_file ( 'plugins/pubs/' . $item . '/' . $item . '.php' )) {
						include 'plugins/pubs/' . $item . '/' . $item . '.php';
					}
				}
			}
		}
		
		//加载APP插件
		if (is_file ( 'data/' . $app . '_plugins.php' )) {
			$active_plugins = fileRead ( 'data/' . $app . '_plugins.php' );
			if ($active_plugins && is_array ( $active_plugins )) {
				foreach ( $active_plugins as $item ) {
					if (is_file ( 'plugins/' . $app . '/' . $item . '/' . $item . '.php' )) {
						include 'plugins/' . $app . '/' . $item . '/' . $item . '.php';
					}
				}
			}
		}
	}
	
	//开始执行APP action
	include $app . '/action/' . $ac . '.php';

} else {
	header("Location: http://www.12ik.com/home/404/");
	exit ();
}