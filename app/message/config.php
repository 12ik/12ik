<?php
defined('IN_IK') or die('Access Denied.');
	/*
	 *包含数据库配置文件
	 */
	require_once IKDATA."/config.inc.php";
	
	$skin = 'default';
	
	//APP配置
	$IK_APP['options']['appname']	= '消息中心';