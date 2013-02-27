<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 系统信息 @copyright (c) 2012-3000 12IK All Rights Reserved @author
 * wanglijun @Email:160780470@qq.com
 */

$os = explode ( " ", php_uname () );
if (! function_exists ( "gd_info" )) {
	$gd = '不支持,无法处理图像';
}
if (function_exists ( gd_info )) {
	$gd = @gd_info ();
	$gd = $gd ["GD Version"];
	$gd ? '&nbsp; 版本：' . $gd : '';
}

$IK_SOFT ['system'] = array (
		'server' => $_SERVER ['SERVER_SOFTWARE'],
		'phpos' => PHP_OS,
		'phpversion' => PHP_VERSION,
		'mysql' => $db->getMysqlVersion (),
		'os' => $os [0] . '' . $os [1] . ' ' . $os [3],
		'gd' => $gd,
		'upload' => '表单允许' . ini_get ( 'post_max_size' ) . ',上传总大小' . ini_get ( 'upload_max_filesize' ) 
);

//安全
if (is_dir(IKINSTALL)) {
	$message = "您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。";
}
include template ( "main" );