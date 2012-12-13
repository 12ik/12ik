<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
//用户是否登录
$userid = aac('user')->isLogin();

//个人小站
switch ($ts) {
	case "savetheme" :
		//保存theme
		$siteid = intval($_GET['siteid']);
		$status = 1;// 1 失败 0 成功
				
		$arrData = array(
			'siteid' => $siteid,
			'userid' => $userid,
			'theme_id' => intval($_POST['theme_id']),
			'background_ver' => $_POST['background_ver'],
			'background_pos' => $_POST['background_pos'],
			'background_repeat' => $_POST['background_repeat'],
			'background_cancel' => $_POST['background_cancel'],
			'background_color' => $_POST['background_color'],
			'banner_color' => $_POST['banner_color'],
			'tab_color' => $_POST['tab_color'],
			'tab_link_color' => $_POST['tab_link_color'],
			'link_color' => $_POST['link_color'],
			'background_image' => $_POST['background_image'],//图片url
			'background_path' => $_POST['background_path'],//图片路径
			
			//biz-theme
			'biz_theme' => $_POST['biz_theme'],
			'bg_fixed' => $_POST['bg_fixed'],
			'logo_color' => $_POST['logo_color'],
			'banner_transparent' => $_POST['banner_transparent'],
			'addtime'		=> time(),
		);

		
		$isTheme = aac('site') -> find('site_theme',array('siteid'=>$siteid));	
		//判断小站风格是否存在
		if($isTheme)
		{
			aac('site') -> update('site_theme',array('siteid'=>$siteid), $arrData);
			
		}else
		{
			$id = $db->insertArr($arrData,dbprefix.'site_theme');
			//更新site
			aac('site') -> update('site',array('siteid'=>$siteid), array('istheme'=>'1'));
		}
		
		$status = 0;
			
		header("Content-Type: application/json", true);
		if($status == 0){
			echo json_encode(array('r'=>0));
		}else{
			echo json_encode(array('r'=>1)); 
		}
		
		break;
		
	case "background":
		//ajax用户设置背景
		$siteid = intval($_GET['siteid']);
		$ver	= intval($_POST['ver'])+1;
		$status = 1;

	
		$ck = $_POST['ck'] == $_COOKIE['ck'] ? true : false;
		//上传
		$size = floor($_FILES['picfile']['size'] / 1024);
		if($size > 800)
		{
			header("Content-Type: application/json", true);
			echo json_encode(array('r'=> 1 , 'error' => '文件大小不得超过800k' )); 
		}else
		{
			$arrUpload = tsUpload($_FILES['picfile'],$userid,'site/custom/theme/'.$ver.'/',array('jpg','gif','png','jpeg'));
			if($arrUpload) $status = 0;//成功上传
			
			if($status ==0)
			{ 

				$imgsize = getimagesize(SITE_URL.'uploadfile/site/custom/theme/'.$ver.'/'.$arrUpload['url']);
				
				header("Content-Type: application/json", true);
				echo json_encode(array(
					'r' => 0,
					'ver' => $ver,
					'path' => $arrUpload['path'],
					'url' => $arrUpload['url'],
					'pic' => SITE_URL.'uploadfile/site/custom/theme/'.$ver.'/'.$arrUpload['url'].'?ver='.$ver,
					//'pic' => tsXimg($arrUpload['url'],'site/custom/theme',$imgsize[0],$imgsize[1],$arrUpload['path'],1)
				));
			}else{
				header("Content-Type: application/json", true);
				echo json_encode(array('r'=> 1 , 'error' => '上传失败请重新上传文件！' )); 
			}
		}
		
		break;
	
}