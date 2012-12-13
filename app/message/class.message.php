<?php
defined('IN_IK') or die('Access Denied.');
 
class message extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//发送消息
	public function sendmsg($userid,$touserid,$title,$content){
	
		$userid = intval($userid);
		
		$touserid = intval($touserid);
		
		$content = addslashes(trim($content));
		
		if($touserid && $content){
		
			$messageid = $this->create('message',array(
				'userid'		=> $userid,
				'touserid'		=> $touserid,
				'title'			=> $title,
				'content'		=> $content,
				'addtime'		=> time(),
			));
			
		}
	}
	
}