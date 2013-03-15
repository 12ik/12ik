<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 爱客网 网站核心文件 @copyright (c) 2012-3000 12IK All Rights Reserved @author
 * wanglijun @Email:160780470@qq.com
 */

if (substr ( PHP_VERSION, 0, 1 ) != '5')
	exit ( "网站运行环境要求PHP5！" );

error_reporting ( E_ALL & ~ E_NOTICE & ~ E_WARNING );

@set_magic_quotes_runtime ( 0 );
// set_magic_quotes_runtime(false);

session_start ();
// 定义全局配置
$_SGLOBAL = array ();

// 前台用户基本数据,$IK_USER数组
$IK_USER = array (
		'user' => isset ( $_SESSION ['ikuser'] ) ? $_SESSION ['ikuser'] : '',
		'admin' => isset ( $_SESSION ['ikadmin'] ) ? $_SESSION ['ikadmin'] : '' 
);

// 加载基础函数
require_once 'IKFunction.php';

// 开始处理url路由
reurl ();
// get post 处理过滤转义
noGPC();
// 系统Url参数变量
// APP专用
$app = isset ( $_GET ['app'] ) ? $_GET ['app'] : 'home';
// Action专用
$a = isset ( $_GET ['a'] ) ? $_GET ['a'] : 'index';
// 安装
$install = isset ( $_GET ['install'] ) ? $_GET ['install'] : 'index';
// IK专用
$ik = isset ( $_GET ['ik'] ) ? $_GET ['ik'] : '';
// Admin管理专用
$mg = isset ( $_GET ['mg'] ) ? $_GET ['mg'] : 'index';
// Api专用
$api = isset ( $_GET ['api'] ) ? $_GET ['api'] : 'index';
// plugin专用
$plugin = isset ( $_GET ['plugin'] ) ? $_GET ['plugin'] : '';
// plugin专用
$in = isset ( $_GET ['in'] ) ? $_GET ['in'] : '';

// 处理html编码
header ( 'Content-Type: text/html; charset=UTF-8' );

// 安装配置文件，数据库配置判断
if (! is_file ( 'data/config.inc.php' )) {
	require_once 'install/index.php';
	exit ();
}

// 数据库配置文件
require_once 'data/config.inc.php';
// 连接数据库
require_once 'sql/' . $IK_DB ['sql'] . '.php';
$db = new MySql ( $IK_DB );

// 加载APP数据库操作类并建立对象
require_once 'IKApp.php';
