<?php 
defined('IN_IK') or die('Access Denied.');
switch($ts){
	case "login":
	
		$jump = $_SERVER['HTTP_REFERER'];

		
		include template("ajax_login");

		
		break;
}