<?php
defined('IN_IK') or die('Access Denied.');
class feed extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//添加feed
	public function add($userid,$template,$data){
	
		$userid = intval($userid);
		/*
		if(is_array($arrDatas)){
		
			foreach($arrDatas as $key=>$item){
				$arrData[$key] = urlencode($item);
			}
		
			$arrData = json_encode($arrData);
	
				$this->create('feed',array(
					'userid'=>$userid,
					'template'=>$template,
					'data'=>$arrData,
					'addtime'=>time(),
				));
		}*/
		if(is_array($data)){
			
			$data = serialize($data);
			
			$data = addslashes($data);

			$this->create('feed',array(
				'userid'=>$userid,
				'template'=>$template,
				'data'=>$data,
				'addtime'=>time(),
			));

		}
	}
	
	
	//析构函数
	public function __destruct(){
		
	}
	
}