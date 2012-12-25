<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
$bulletinid = intval($_GET['bulletinid']);
$strBulletin = aac('site')->getOneBulletin($bulletinid);
$siteid = $strBulletin['siteid'];
$roomid = $strBulletin['roomid']; //导航
$userid = $_SESSION['ikuser']['userid'];
//加载风格
include_once 'theme.php';

//页面
switch ($ik) {
	case "" :
		//公告显示页面
		$str = $strBulletin['content'];//url格式成html
		preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
		$str, $content);
		foreach($content[2] as $c1)
		{
			$str = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $str);
			$str = str_replace ( "[/url]", '</a>', $str);
		}
		$strBulletin['content'] = $str;

		$title = $strSite['sitename'].'的公告栏';
		include template('bulletin_show');
		break;	
	case "update" :
		//判断权限
		aac('site')->isAllow($strBulletin['userid'],$userid,'update');		
		//房间显示页面
		$content =  $_POST['content'];
		$historyurl = trim($_POST['historyurl']);

		$jump = $_SERVER['HTTP_REFERER'];//来源链接
		
		if($bulletinid!=0 && $content!='')
		{
			$new['site']->update('site_bulletin',array('bulletinid'=>$bulletinid),array(
				'content'	=> htmlspecialchars($content)
				));
			//header("Location: ".SITE_URL.ikUrl('site','room',array('roomid'=>$strBulletin['roomid'],'siteid'=>$strBulletin['siteid'])));
			
			header("Location: ".$historyurl);
		}
		$title = '编辑公告栏';
		include template('bulletin_update');
		break;

	case "settings":
		$title = trim($_POST['title']);
		$roomid = intval($_POST['roomid']);//要转移的房间id

		$strRoom = aac('site')->getOneRoom($strBulletin['roomid']);
		
		$actionUrl = SITE_URL.ikUrl('site','bulletin',array('ik'=>'settings','bulletinid'=>$bulletinid));
		$deleteUrl = SITE_URL.ikUrl('site','bulletin',array('ik'=>'delete','bulletinid'=>$bulletinid));
		//判断是否是存档
		if($strBulletin['isarchive']==1)
		{
		 	$archiveUrl = SITE_URL.ikUrl('site','bulletin',array('ik'=>'unarchive','bulletinid'=>$bulletinid));//恢复url
			$archiveName = "恢复此应用";
		}else{
		 	$archiveUrl = SITE_URL.ikUrl('site','bulletin',array('ik'=>'archive','bulletinid'=>$bulletinid));//存档url
			$archiveName = "存档此应用";			
		}

		
		$options = '<option value="0">选择房间</option>';
		foreach($strRooms as $items)
		{
			$options = $options.'<option value="'.$items['roomid'].'">'.$items['name'].'</option>';
		}
		$html = '<form action="'.$actionUrl.'" method="post">
  				<fieldset>
					<div class="item">
					  <label>应用名称：</label>
					  <input type="text" name="title" size="15" maxlength="15" value="'.$strBulletin['title'].'"/>
					</div>
					<div class="item">
					  <label>移动到：</label>
					  <select name="roomid">'.$options.'</select>
					</div>
					<div class="item-submit">
					  <span class="bn-flat-hot"><input type="submit" value="保存"></span>
					  <a href="#" class="a_cancel_setting_panel">取消</a>
					  <span class="setting-panel-ops">
						<a href="'.$archiveUrl.'" class="a_archive_mod" screen_name="公告栏" title="'.$strBulletin['title'].'" room_name="'.$strRoom['name'].'">'.$archiveName.'</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="'.$deleteUrl.'" class="a_delete_mod" title="真的要删除此应用?">删除</a>
					  </span>
					</div>
  				</fieldset>
			</form>';
		//开始分发数据
		$arrdata = array();
		if(!empty($title))
		{
			$arrdata['title'] = $title;
		}
		if(!empty($roomid) && $roomid!=0)
		{
			$arrdata['roomid'] = $roomid;
		}
		//判断是更新还是 设置请求
		if(!empty($arrdata))
		{
			//更新
			$new['site']->update('site_bulletin',array('bulletinid'=>$bulletinid),array('title'=>$arrdata['title']));
			if(!empty($arrdata['roomid']) && $arrdata['roomid']!=$strBulletin['roomid'])
 			{
				$arrstatus = aac('site')->moveWidget($strBulletin['roomid'], $roomid, 'bulletin-'.$bulletinid);
				if($arrstatus['status']==0)
				{
					//成功了 更新组件 房间id
					$db->query("update ".dbprefix."site_bulletin set roomid='$roomid'  where bulletinid='$bulletinid'");
					$arrJson = array('r'=>0, 'html'=>'');	
				}else if($arrstatus['status']==1)
				{
					$arrJson = array('r'=>1, 'error'=>$arrstatus['roomname'].'房间应用个数已达上限，先移除几个吧');	
				}
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 
				exit();
			}else{
	 			//取数据
				$tables = aac('site')->find('site_bulletin', array('bulletinid'=>$bulletinid));
				$str = $tables['content'];
				preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
				$str, $content);
				foreach($content[2] as $c1)
				{
					$str = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $str);
					$str = str_replace ( "[/url]", '</a>', $str);
				}
				$str = '<div class="bulletin-content">'.$str.'</div>';
		 
				$arrJson = array('r'=>0, 'html'=>$str);
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 
				exit();			
			}

			
		}else{
			$arrJson = array('r'=>0, 'html'=>$html);
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 
		}
	break;
	
	case "delete":
			//判断权限
			aac('site')->isAllow($strBulletin['userid'],$userid,'delete');				
			//删除布局
			$arrLayout = aac('site')->delWidget($strBulletin['roomid'], 'bulletin-'.$bulletinid);
			aac('site')->update('site_room_widget',array('roomid'=>$strBulletin['roomid']),$arrLayout);
			//删除组件
			$new['site']->delete('site_bulletin',array('bulletinid'=>$bulletinid));
			//删除存档表里数据
			$new['site']->delete('site_archive',array('widgetname'=>'bulletin','widgetid'=>$bulletinid));			
			//更新site_room表 组件数
			$db->query("update ".dbprefix."site_room set count_widget = count_widget-1  where roomid='$strBulletin[roomid]'");
			$arrJson = array('r'=>0, 'html'=>'delete success');
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 

	break;
	
	case "archive":
			//判断权限
			aac('site')->isAllow($strBulletin['userid'],$userid,'archive');
			$bulletinid = intval($_GET['bulletinid']);
			//$siteid = intval($_GET['siteid']);
			
			//更新 并存档
			aac('site')->update('site_bulletin',array('bulletinid'=>$bulletinid),array('isarchive'=>1));
			$tables = aac('site')->find('site_bulletin', array('bulletinid'=>$bulletinid));
			$isarchive = $tables['isarchive'];
			$roomid = $tables['roomid'];
			
			if($isarchive==1)
			{
				$archiveid = aac('site')->create('site_archive', 
					array(
						'roomid'=>$roomid,
						'widgetid'=>$bulletinid,
						'widgetname'=>'bulletin',
						'addtime'=>time()
					));
			}
			if(!empty($archiveid))
			{
				$arrJson = array('r'=>0, 'html'=>'success');
			}else{
				$arrJson = array('r'=>1, 'error'=>'存档失败,请重试！');
			}
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 	

	break;
	//恢复该应用
	case "unarchive":
			//判断权限
			aac('site')->isAllow($strBulletin['userid'],$userid,'unarchive');			
			//更新 恢复存档
			aac('site')->update('site_bulletin',array('bulletinid'=>$bulletinid),array('isarchive'=>0));
			$tables = aac('site')->find('site_bulletin', array('bulletinid'=>$bulletinid));
			$isarchive = $tables['isarchive'];
			$roomid = $tables['roomid'];
			
			
			$archiveid = aac('site')->delete('site_archive',array('widgetid'=>$bulletinid,'widgetname'=>'bulletin','roomid'=>$roomid));//删除存档				
			
			if($isarchive == 0 && !empty($archiveid))
			{
				$arrJson = array('r'=>0, 'html'=>'success');
			}else{
				$arrJson = array('r'=>1, 'error'=>'恢复失败,请重试！');
			}
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 	

	break;	

}