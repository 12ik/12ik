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
		
	case "add_do":

		$arrdata = array(
			'name'=>trim($_POST['name']),
			'nameid' =>trim($_POST['nameid']),
			'url' => trim($_POST['url'])
		);
		
		aac('article')->create('article_channels', $arrdata);
		
		header("Location: ".SITE_URL.tsUrl('article','admin',array('mg'=>'channel','ts'=>'list')));
		
		break;
		
	
}