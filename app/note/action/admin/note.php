<?php
defined('IN_IK') or die('Access Denied.');

switch($ik){
	
	case "list":
		
		//列表 
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=note&ac=admin&mg=note&ik=list&page=';
		$lstart = $page*10-10;

		//获取全部日志
		$arrNote = $db->fetch_all_assoc("select * from ".dbprefix."note order by addtime desc limit $lstart,10");

		$noteNum = $db->once_num_rows("select * from ".dbprefix."note");

		
		include template("admin/note_list");
		
		break;
	
}