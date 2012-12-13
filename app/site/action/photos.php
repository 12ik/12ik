<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
$photosid = intval($_GET['photosid']);
$strPhotos = aac('site')->find('site_photos',array('photosid'=>$photosid));;
$siteid = $strPhotos['siteid'];
$roomid = $strPhotos['roomid']; //导航
$userid = $_SESSION['tsuser']['userid'];
//加载风格
include_once 'theme.php';

//页面
switch ($ts) {
	case "" :
		//显示

		include template('forum_discuss_show');
		break;		
					
	case "upload" :
		//权限判断
		aac('site')->isAllow($strPhotos['userid'],$userid,'upload');	
		$addtime = time();

		$title = '上传照片 - '.$strPhotos['title'];
		include template('photos_upload');
		break;

	case "addphoto" :
		//权限判断
		$userid = intval($_POST['userid']);
		aac('site')->isAllow($strPhotos['userid'],$userid,'addphoto');
		$arrData = array(
			'userid'	=> $userid,
			'photosid'	=> $photosid,
			'addtime'	=> time(),
		);
		
		$photoid = aac('site')->create('site_photos_pic',$arrData);

		//上传
		$arrUpload = tsUpload($_FILES['Filedata'],$photoid,'site/photos',array('jpg','gif','png'));
		
		if($arrUpload){

			aac('site') -> update('site_photos_pic',array(
				'photoid'=>$photoid,
			),array(
				'photoname'=>$arrUpload['name'],
				'phototype'=>$arrUpload['type'],
				'path'=>'photos/'.$arrUpload['path'],
				'photourl'=>'photos/'.$arrUpload['url'],
				'photosize'=>$arrUpload['size'],				
			));
			
		}
		echo $photoid;		
				
		break;
		
	case "complete" :
		$userid = intval($IK_USER['user']['userid']);
		$addtime = intval($_GET['addtime']);
		echo $addtime;
		//判断权限
		aac('site')->isAllow($strPhotos['userid'],$userid,'complete');
		
		$arrPhotos = aac('site')->findAll('site_photos_pic',array('photosid'=>$photosid, 'userid'=> $userid, 'addtime'=>$addtime));

		$title = '完成上传！添加描述 - '.$strPhotos['title'];
		include template('photos_complete');
		break;				
	
	
}