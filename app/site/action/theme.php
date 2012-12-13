<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : $siteid; 
$strSite = aac('site')->getOneSite($siteid);
//判断是否有风格
$isTheme = aac('site') -> find('site_theme',array('siteid'=>$siteid));

if(is_array($isTheme))
{ 
	$strTheme = aac('site') -> getSiteThemeBySiteid ($siteid);
	$strTheme['ck'] = $_COOKIE['ck'];
	$strTheme['ver'] = empty($strTheme['background_ver']) ? 0 : $strTheme['background_ver'];
	$strTheme['background_pos'] = empty($strTheme['background_pos']) ? '0%' : $strTheme['background_pos'];
}
//显示系统房间
$strRooms = aac('site')->getRooms($siteid);
//显示排序导航
$strNavs = aac('site')->getNavOrders($siteid);
//显示系统组件
$strWidgets = aac('site')->getWidgets();



