<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$roomid = intval($_GET['roomid']);
$strRoom = aac('site')->getOneRoom($roomid);
$siteid = $strRoom['siteid'];
//加载风格
include_once 'theme.php';



$strArchives = aac('site')->findAll('site_archive',array('roomid'=>$roomid), 'addtime desc');

foreach($strArchives as $key=>$item){
		$arrArchives[] = array(
			'widgetname' => $item['widgetname'],
			'widgetid' => $item['widgetid'],
			'widget'=> aac('site')->find('site_'.$item['widgetname'], array($item['widgetname'].'id'=>$item['widgetid'])),
			'strwidget'=> aac('site')->getOneWidget(array('othername'=>$item['widgetname'])),
		);	
	}



$title = $strRoom['name'].'的更多应用';
include template('archives');