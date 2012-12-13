<?php
defined('IN_IK') or die('Access Denied.');

switch($ts){
	
	case "list":
		
		//列表 
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=site&ac=admin&mg=site&ts=list&page=';
		$lstart = 0;//$page*10-10;

		//获取全部
		//$arrSite = $db->fetch_all_assoc("select * from ".dbprefix."site order by addtime desc limit $lstart,10");
		$arrSite = $db->fetch_all_assoc("select * from ".dbprefix."site order by addtime desc ");

		$siteNum = $db->once_num_rows("select * from ".dbprefix."site");
		
		include template("admin/site_list");
		
		break;
		
	case "isaudit":
		$siteid = $_GET['siteid'];
		$new['site']->update('site',array(
			'siteid'=>$siteid,
		),array(
			'isaudit'	=> $_GET['isaudit']==0 ? 1 : 0,
		));
		
		header("Location: ".SITE_URL."index.php?app=site&ac=admin&mg=site&ts=list");
		break;
	
}