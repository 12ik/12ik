<?php
defined('IN_IK') or die('Access Denied.');

switch($ts){
	
	case "list":
		$nameid = $_GET['nameid'];
		//列表 
		//$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		//$url = SITE_URL.'index.php?app=article&ac=admin&mg=cate&ts=list&page=';
		//$lstart = $page*10-10;

		$arrCate = $db->fetch_all_assoc("select * from ".dbprefix."article_categories where type='".$nameid."' order by catid desc");
		
		//$cateNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."article_categories");

		//$pageUrl = pagination($cateNum['count(*)'], 10, $page, $url);
		
		include template("admin/cate_list");
		
		break;
		
	case "add":
	
		include template("admin/cate_add");
	
		break;
		
	case "add_do":
	
		$catename = trim($_POST['catename']);
		
		$db->query("insert into ".dbprefix."article_cate (`catename`) values ('$catename')");
		
		header("Location: ".SITE_URL.'index.php?app=article&ac=admin&mg=cate&ts=list');
	
		break;
		
	case "edit":
		$cateid = $_GET['cateid'];
		
		$strCate = aac('article')->find('article_categories',array('catid'=>$cateid));
		
		include template("admin/cate_edit");
		break;
		
	case "edit_do":
		
		$cateid = $_POST['cateid'];
		$name = trim($_POST['name']);
		$type = trim($_POST['type']);
		
		$db->query("update ".dbprefix."article_categories set `name`='$name' where `catid`='$cateid'");
		
		qiMsg("添加成功",'返回到列表',SITE_URL.'index.php?app=article&ac=admin&mg=cate&ts=list&nameid='.$type);
		
		break;
	
}