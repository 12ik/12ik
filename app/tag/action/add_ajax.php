<?php 
defined('IN_IK') or die('Access Denied.');
switch($ik){
	case "":
		
		$objname = $_GET['objname'];
		$idname = $_GET['idname'];
		$objid = $_GET['objid'];
		
		include template("add_ajax");
		break;
		
	case "do":
	
		$objname = $_POST['objname'];
		$idname = $_POST['idname'];
		$objid = $_POST['objid'];
		$tags = trim($_POST['tags']);
		
		$new['tag']->addTag($objname,$idname,$objid,$tags);
		
		echo "<script language=JavaScript>parent.window.location.reload();</script>";
	
		break;
}