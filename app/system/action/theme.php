<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 主题设置
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */
switch ($ts) {
	case "" :
		$arrTheme = tsScanDir ( 'theme' );
		$title = '系统主题';
		include template ( "theme" );
		break;
	
	case "do" :
		
		$site_theme = $_POST ['site_theme'];
		
		$db->query ( "update " . dbprefix . "system_options set `optionvalue`='$site_theme' where optionname='site_theme'" );
		
		$arrOptions = $db->fetch_all_assoc ( "select optionname,optionvalue from " . dbprefix . "system_options" );
		foreach ( $arrOptions as $item ) {
			$arrOption [$item ['optionname']] = $item ['optionvalue'];
		}
		
		fileWrite ( 'system_options.php', 'data', $arrOption );
		
		qiMsg ( "系统主题更换成功！" );
		
		break;
}