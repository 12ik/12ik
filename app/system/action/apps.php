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
		
		$title = 'APP管理';
		
		include template ( "apps" );
		break;
	
	//安装APP
	/*
	case "install":
		$appname = trim($_GET['appname']);
		
		$appAbout = require_once 'app/'.$appname.'/about.php';
		
		$isinstall = $appAbout['isinstall'];
		$issql = $appAbout['issql'];
		$issystem = $appAbout['issystem'];
		
		
		if($isinstall == '0'){
			if($issql == '1'){
				//安装数据库
				$sql = file_get_contents('app/'.$appname.'/sql/install.sql');
				$sql = str_replace('ik_',dbprefix,$sql);
				$array_sql = preg_split("/;[\r\n]/", $sql);
				
				foreach($array_sql as $sql){
					$sql = trim($sql);
					if ($sql){
						if (strstr($sql, 'CREATE TABLE')){
							preg_match('/CREATE TABLE ([^ ]*)/', $sql, $matches);
							$ret = $db->query($sql);
						} else {
							$ret = $db->query($sql);
						}
					}
				}

			}
			//更新about.php文件
			$appAbout['isinstall'] = '1';
			AppFileWrite($appAbout,$appname,'about.php');
			
			echo '1';
		
		}elseif($isinstall == '1'){
		
			if($issql == '1'){
				//卸载数据库
				$sql = file_get_contents('app/'.$appname.'/sql/uninstall.sql');
				$sql = str_replace('ik_',dbprefix,$sql);
				$array_sql = preg_split("/;[\r\n]/", $sql);
				
				foreach($array_sql as $sql){
					$sql = trim($sql);
					if ($sql){
						$ret = $db->query($sql);
					}
				}
			}
		
			$appAbout['isinstall'] = '0';
			AppFileWrite($appAbout,$appname,'about.php');
			
			echo '2';
			
		}else{
			echo '3';
		}
		
		break;
	*/
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