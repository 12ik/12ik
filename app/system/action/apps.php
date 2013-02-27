<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 APP管理
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

switch ($ik) {
	//app列表
	case "list" :
		$applists = ikScanDir ( 'app' );
		foreach ( $applists as $key => $item ) {
			if (is_file ( 'app/' . $item . '/about.php' )) {
				$arrApps [$key] ['name'] = $item;
				$arrApps [$key] ['about'] = require_once 'app/' . $item . '/about.php';
			}
		}
		
		foreach ( $arrApps as $item ) {
			$arrApp [] = $item;
		}
		
		$title = '应用列表';
		
		include template ( "apps" );
		break;
	
	//导航 
	case "appnav" :
		$appkey = $_POST ['appkey'];
		$appname = $_POST ['appname'];
		
		$arrNav = include 'data/system_appnav.php';
		
		if (is_array ( $arrNav )) {
			$arrNav [$appkey] = $appname;
		} else {
			$arrNav = array ($appkey => $appname );
		}
		
		fileWrite ( 'system_appnav.php', 'data', $arrNav );
		
		echo '1';
		
		break;
	
	//取消导航 
	case "unappnav" :
		
		$appkey = $_POST ['appkey'];
		
		$arrNav = include 'data/system_appnav.php';
		
		unset ( $arrNav [$appkey] );
		
		fileWrite ( 'system_appnav.php', 'data', $arrNav );
		
		echo '1';
		
		break;

}