<?php 

switch($ts){
	
	case "":
		$robotid = $_GET['robotid'];
		$thevalue = $arrRobot = aac('robots')->find('robots',array('robotid'=>$robotid));
		
		if($thevalue)
		{
			
			$thevalue['listurl_manual'] = $thevalue['listurl_auto'] = '';
			if($thevalue['listurltype'] == 'auto') {
				$thevalue['listurl_auto'] = $thevalue['listurl'];
			} elseif($thevalue['listurltype'] == 'manual') {
				$thevalue['listurl_manual'] = explode("\n", preg_replace("/\n+/", "\n", preg_replace("/(\r\n|\r|\n)/s", "\n", $thevalue['listurl'])));
			} elseif($thevalue['listurltype'] == 'extraction') {
				$thevalue['listurl_manual'] = unserialize($thevalue['listurl']);
			} elseif($thevalue['listurltype'] == 'new') {
				$thevalue['listurl'] = unserialize($thevalue['listurl']);
				$thevalue['listurl_manual'] = $thevalue['listurl']['manual'];
				$thevalue['listurl_auto'] = $thevalue['listurl']['auto'];
			}
			$thevalue['listurl'] = '';
			$thevalue['defaultdateline'] = sgmdate($thevalue['defaultdateline']);
			if(!empty($thevalue['listurl_manual'])) {
				foreach($thevalue['listurl_manual'] as $tmpkey => $tmpvalue) {
					$tmpvalue = trim($tmpvalue);
					if(!empty($tmpvalue))
					{
						
					}
				}
			}
			$thevalue['listurl_manual'] = $thevalue['listurl'];
			$thevalue['subjectreplace'] = explode("\n", $thevalue['subjectreplace']);
			$thevalue['subjectreplaceto'] = explode("\n", $thevalue['subjectreplaceto']);
			$thevalue['messagereplace'] = explode("\n", $thevalue['messagereplace']);
			$thevalue['messagereplaceto'] = explode("\n", $thevalue['messagereplaceto']);
			if ($_GET['op'] == 'copy') {	//复制采集器的初始值
				$thevalue['robotid'] = 0;
			}

	
		}else{
			qiMsg("配置不存在");
		}
		include template('admin/add');
		break;
	
}

function sgmdate($timestamp, $dateformat='', $format=0) {
	global $_SCONFIG, $_SGLOBAL, $lang;

	if(empty($dateformat)) {
		$dateformat = 'Y-m-d H:i:s';
	}
	
	if(empty($timestamp)) {
		$timestamp = $_SGLOBAL['timestamp'];
	}
	
	$result = '';
	if($format) {
		$time = $_SGLOBAL['timestamp'] - $timestamp;
		if($time > 24*3600) {
			$result = gmdate($dateformat, $timestamp + $_SCONFIG['timeoffset'] * 3600);
		} elseif ($time > 3600) {
			$result = intval($time/3600).$lang['hour'].$lang['before'];
		} elseif ($time > 60) {
			$result = intval($time/60).$lang['minute'].$lang['before'];
		} elseif ($time > 0) {
			$result = $time.$lang['second'].$lang['before'];
		} else {
			$result = $lang['now'];
		}
	} else {
		$result = gmdate($dateformat, $timestamp + $_SCONFIG['timeoffset'] * 3600);
	}
	return $result;
}