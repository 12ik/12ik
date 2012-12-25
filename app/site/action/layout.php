<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//$userid = $IK_USER['user']['userid'];
//$siteid = intval($_GET['siteid']);
$roomid = intval($_GET['roomid']);

//$strSite = aac('site')->getOneSite($siteid);

//页面
switch ($ik) {
	case "update" :
		$arrdata = array();
		$arrdata['leftmod'] = $_POST['mods'];
		$arrdata['rightmod'] = $_POST['r_mods'];

		if(empty($arrdata['leftmod']) && empty($arrdata['leftmod']))
		{
			$arrJson = array('r'=>1, 'html'=>'update layout error');
			
		}else{
			
			aac('site')->update('site_room_widget',array('roomid'=>$roomid),$arrdata);
			$arrJson = array('r'=>0, 'html'=>'update layout success');
		}
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 	
		break;

}