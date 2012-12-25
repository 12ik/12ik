<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 插件设置
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */
switch ($ik) {
	//插件列表
	case "list" :
		
		$arrApps = ikScanDir ( 'plugins' );
		
		$apps = $_GET ['apps'];
		
		$arrPlugins = ikScanDir ( 'plugins/' . $apps );
		
		foreach ( $arrPlugins as $key => $item ) {
			if (is_file ( 'plugins/' . $apps . '/' . $item . '/about.php' )) {
				$arrPlugin [$key] ['name'] = $item;
				$arrPlugin [$key] ['about'] = require_once 'plugins/' . $apps . '/' . $item . '/about.php';
			}
		}
		
		$app_plugins = fileRead ( 'data/' . $apps . '_plugins.php' );
		
		include template ( "plugin_list" );
		break;
	
	//插件停启用
	case "do" :
		
		$apps = $_GET ['apps'];
		
		$isused = intval ( $_GET ['isused'] );
		$pname = $_GET ['pname'];
		
		$app_plugins = fileRead ( 'data/' . $apps . '_plugins.php' );
		
		//0停用1启用
		if ($isused == '0') {
			
			$pkey = array_search ( $pname, $app_plugins );
			unset ( $app_plugins [$pkey] );
			
			fileWrite ( $apps . '_plugins.php', 'data', $app_plugins );
			
			qiMsg ( "插件停用成功！" );
		
		} elseif ($isused == '1') {
			
			array_push ( $app_plugins, $pname );
			
			fileWrite ( $apps . '_plugins.php', 'data', $app_plugins );
			qiMsg ( "插件启用成功！" );
		
		}
		break;
	
	//删除插件
	case "del" :
		$pname = $_GET ['pname'];
		delDir ( 'plugins/pubs/' . $pname );
		qiMsg ( "插件删除成功！" );
		break;
	
	//插件编辑
	case "edit" :
		
		break;
}