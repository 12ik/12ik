<?php
defined('IN_IK') or die('Access Denied.');

switch($ik){
	
	case "list":
		
		//列表 
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=article&a=admin&mg=article&ik=list&page=';
		$lstart = $page*10-10;

		//获取全部日志
		$arrList = $db->fetch_all_assoc("select * from ".dbprefix."article_spaceitems order by itemid desc limit $lstart,10");

 		$Num = aac('article')->findCount('article_spaceitems');
		


		$pageUrl = pagination($Num, 10, $page, $url);		

		include template("admin/article_list");
		
		break;
	
}