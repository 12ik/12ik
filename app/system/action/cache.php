<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik 爱客社区门户 缓存管理
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */
switch ($ik) {
	case "" :
		$title = '缓存管理';
		include template ( 'cache' );
		break;
	
	case "delall" :
		//清除全站缓存
		
		ClearAppCache('group');
		ClearAppCache('user');
		ClearAppCache('template');
			
		qiMsg("全站缓存更新成功！","点击返回",$_SERVER['HTTP_REFERER']);
		
	
		
		break;
		
	case "deltpl" :
		
		break;
		
}