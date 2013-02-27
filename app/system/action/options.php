<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 系统设置
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

$arrOptions = $db->fetch_all_assoc ( "select optionname,optionvalue from " . dbprefix . "system_options" );

foreach ( $arrOptions as $item ) {
	$strOption [$item ['optionname']] = stripslashes ( $item ['optionvalue'] );
}

//时区和语言
$arrTime = fileRead ( 'data/system_timezone.php' );
$arrLang = fileRead ( 'data/system_lang.php' );

$title = '基本配置';

include template ( "options" );