<?php 
defined('IN_IK') or die('Access Denied.');

switch($ik){
	
	case "":
	
		$title = '更换主题';

		$arrTheme	= ikScanDir('theme');

		include template("theme");
		
		break;
	
	//执行
	case "do":
		$theme = $_POST['site_theme'];
		setcookie("ik_theme", $theme, time()+3600*30,'/');   
		
		qiMsg("主题更换成功！");
		break;
}