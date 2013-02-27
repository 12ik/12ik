<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
$forumid = intval($_GET['forumid']);
$strForum = aac('site')->find('site_forum',array('forumid'=>$forumid));;
$siteid = $strForum['siteid'];
$roomid = $strForum['roomid']; //导航
$userid = $_SESSION['ikuser']['userid'];
//加载风格
include_once 'theme.php';

//页面
switch ($ik) {
	case "" :
		//显示
		$discussid = intval($_GET['discussid']);
		$goon = intval($_GET['goon']);
		$strdiscuss = aac('site')->find('site_forum_discuss',array('discussid'=>$discussid));
		$strUser = aac('user')->getOneUser($strdiscuss['userid']);
		$arrComments = aac('site')->findAll('site_discuss_comment',array('discussid'=>$discussid));
		foreach($arrComments as $key => $item)
		{
			$arrComment[] = $item;
			$arrComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
		}
		$myComment = aac('site')->find('site_discuss_comment',array('userid'=>$userid,'discussid'=>$discussid),'','addtime desc');
		//判断是否小于60秒之后才能继续发言
		$mycommentTime =  time() - strtotime(date('Y-m-d H:i:s',$myComment['addtime'])) > 60;
		if($goon==1 && $userid>0)
		{
			$mycommentTime = true;
		}
		$title = $strdiscuss['title'].'-'.$strForum['title'];
		include template('forum_discuss_show');
		break;		
		
	case "settings" :
		$title = trim($_POST['title']);
		$roomid = intval($_POST['roomid']);//要转移的房间id
		$display_number = intval($_POST['display_number']);//显示个数	
		
		//当前房间
		$strRoom = aac('site')->getOneRoom($strForum['roomid']);
		
		$actionUrl = SITE_URL.U('site','forum',array('ik'=>'settings','forumid'=>$forumid));
		$deleteUrl = SITE_URL.U('site','forum',array('ik'=>'delete','forumid'=>$forumid));
		//判断是否是存档
		if($strForum['isarchive']==1)
		{
		 	$archiveUrl = SITE_URL.U('site','forum',array('ik'=>'unarchive','forumid'=>$forumid));//恢复url
			$archiveName = "恢复此应用";
		}else{
		 	$archiveUrl = SITE_URL.U('site','forum',array('ik'=>'archive','forumid'=>$forumid));//存档url
			$archiveName = "存档此应用";			
		}			
		//显示个数
		$strdis = '';
		if($strForum['display_number']==5)
		{
			$strdis = '<label><input value="5" name="display_number" type="radio" checked> 5</label>
					   <label><input value="10" name="display_number" type="radio"> 10</label>
					   <label><input value="20" name="display_number" type="radio"> 20</label>
					   <label><input value="30" name="display_number" type="radio"> 30</label>';
		}else if($strForum['display_number']==10)
		{
			$strdis = '<label><input value="5" name="display_number" type="radio"> 5</label>
					   <label><input value="10" name="display_number" type="radio" checked> 10</label>
					   <label><input value="20" name="display_number" type="radio"> 20</label>
					   <label><input value="30" name="display_number" type="radio"> 30</label>';
		}else if ($strForum['display_number']==20){
			$strdis = '<label><input value="5" name="display_number" type="radio"> 5</label>
			           <label><input value="10" name="display_number" type="radio"> 10</label>
					   <label><input value="20" name="display_number" type="radio" checked> 20</label>
					   <label><input value="30" name="display_number" type="radio"> 30</label>';
		}else if($strForum['display_number']==30){
			$strdis = '<label><input value="5" name="display_number" type="radio"> 5</label>
			           <label><input value="10" name="display_number" type="radio"> 10</label>
					   <label><input value="20" name="display_number" type="radio"> 20</label>
					   <label><input value="30" name="display_number" type="radio" checked> 30</label>';	
		}
		//房间列表
		$options = '<option value="0">选择房间</option>';
		foreach($strRooms as $items)
		{
			$options = $options.'<option value="'.$items['roomid'].'">'.$items['name'].'</option>';
		}			
		$html = '
				<form action="'.$actionUrl.'" method="post">
					<div style="display:none;"><input type="hidden" name="ck" value="P6J2"/></div>
					<fieldset>
					<div class="item">
					  <label>应用名称：</label>
					  <input type="text" name="title" size="15" maxlength="15" value="'.$strForum['title'].'">
					</div>				
					<div class="item item-display-num">
					  <label>显示个数：</label>
					  <span class="item-r">'.$strdis.'</span>
					</div>				
					<div class="item">
						<label>移动到：</label>
						<select name="roomid">'.$options.'</select>
					</div>				
					<div class="item-submit">
					  <span class="bn-flat-hot"><input type="submit" value="保存"></span>
					  <a href="#" class="a_cancel_setting_panel">取消</a>
					  <span class="setting-panel-ops">
						<a href="'.$archiveUrl.'" class="a_archive_mod" screen_name="论坛" title="'.$strForum['title'].'" room_name="'.$strRoom['name'].'">'.$archiveName.'</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="'.$deleteUrl.'" class="a_delete_mod" title="真的要删除此应用?">删除</a>
					  </span>
					</div>
					</fieldset>
				</form>';
		//开始分发数据
		$arrdata = array();
		if(!empty($title)) $arrdata['title'] = $title;
		if(!empty($title)) $arrdata['display_number'] = $display_number;
		if(!empty($roomid) && $roomid!=0) $arrdata['roomid'] = $roomid;					


		//判断是更新还是 设置请求
		if(!empty($arrdata))
		{ 

			//更新
			$new['site']->update('site_forum',array('forumid'=>$forumid),array(
				'title'=>$arrdata['title'],'display_number'=>$arrdata['display_number']
			));
			if(!empty($arrdata['roomid']) && $arrdata['roomid']!=$strForum['roomid'])
 			{
				$arrstatus = aac('site')->moveWidget($strForum['roomid'], $roomid, 'forum-'.$forumid);
				if($arrstatus['status']==0)
				{
					//成功了 更新组件 房间id
					$db->query("update ".dbprefix."site_forum set roomid='$roomid'  where forumid='$forumid'");
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
				$tables = aac('site')->findAll('site_forum_discuss',
						  array('forumid'=>$forumid),'istop desc,addtime desc', '','0,'.$display_number.'');
				$html = '<table class="list-b">
						 <tr><td>话题</td><td>作者</td><td nowrap="nowrap">回应</td><td align="right">更新时间</td></tr>';
				foreach($tables as $item)
				{
					$struser = aac('user')->getOneUser($item['userid']);
					$topimg = '<img src="/public/images/stick.gif"/>';
					$istop = $item['istop'] == 1 ? $topimg : '';
					$html .= '
							<tr>
								<td>'.$istop.' <a title="'.$item['title'].'" href="'.SITE_URL.U('site','forum',array('forumid'=>$item['forumid'],'discussid'=>$item['discussid'])).'">'.$item['title'].'</a></td>	
								<td>来自 <a href='.SITE_URL.U('hi','',array('id'=>$struser['doname'])).'"">'.$struser['username'].'</a></td>
								<td class="count" nowrap="nowrap">'.$item['count_comment'].'</td>
								<td class="date">'.date('Y-m-d H:i:s',$item['addtime']).'</td>
							</tr> 				
					';
				}
		 
				$arrJson = array('r'=>0, 'html'=>$html);
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
		
	case "archive" :
			//存档应用
			aac('site')->isAllow($strForum['userid'],$userid,'archive');
			//更新 并存档
			aac('site')->update('site_forum',array('forumid'=>$forumid),array('isarchive'=>1));
			$tables = aac('site')->find('site_forum', array('forumid'=>$forumid));
			$isarchive = $tables['isarchive'];
			$roomid = $tables['roomid'];
			
			if($isarchive==1)
			{
				$archiveid = aac('site')->create('site_archive', 
					array(
						'roomid'=>$roomid,
						'widgetid'=>$forumid,
						'widgetname'=>'forum',
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

	case "unarchive" :
			//存档应用
			aac('site')->isAllow($strForum['userid'],$userid,'unarchive');
			//更新 并存档
			aac('site')->update('site_forum',array('forumid'=>$forumid),array('isarchive'=>0));	
			$tables = aac('site')->find('site_forum', array('forumid'=>$forumid));
			$isarchive = $tables['isarchive'];	
			$roomid = $tables['roomid'];
			if($isarchive==0)
			{
				//删除存档
				$archiveid = aac('site')->delete('site_archive',
				array('widgetid'=>$forumid,'widgetname'=>'forum','roomid'=>$roomid));
			}							
			if(!empty($archiveid))
			{
				$arrJson = array('r'=>0, 'html'=>'success');
			}else{
				$arrJson = array('r'=>1, 'error'=>'恢复失败,请重试！');
			}		
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 				
		break;
		
	case "delete" :
		//删除组件
		//判断权限
		aac('site')->isAllow($strForum['userid'],$userid,'delete');
		//判断是否有数据
		$isDel = aac('site')->findCount('site_forum_discuss',array('forumid'=>$forumid));
		if($isDel > 0)
		{
			$arrJson = array('r'=>1, 'error'=>'请先清空内容，再删除。');
		}else{				
			//删除布局
			$arrLayout = aac('site')->delWidget($strForum['roomid'], 'forum-'.$forumid);
			aac('site')->update('site_room_widget',array('roomid'=>$strForum['roomid']),$arrLayout);
			//删除组件
			$new['site']->delete('site_forum',array('forumid'=>$forumid));
			//删除存档表里数据
			$new['site']->delete('site_archive',array('widgetname'=>'forum','widgetid'=>$forumid));			
			//更新site_room表 组件数
			$db->query("update ".dbprefix."site_room set count_widget = count_widget-1  where roomid='$strForum[roomid]'");
			$arrJson = array('r'=>0, 'html'=>'delete success');
		}
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 
				
		break;	
					
	case "create" :
		$userid = aac('user')->isLogin();//登录发言	
		$submit = trim($_POST['submit']);
		$title = trim($_POST['title']);
		$content = trim($_POST['content']);
		$strUser = aac('user')->getOneUser($userid);
		if($submit)
		{
			if($title=='' || $content=='') ikNotice("标题和内容都不能为空！");
			if(mb_strlen($title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
			if(mb_strlen($content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
			//执行添加
			$discussid = aac('site')->create('site_forum_discuss',
				array('forumid'=>$forumid,'userid'=>$userid, 'title'=>$title,'content'=>htmlspecialchars($content),'addtime'=>time())
			);
			
			header("Location: ".SITE_URL.U('site','forum',array('forumid'=>$forumid,'discussid'=>$discussid)));
		}

		$title = '在"'.$strForum['title'].'"发言';
		include template('forum_discuss_create');
		break;	
	case "list" :
		//日记列表

		$arrDiscusion = aac('site')->findAll('site_forum_discuss',array('forumid'=>$forumid),'istop desc,addtime desc');
		
		if( is_array($arrDiscusion)){
			foreach($arrDiscusion as $key=>$item){
				$arrDiscus[] = $item;
				$arrDiscus[$key]['user'] = aac('user')->getOneUser($item['userid']);
			}
		}		
		$title = $strForum['title'];
		include template('forum_discuss_list');
		break;
		
	case "editdiscuss" :
		//判断权限
		aac('site')->isAllow($strForum['userid'],$userid,'editdiscuss');		
		$discussid = trim($_GET['discussid']);
		$strUser = aac('user')->getOneUser($userid);		
		$strDiscusion = aac('site')->find('site_forum_discuss',array('discussid'=>$discussid));	
		$title = '编辑"'.$strDiscusion['title'].'"';
		include template('forum_discuss_edit');
		break;	
	case "updatediscuss" :
		aac('site')->isAllow($strForum['userid'],$userid,'updatediscuss');				
		$submit = trim($_POST['submit']);
		$title = trim($_POST['title']);
		$content = trim($_POST['content']);
		$discussid = trim($_GET['discussid']);
		if($submit)
		{
			if($title=='' || $content=='') ikNotice("标题和内容都不能为空！");
			if(mb_strlen($title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
			if(mb_strlen($content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
			//执行update
			 aac('site')->update('site_forum_discuss',
				array('forumid'=>$forumid,'discussid'=>$discussid),
				array('title'=>$title,'content'=>htmlspecialchars($content))
			);
			
		}
		header("Location: ".SITE_URL.U('site','forum',array('forumid'=>$forumid,'discussid'=>$discussid)));
		
		break;	
		
	case "deldiscuss" :
		//判断权限
		aac('site')->isAllow($strForum['userid'],$userid,'deldiscuss');		
		$discussid = trim($_GET['discussid']);
		//删除评论
		aac('site')->delete('site_discuss_comment',array('discussid'=>$discussid));
		//删除帖子
		aac('site')->delete('site_forum_discuss',array('discussid'=>$discussid));
		
	    header("Location: ".SITE_URL.U('site','forum',array('ik'=>'list','forumid'=>$forumid)));

		break;	
	case "istop" :
		//判断权限
		aac('site')->isAllow($strForum['userid'],$userid,'istop');		
		$discussid = trim($_GET['discussid']);
		$strDiscusion = aac('site')->find('site_forum_discuss',array('discussid'=>$discussid));	
		$strDiscusion['istop'] == 0 ? $istop=1 :$istop=0;
		aac('site')->update('site_forum_discuss',
			array('forumid'=>$forumid,'discussid'=>$discussid),
			array('istop'=>$istop)
		);
		header("Location: ".SITE_URL.U('site','forum',array('forumid'=>$forumid,'discussid'=>$discussid)));

		break;
			
	case "add_comment" :
		//判断权限
		$userid = aac('user')->isLogin();//登录发言		
		$discussid = intval($_GET['discussid']);
		$content = trim($_POST['content']);
		if($content=='')
		{
			ikNotice('没有任何内容是不允许你通过滴^_^');		
		}
		$commentid =aac('site')->create('site_discuss_comment',
				array('referid'=>'0','discussid'=>$discussid, 'userid'=>$userid,'content'=>htmlspecialchars($content),'addtime'=>time())
		);
		$strdiscuss = aac('site')->find('site_forum_discuss',array('discussid'=>$discussid));		
		if($commentid>0){
			//执行update回复数
			 aac('site')->update('site_forum_discuss',
				array('forumid'=>$forumid,'discussid'=>$discussid),
				array('count_comment'=>$strdiscuss['count_comment']+1)
			);
		}
		header("Location: ".SITE_URL.U('site','forum',array('forumid'=>$forumid,'discussid'=>$discussid)));

		break;
		
	case "del_comment" :	
		$discussid = intval($_GET['discussid']);
		$commentid = intval($_GET['commentid']);
		$strComment = aac('site')->find('site_discuss_comment',array('commentid'=>$commentid));
		//判断权限
		if($strForum['userid']!=$userid && $strComment['userid']!=$userid)
		{	
			ikNotice('你没有执行该操作(del_comment)的权限！');	
			
		}else if(empty($userid)){
			
			ikNotice('你没有执行该操作(del_comment)的权限！','请登录后重试',SITE_URL.U('user','login'));	
		}
		
		aac('site')->delete('site_discuss_comment',array('commentid'=>$commentid,'discussid'=>$discussid));		
		$strdiscuss = aac('site')->find('site_forum_discuss',array('discussid'=>$discussid));		
	
		//执行update回复数
		aac('site')->update('site_forum_discuss',
			array('forumid'=>$forumid,'discussid'=>$discussid),
			array('count_comment'=>$strdiscuss['count_comment']-1)
		);
		
		header("Location: ".SITE_URL.U('site','forum',array('forumid'=>$forumid,'discussid'=>$discussid)));

		break;
		
										
		
		
}