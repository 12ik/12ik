<?php
defined('IN_IK') or die('Access Denied.');

$userid = aac('user')->isLogin();
$strUser = aac('user')->isUser($userid);

switch($ik){

	//普通上传
	case "image":
		$type = trim($_GET['type']);
		$typeid = intval($_GET['typeid']);		
		//包含模版
		include template("ikupload/upload");
		
		break;
	//普通上传
	case "addimage":
	
		$typeid  = $_POST['typeid'];
		$type	 = $_POST['type'];
		
		$photonum = aac('photo')->findCount('photos',array('typeid'=>$typeid, 'type'=>$type));
		$arrUpload = ikUpload($_FILES['file'],$photonum+1,$type.'/'.$typeid,array('jpg','gif','png','jpeg'));
				
		if($arrUpload)
		{
			//插入数据库
			$arrData = array(
				'seqid'	    => $photonum+1,
				'userid'	=> $userid,
				'type'	=> $type,
				'typeid'	=> $typeid,				
				'photoname'	=> $arrUpload['name'],
				'phototype' => $arrUpload['type'],
				'photosize' => $arrUpload['size'],
				'path' => $typeid.'/'.$arrUpload['path'],
				'photourl' => $typeid.'/'.$arrUpload['url'],				
				'addtime'	=> time(),
			);
			
			$photoid = aac('photo')->create('photos', $arrData);	
			
			//浏览该topic_id seqid下的照片
			$arrPhoto = aac('photo')->getPhotoByseq($type,$typeid,$photonum+1);	
		
			$arrJson = array('photo_500'=> $arrPhoto['photo_500']);
										
			echo json_encode($arrJson); 		
		
		}else{
			$arrJson = array('r'=>1, 'html'=>'上传图片失败，请重新上传吧！');
			echo json_encode($arrJson); 
		}
		
		break;		
			
}