<?php
//插件条件入口

defined('IN_IK') or die('Access Denied.');

if(is_file('plugins/'.$app.'/'.$plugin.'/'.$in.'.php')){
	require_once('plugins/'.$app.'/'.$plugin.'/'.$in.'.php');
}else{
	ikNotice('sorry:no plugin!');
}

//形如这样
//index.php?app=group&a=plugin&plugin=qq&in=do