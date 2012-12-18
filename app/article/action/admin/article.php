<?php
defined('IN_IK') or die('Access Denied.');

switch($ts){
	
	case "list":
		
		//列表 
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=note&ac=admin&mg=note&ts=list&page=';
		$lstart = $page*10-10;

		//获取全部日志
		$arrList = $db->fetch_all_assoc("select * from ".dbprefix."article_spaceitems ");

//		$Num = $db->once_num_rows("select * from ".dbprefix."article_spaceitems");
		
		include template("admin/article_list");
		
		break;
	
}