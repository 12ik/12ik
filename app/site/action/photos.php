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
		//判断权限
		aac('site')->isAllow($strPhotos['userid'],$userid,'complete');

		$arrPhotos = aac('site')->findAll('site_photos_pic',"photosid='$photosid' and  userid='$userid' and addtime>'$addtime'");

		$title = '完成上传！添加描述 - '.$strPhotos['title'];
		include template('photos_complete');
		break;	

	case "addinfo" :
	
		header("Location: ".SITE_URL.tsUrl('site','photos',array('ts'=>'list','photosid'=>$photosid)));
		break;	
		
	case "list" :
		$photosList = aac('site')->findAll('site_photos_pic',array('photosid'=>$photosid),'addtime desc');
		$title = $strPhotos['title'];
		include template('photos_list');
		break;	
		
	case "photo" :
		$photoid = intval($_GET['pid']);//照片id
		if($photoid == 0){
			header("Location: ".SITE_URL.tsUrl('site','photos',array('ts'=>'list','photosid'=>$photosid)));
			exit;
		}
		$photoNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."site_photos_pic where `photoid`='$photoid'");
		if($photoNum['count(*)']==0){
			header("Location: ".SITE_URL.tsUrl('site','photos',array('ts'=>'list','photosid'=>$photosid)));
			exit;
		}	
		$strPhoto = aac('site')->find('site_photos_pic',array('photoid'=>$photoid));
		
		$arrPhotoIds = $db->fetch_all_assoc("select photoid from ".dbprefix."site_photos_pic where photosid='$photosid' order by photoid desc");
		foreach($arrPhotoIds as $item){
			$arrPhotoId[] = $item['photoid'];
		}
		//逆向排序
		rsort($arrPhotoId);	
		$nowkey = array_search($photoid,$arrPhotoId);
		$nowPage =  $nowkey+1 ;
		$conutPage = count($arrPhotoId);
		$prev = $arrPhotoId[$nowkey - 1];
		$next = $arrPhotoId[$nowkey +1];			
		
		//更新浏览量		
		aac('site')->update('site_photos_pic',array('photoid'=>$photoid),array('count_view'=>'count_view + 1'));

		$title = $strPhotos['title'].'-第'.$nowPage.'张';
		include template('photos_photo');
		break;								
	
	
}