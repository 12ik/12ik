<?php
defined('IN_IK') or die('Access Denied.');
switch ($ts) {
	
	case "" :
		$robotid = $_GET ['robotid'];
		$res = aac ( 'robots' )->find ( 'robots', array ('robotid' => $robotid ) );
		if (! empty ( $res )) {		
			aac ( 'robots' )->delete ( 'robots', array ('robotid' => $robotid ) );
			$cachefile = IKDATA . '/robot/robot_' . $_GET ['robotid'] . '.cache.php';
			if (file_exists ( $cachefile )) {
				@unlink ( $cachefile );
			}
			qiMsg ( "成功删除机器人" );
		}
		break;

}
