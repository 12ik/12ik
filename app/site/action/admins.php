<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
//加载风格
include_once 'theme.php';

//用户是否登录
$userid = aac('user')->isLogin();
$siteid = intval($_GET['siteid']);
	
//个人小站
switch ($ts) {
	case "" :
		//管理中心
		$strSite = aac('site')->getOneSite($siteid);

		
		$title = "小站管理";
		include template("admins");
		break;

	case "remind" :
		//提醒



		
		$title = "小站管理";
		include template("admins");
		break;
	case "postpermission" :
		//权限
		$isaction = isset($_POST['isaction']) ? $_POST['isaction']: '';

		if($isaction!='')
		{
			$dd = aac('site')->update('site',array('siteid'=>$siteid),array(
			'isaction'	=> $isaction,
			));
			$message = '<div class="message">保存权限成功</div>';
		}
		$title = "小站管理";
		include template("postpermission");
		break;
	case "log" :
		//日志


		
		$title = "小站管理";
		include template("log");
		break;
	case "kedou" :
		//客豆

		
		$title = "小站管理";
		include template("kedou");
		break;
	case "info" :
		$tags = $_POST['tags'];
		//判断是否是保存
		if(!empty($tags))
		{

			$sitedesc = $_POST['sitedesc'];
			$state = aac('site')->update('site',array('siteid'=>$siteid),array(
				'sitedesc'	=> htmlspecialchars($sitedesc)
				));
			if($state)
			{
				//先删除该站的标签 然后插入数据
				aac('tag')->delObjTagByObjid('site','siteid',$siteid); 
				//添加标签
				aac('tag')->addTag('site','siteid',$siteid,trim($tags));			
				
				$arrJson = array('r'=>0, 'html'=>'你的最新设置已经被成功保存');
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 			
			
			}else{
				
				$arrJson = array('r'=>1, 'error'=>'更新失败请重试');
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 				
			}	
		}else{
			//资料
			$arrSiteTag = aac('tag')->getObjTagByObjid('site','siteid',$siteid); 
			foreach($arrSiteTag as $key => $item)
			{
				$arrSiteTags.= $item['tagname'].' ';
			}
			$siteNumber = aac('site')->findCount('site_room',array('siteid'=>$siteid));
					
			$title = "小站管理";
			include template("info");
		}	
		break;
	case "design" :
		//设计风格
		$title = "小站管理";
		include template("design");
		break;
	//设置导航菜单的布局顺序
	case "layout" :
		$arrJson = array();
		$navtext = trim($_POST['tabs']);
		$arrData = array('ordertext' => $navtext);
		 
		$isupdate = $db->updateArr($arrData,dbprefix.'site_room_navorder','where siteid='.$siteid);
		if($isupdate)
		{
			$arrJson['r'] = 0;
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 
		}	
		break;
	case "icon" :
		//设计风格
		if($_FILES['picfile'])
		{ 
			$wh = getimagesize($_FILES['picfile']['tmp_name']); //获取图片宽高
			if($wh[0]<100 || $wh[1]<100)
			{
				echo '{"r":1,"error":"图片短边尺寸不能小于100像素，请重新上传。"}';
			}else
			{
				//上传
				$arrUpload = tsUpload($_FILES['picfile'],$siteid,'site/icon',array('jpg','gif','png'));
				if($arrUpload)
				{
		
					aac('site')->update('site',array(
						'siteid'=>$siteid,
					),array(
						'iconpath'=>'icon/'.$arrUpload['path'],
						'siteicon'=>'icon/'.$arrUpload['url'],
					));
					
					//清除缓存图片
					ClearAppCache($app.'/icon/'.$arrUpload['path']);
					$pic = SITE_URL.tsXimg('icon/'.$arrUpload['url'],'site',180,220,'icon/'.$arrUpload['path'],0);
					echo '{"r":0,"pic":"'.$pic.'"}';
				}else{
					echo '{"r":1,"error":"上传失败！请重新上传。"}';
				}			
			}	
		}else if(!empty($_POST['imgpos'])){
			aac('site')->update('site',array(
				'siteid'=>$siteid,
			),array(
				'imgpos'=>$_POST['imgpos'],
			));
			//清除缓存图片
			ClearAppCache($app.'/icon/'.$strSite['iconpath']);
		}else{
			//获取位置
			if($strSite['imgpos'])
			{
				$arrimgpos = explode('_',$strSite['imgpos']);
				$strSite['px'] = $arrimgpos[0];
				$strSite['py'] = $arrimgpos[1];
				$strSite['pw'] = $arrimgpos[2];
			}
			$title = "添加或更改你的小站图标";
			include template("icon");
		}
		break;				
}