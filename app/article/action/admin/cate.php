<?php
defined('IN_IK') or die('Access Denied.');

switch($ik){
	
	case "list":
		$nameid = $_GET['nameid'];
		//列表 
		//$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		//$url = SITE_URL.'index.php?app=article&ac=admin&mg=cate&ik=list&page=';
		//$lstart = $page*10-10;

		$arrCate = $db->fetch_all_assoc("select * from ".dbprefix."article_categories where type='".$nameid."' order by catid desc");
		
		//$cateNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."article_categories");

		//$pageUrl = pagination($cateNum['count(*)'], 10, $page, $url);
		
		include template("admin/cate_list");
		
		break;
		
	case "add":
		$nameid = $_GET['nameid'];
	
		include template("admin/cate_add");
	
		break;
		
	case "add_do":
	
		$nameid = trim($_POST['nameid']);
		$name = trim($_POST['catename']);
		$catid = aac('article')->create('article_categories',array('name'=>$name, 'type'=>$nameid));
		aac('article')->update('article_categories', array('catid'=>$catid),array('blockmodel'=>1, 'subcatid'=>$catid));
		
		qiMsg("添加成功",'返回到列表',SITE_URL.'index.php?app=article&ac=admin&mg=cate&ik=list&nameid='.$nameid);
		
	
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
		
		qiMsg("添加成功",'返回到列表',SITE_URL.'index.php?app=article&ac=admin&mg=cate&ik=list&nameid='.$type);
		
		break;
	
}