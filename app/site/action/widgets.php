<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$userid = $IK_USER['user']['userid'];
$siteid = intval($_GET['siteid']);
$roomid = intval($_GET['roomid']);

$strSite = aac('site')->getOneSite($siteid);

$htmlTemplate = '<div class="mod sort" id="{table}-{itemid}"><div class="hd"><h2><span>{title}</span><span class="pl"> ( {action} ) </span></h2><div class="edit"><a href="#" rel="{settingurl}" class="a_lnk_mod_setting">设置</a></div></div><div class="bd">{content}</div></div><script type="text/javascript">IK(\'common\',\'setting-eventhandler\');</script>';
	
$strRoom = aac('site')->getOneRoom($roomid);
//如果房间组件为6个 停止安装
if($strRoom['count_widget'] =='6')
{
	$arrJson = array('r'=>1, 'error'=>'只能安装6个应用模块');
	header("Content-Type: application/json", true);
	echo json_encode($arrJson);
	exit; 
}

$kind = $_POST['kind'];
//页面
switch ($kind) {
	case "bulletin" :
		//公告数据		
		$arrData = array(
				'userid'		=> $userid,
				'siteid'		=> $siteid,
				'roomid'		=> $roomid,
				'title'			=> $strSite['sitename'].'的公告栏',
				'addtime'		=> time(),
			);
			
		$bulletinid = $db->insertArr($arrData,dbprefix.'site_bulletin');
		//更新该房间组件数目
		$db->query("update ".dbprefix."site_room set count_widget = count_widget+1  where roomid='$roomid'");
		//更新该房间组件布局
		aac('site')->updateLayout($roomid,'bulletin-'.$bulletinid);
		
		$updateUrl = SITE_URL.tsUrl('site','bulletin',array('ts'=>'update','bulletinid'=>$bulletinid));
		$settingUrl = SITE_URL.tsUrl('site','bulletin',array('ts'=>'settings','bulletinid'=>$bulletinid));

		$html_data = array(
			'table'	    => 'bulletin',
			'itemid'	=> $bulletinid,
			'title'		=> $strSite['sitename'].'的公告栏',
			'action' => '<a href="'.$updateUrl.'">修改</a>',
			'settingurl'=> $settingUrl,
			'content'	=> '<div class="bulletin-content" ></div>',
				
		);
		//添加模版到库里
		//aac('site')->addHtml($userid,$roomid,$htmlTemplate,$html_data);
		//解析
		foreach($html_data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			$tmpdata[$tmpkey] = $itemTmp;
		}			
		$arrJson = array('r'=>0, 'html'=>strtr($htmlTemplate,$tmpdata));
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 
		break;
		
	case "notes" :
		//日记数据		
		$arrData = array(
				'userid'		=> $userid,
				'siteid'		=> $siteid,
				'roomid'		=> $roomid,
				'title'			=> $strSite['sitename'].'的日记',
				'display_number'		=> 5,				
				'addtime'		=> time(),
			);
		// $notesid = 222;	
		$notesid = $db->insertArr($arrData,dbprefix.'site_notes');
		//更新该房间组件数目
		$db->query("update ".dbprefix."site_room set count_widget = count_widget+1  where roomid='$roomid'");
		//更新该房间组件布局
		aac('site')->updateLayout($roomid,'notes-'.$notesid);

		$listUrl    = SITE_URL.tsUrl('site','notes',array('ts'=>'list','siteid'=>$siteid,'notesid'=>$notesid));		
		$createUrl  = SITE_URL.tsUrl('site','notes',array('ts'=>'create','siteid'=>$siteid,'notesid'=>$notesid));
		$settingUrl = SITE_URL.tsUrl('site','notes',array('ts'=>'settings','siteid'=>$siteid,'notesid'=>$notesid));
		
		$html_data = array(
			'table'	    => 'notes',
			'itemid'	=> $notesid,
			'title'		=> $strSite['sitename'].'的日记',
			'action' => '<a href="'.$listUrl.'">全部</a>&nbsp;&middot;&nbsp;<a href="'.$createUrl.'">添加新日记</a>',    
			'settingurl'=> $settingUrl,
			'content'	=> '<div class="createnew"> 记录你的最新动向 <a href="'.$createUrl.'"> &gt; 提笔写日记</a> </div>',
				
		);
		foreach($html_data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			$tmpdata[$tmpkey] = $itemTmp;
		}	
		$arrJson = array('r'=>0, 'html'=>strtr($htmlTemplate,$tmpdata));
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 	
		break;
		
	case "forum":
		//论坛数据	
		$arrData = array(
				'userid'		=> $userid,
				'siteid'		=> $siteid,
				'roomid'		=> $roomid,
				'title'			=> $strSite['sitename'].'的论坛',
				'display_number'		=> 5,
				'addtime'		=> time(),
			);
		//插入数据生成id	
		$forumid = aac('site')->create('site_forum', $arrData);
		//更新该房间组件数目
		$db->query("update ".dbprefix."site_room set count_widget = count_widget+1  where roomid='$roomid'");
		//更新该房间组件布局
		aac('site')->updateLayout($roomid,'forum-'.$forumid);
		
		$listUrl    = SITE_URL.tsUrl('site','forum',array('ts'=>'list','forumid'=>$forumid));		
		$createUrl  = SITE_URL.tsUrl('site','forum',array('ts'=>'create','forumid'=>$forumid));
		$settingUrl = SITE_URL.tsUrl('site','forum',array('ts'=>'settings','forumid'=>$forumid));
		
		$html_data = array(
			'table'	    => 'forum',
			'itemid'	=> $forumid,
			'title'		=> $strSite['sitename'].'的论坛',
			'action' => '<a href="'.$listUrl.'">全部</a>&nbsp;&middot;&nbsp;<a href="'.$createUrl.'">发言</a>',    
			'settingurl'=> $settingUrl,
			'content'	=> '<table class="list-b"><tr><td>话题</td><td>作者</td><td nowrap="nowrap">回应</td><td align="right">更新时间</td></tr></table>',			
		);	
		foreach($html_data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			$tmpdata[$tmpkey] = $itemTmp;
		}				
		$arrJson = array('r'=>0, 'html'=>strtr($htmlTemplate,$tmpdata));
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 	
		break;

	case "photos":
		//论坛数据	
		$arrData = array(
				'userid'		=> $userid,
				'siteid'		=> $siteid,
				'roomid'		=> $roomid,
				'title'			=> $strSite['sitename'].'的相册',
				'display_number'		=> 25,
				'addtime'		=> time(),
			);
		//插入数据生成id	
		$photosid = aac('site')->create('site_photos', $arrData);
		//更新该房间组件数目
		$db->query("update ".dbprefix."site_room set count_widget = count_widget+1  where roomid='$roomid'");
		//更新该房间组件布局
		aac('site')->updateLayout($roomid,'photos-'.$photosid);
		
		$listUrl    = SITE_URL.tsUrl('site','photos',array('ts'=>'list','photosid'=>$photosid));		
		$createUrl  = SITE_URL.tsUrl('site','photos',array('ts'=>'upload','photosid'=>$photosid));
		$settingUrl = SITE_URL.tsUrl('site','photos',array('ts'=>'settings','photosid'=>$photosid));
		
		$html_data = array(
			'table'	    => 'photos',
			'itemid'	=> $photosid,
			'title'		=> $strSite['sitename'].'的相册',
			'action' => '<a href="'.$listUrl.'">全部</a>&nbsp;&middot;&nbsp;<a href="'.$createUrl.'">添加照片</a>',    
			'settingurl'=> $settingUrl,
			'content'	=> '<div class="widget-photo-list"><ul class="list-s"></ul></div>',			
		);	
		foreach($html_data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			$tmpdata[$tmpkey] = $itemTmp;
		}				
		$arrJson = array('r'=>0, 'html'=>strtr($htmlTemplate,$tmpdata));
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 	
		break;
		
		
}