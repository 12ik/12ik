<?php
/*
 * 爱客网单入口
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//定义网站根目录,APP目录,DATA目录，核心目录
define ( 'IN_IK', true );

define ( 'IKROOT', dirname ( __FILE__ ) );
define ( 'IKAPP', IKROOT . '/app' );
define ( 'IKDATA', IKROOT . '/data' );
define ( 'IKCORE', IKROOT . '/core' );
define ( 'IKINSTALL', IKROOT . '/install' );
define ( 'IKPLUGIN', IKROOT . '/plugins' );

//装载12IK核心


include 'core/core.php';

//除去加载内核运行时间统计开始


$time_start = getmicrotime ();

if (is_file ( 'data/config.inc.php' )) {
	//装载APP应用
	include 'app/index.php';
} else {
	//装载安装程序
	include 'install/index.php';
}

unset ( $GLOBALS );