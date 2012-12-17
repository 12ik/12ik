<?php
//采集uid缓存
function updaterobot($id) {
	global $db;

	$tarr = $results = $userarr = array();

	$results = aac('robots')->find('robots',array('robotid'=>$id),'uidrule');
	if(!empty($results)) {
		$results['uidrule'] = explode('|', $results['uidrule']);
		if(!empty($results['uidrule'])) {
			foreach($results['uidrule'] as $tmpkey => $tmpvalue) {
				if(empty($tmpvalue)) {
					unset($results['uidrule'][$tmpkey]);
				}
			}
		}
		$results['uidrule'] = saddslashes(shtmlspecialchars($results['uidrule']));
		$uids = simplode($results['uidrule']);
		$userquery = $db->once_fetch_assoc("select  userid, username from ".dbprefix."user_info where userid in ('.$uids.')");
		while ($userquery) {
			$userarr[$item['userid']] = $item['username'];
		}

		$tarr = array(
				'uids'	=>	$userarr
		);

		$cachefile = IKROOT.'./data/robot/robot_'.$id.'.cache.php';
		$text = '$cacheinfo = '.arrayeval($tarr).';';
		writefile($cachefile, $text, 'php');
		return $tarr;

	} else {
		return false;
	}
}