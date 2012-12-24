<?php
defined('IN_IK') or die('Access Denied.');

switch($ts){
	
	case "list":
		
		//列表 
		$arrList = aac('article')->findAll('article_channels');
		include template("admin/channel_list");
		break;
		
	case "add":

	
		include template("admin/channel_add");
	
		break;
		
	case "edit":
		$nameid = $_GET['nameid'];
		
		$arrChannel = aac('article')->find('article_channels',array('nameid'=>$nameid));
		
		include template("admin/channel_edit");
	
		break;		
		
	case "add_do":

		$_POST['category'] = trim($_POST['category']);
		$nameid = trim(strtolower($_POST['nameid']));
	
		if(empty($nameid) || !preg_match('/^[a-zA-Z]+$/', $nameid)) { 
			qiMsg('指定的频道英文ID包含非英文字母，请返回检查');
		}
		//添加
		$arrdata = array(
				'name' => $_POST['name'],
				'nameid' => $_POST['nameid'],
				'url' => $_POST['url'],
		);
		aac('article')->create('article_channels', $arrdata);
		
		//分类开始
		$datas = array();
		if(empty($_POST['category'])) {
			$datas = array(
					"'默认分类', '$nameid'"
			);
		} else {
			$_POST['category'] = explode("\n", $_POST['category']);
			foreach($_POST['category'] as $value) {
				$value = saddslashes(shtmlspecialchars(trim($value)));
				if($value) {
					$datas[] = "'$value', '$nameid'";
				}
			}
		}
		if(!empty($datas)) {
			
			$_SGLOBAL['db']->query("INSERT INTO ".tname('article_categories')." (`name`, `type`) VALUES (".implode('),(', $datas).")");
			$_SGLOBAL['db']->query("UPDATE ".tname('article_categories')." SET subcatid=catid");
		}
		
		qiMsg("添加成功",'返回到频道列表',SITE_URL.'index.php?app=article&ac=admin&mg=channel&ts=list');
		
		break;
		
	
}