<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 系统设置 @copyright (c) 2012-3000 12IK All Rights Reserved @author
 * wanglijun @Email:160780470@qq.com
 */
switch ($ik) {
	case "options" :
		
		$arrData = array (
				'site_title' => trim ( $_POST ['site_title'] ),
				'site_subtitle' => trim ( $_POST ['site_subtitle'] ),
				'site_key' => trim ( $_POST ['site_key'] ),
				'site_desc' => trim ( $_POST ['site_desc'] ),
				'site_url' => trim ( $_POST ['site_url'] ),
				'site_email' => trim ( $_POST ['site_email'] ),
				'site_icp' => trim ( $_POST ['site_icp'] ),
				'isface' => intval ( $_POST ['isface'] ),
				'isinvite' => intval ( $_POST ['isinvite'] ),
				'isgzip' => intval ( $_POST ['isgzip'] ),
				'thumbwidth' => $_POST ['thumbwidth'],
				'thumbheight' => $_POST ['thumbheight'],
				'charset' => $_POST ['charset'],
				'attachmentdir' => $_POST ['attachmentdir'],
				'attachmentdirtype' => $_POST ['attachmentdirtype'],
				
		);
		
		foreach ( $arrData as $key => $val ) {
			
			$new ['system']->update ( 'system_options', array (
					'optionname' => $key 
			), array (
					'optionvalue' => $val 
			) );
		
		}
		
		$arrOptions = $new ['system']->findAll ( 'system_options', null, null, 'optionname,optionvalue' );
		foreach ( $arrOptions as $item ) {
			$arrOption [$item ['optionname']] = $item ['optionvalue'];
		}
		
		fileWrite ( 'system_options.php', 'data', $arrOption );
		
		qiMsg ( "系统选项更新成功，并重置了缓存文件^_^" );
		
		break;
}