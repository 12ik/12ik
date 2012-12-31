<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
$notesid = intval($_GET['notesid']);
$strNotes = aac('site')->getOneNotes($notesid);
$siteid = $strNotes['siteid'];
$roomid = $strNotes['roomid']; //导航
$userid = $_SESSION['ikuser']['userid'];
//加载风格
include_once 'theme.php';

//页面
switch ($ik) {
	case "" :
		//日记显示
		$noteid = intval($_GET['noteid']);
		$strNote = aac('site')->getOneNote($noteid);
		$strcontent = $strNote['content'];	
		
		//匹配视频
		preg_match_all ( '/\[(视频)(\d+)\]/is', $strcontent, $videos );		
		foreach ($videos[2] as $vitem)
		{
			$strVideo =  aac('site')->find('videos',array('userid'=>$userid, 'typeid'=>$noteid, 'type'=>'notes', 'seqid'=>$vitem));
			$videohtml = ikVideo($strVideo['videourl']);
			$strcontent = str_replace ( '[视频'.$vitem.']', $videohtml, $strcontent );
		}
		//匹配本地图片
		preg_match_all ( '/\[(图片)(\d+)\]/is', $strcontent, $photos );		
		foreach ($photos [2] as $item) {
			$strPhoto = aac('site')->getPhotoByseq($noteid,$item);
			$htmlTpl = '<div class="'.$strPhoto['align'].'"><table><tbody><tr><td>
						<img alt="'.$strPhoto['photodesc'].'" src="'.$strPhoto['photo_600'].'">
						</td></tr><tr><td align="center" class="wr pl">'.$strPhoto['photodesc'].'</td></tr></tbody></table>
						</div>';

			$strcontent = str_replace ( '[图片'.$item.']', $htmlTpl, $strcontent );
		}	
		//匹配链接
		preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
		$strcontent, $content);
		foreach($content[2] as $c1)
		{	
			$strcontent = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $strcontent);
			$strcontent = str_replace ( "[/url]", '</a>', $strcontent);
		}
		$strNote['content'] = $strcontent;	
		//更新统计 被浏览数
		if($userid != $strNotes['userid']){
			$arrData = array('count_view'=> $strNote['count_view']+1);
			aac('site')->update('site_notes_content',array('contentid'=>$noteid),$arrData);	
		}
		//评论
		$arrComments = aac('site')->findAll('site_note_comment',array('noteid'=>$noteid));
		$goon = intval($_GET['goon']);
		foreach($arrComments as $key => $item)
		{
			$arrComment[] = $item;
			$arrComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
		}
		$myComment = aac('site')->find('site_note_comment',array('userid'=>$userid,'noteid'=>$noteid),'','addtime desc');
		//判断是否小于60秒之后才能继续发言
		$mycommentTime =  time() - strtotime(date('Y-m-d H:i:s',$myComment['addtime'])) > 60;
		if($goon==1 && $userid>0)
		{
			$mycommentTime = true;
		}
								
		$title = $strNote['title'].'-'.$strNotes['title'];
		include template('note');
		break;		
		
	case "settings" :
		$title = trim($_POST['title']);
		$roomid = intval($_POST['roomid']);//要转移的房间id
		$display_number = intval($_POST['display_number']);//显示个数
		
		$strRoom = aac('site')->getOneRoom($strNotes['roomid']);
		
		$actionUrl = SITE_URL.ikUrl('site','notes',array('ik'=>'settings','notesid'=>$notesid));
		$deleteUrl = SITE_URL.ikUrl('site','notes',array('ik'=>'delete','notesid'=>$notesid));
		//判断是否是存档
		if($strNotes['isarchive']==1)
		{
		 	$archiveUrl = SITE_URL.ikUrl('site','notes',array('ik'=>'unarchive','notesid'=>$notesid));//恢复url
			$archiveName = "恢复此应用";
		}else{
		 	$archiveUrl = SITE_URL.ikUrl('site','notes',array('ik'=>'archive','notesid'=>$notesid));//存档url
			$archiveName = "存档此应用";			
		}
				
		$strdis = '';
		if($strNotes['display_number']==2)
		{
			$strdis = '<label><input value="2" name="display_number" type="radio" checked> 2</label>
			<label><input value="5" name="display_number" type="radio"> 5</label>
			<label><input value="10" name="display_number" type="radio"> 10</label>';
		}else if ($strNotes['display_number']==5){
			$strdis = '<label><input value="2" name="display_number" type="radio"> 2</label>
			<label><input value="5" name="display_number" type="radio" checked> 5</label>
			<label><input value="10" name="display_number" type="radio"> 10</label>';
		}else if($strNotes['display_number']==10){
			$strdis = '<label><input value="2" name="display_number" type="radio"> 2</label>
			<label><input value="5" name="display_number" type="radio"> 5</label>
			<label><input value="10" name="display_number" type="radio" checked> 10</label>';		
		}
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
			<input type="text" name="title" size="15" maxlength="15" value="'.$strNotes['title'].'">
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
			<a href="'.$archiveUrl.'" class="a_archive_mod" screen_name="日记" title="'.$strNotes['title'].'" room_name="'.$strRoom['name'].'">'.$archiveName.'</a>
			&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="'.$deleteUrl.'" class="a_delete_mod" title="真的要删除此应用?">删除</a>
			</span>
			</div>
			</fieldset>
			</form>		
		';
		
		//开始分发数据
		$arrdata = array();
		if(!empty($title)) $arrdata['title'] = $title;
		if(!empty($title)) $arrdata['display_number'] = $display_number;
		if(!empty($roomid) && $roomid!=0) $arrdata['roomid'] = $roomid;		
		//判断是更新还是 设置请求
		if(!empty($arrdata))
		{ 

			//更新
			$new['site']->update('site_notes',array('notesid'=>$notesid),array(
				'title'=>$arrdata['title'],'display_number'=>$arrdata['display_number']
			));
			if(!empty($arrdata['roomid']) && $arrdata['roomid']!=$strNotes['roomid'])
 			{
				$arrstatus = aac('site')->moveWidget($strNotes['roomid'], $roomid, 'notes-'.$notesid);
				if($arrstatus['status']==0)
				{
					//成功了 更新组件 房间id
					$db->query("update ".dbprefix."site_notes set roomid='$roomid'  where notesid='$notesid'");
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
				$tables = aac('site')->findAll('site_notes_content',array('notesid'=>$notesid),'addtime desc', '','0,'.$display_number.'');
				$html = '';
				//如果有数据
				if($tables)
				{
					foreach($tables as $item)
					{
					$html .= '
						<div class="item-entry">
							<div class="title">
								<a href="'.SITE_URL.ikUrl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid'])).'" title="'.$item['title'].'">'.$item['title'].'</a>
							</div>
							<div class="datetime">'.date('Y-m-d H:i:s',$item['addtime']).'</div>
							<div id="note_'.$item['contentid'].'_short" class="summary">'.getsubstrutf8(t($item['content']),0,120).'<a href="'.SITE_URL.ikUrl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid'])).'#note_'.$item['contentid'].'_footer">('.$item['count_comment'].'回应)</a>
							</div>
						</div> 				
					';
					}
				}else{
					$html ='<div class="createnew">记录你的最新动向 <a href="'.SITE_URL.ikUrl('site','notes',
					array('ik'=>'create','notesid'=>$notesid)).'"> &gt; 提笔写日记</a></div>';
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
			aac('site')->isAllow($strNotes['userid'],$userid,'archive');
			//更新 并存档
			aac('site')->update('site_notes',array('notesid'=>$notesid),array('isarchive'=>1));
			$tables = aac('site')->find('site_notes', array('notesid'=>$notesid));
			$isarchive = $tables['isarchive'];
			$roomid = $tables['roomid'];
			
			if($isarchive==1)
			{
				$archiveid = aac('site')->create('site_archive', 
					array(
						'roomid'=>$roomid,
						'widgetid'=>$notesid,
						'widgetname'=>'notes',
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
			aac('site')->isAllow($strNotes['userid'],$userid,'unarchive');
			//更新 并存档
			aac('site')->update('site_notes',array('notesid'=>$notesid),array('isarchive'=>0));	
			$tables = aac('site')->find('site_notes', array('notesid'=>$notesid));
			$isarchive = $tables['isarchive'];	
			$roomid = $tables['roomid'];
			if($isarchive==0)
			{
				//删除存档
				$archiveid = aac('site')->delete('site_archive',
				array('widgetid'=>$notesid,'widgetname'=>'notes','roomid'=>$roomid));
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
				aac('site')->isAllow($strNotes['userid'],$userid,'delete');
				//判断是否有数据
				$isDel = aac('site')->findCount('site_notes_content',array('notesid'=>$notesid));
				if($isDel > 0)
				{
					$arrJson = array('r'=>1, 'error'=>'请先清空内容，再删除。');
				}else{				
					//删除布局
					$arrLayout = aac('site')->delWidget($strNotes['roomid'], 'notes-'.$notesid);
					aac('site')->update('site_room_widget',array('roomid'=>$strNotes['roomid']),$arrLayout);
					//删除组件
					$new['site']->delete('site_notes',array('notesid'=>$notesid));
					//删除存档表里数据
					$new['site']->delete('site_archive',array('widgetname'=>'notes','widgetid'=>$notesid));			
					//更新site_room表 组件数
					$db->query("update ".dbprefix."site_room set count_widget = count_widget-1  where roomid='$strNotes[roomid]'");
					$arrJson = array('r'=>0, 'html'=>'delete success');
				}
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 
				
		break;	
			
	case "create" :
		//判断权限
		aac('site')->isAllow($strNotes['userid'],$userid,'create');			
		//新建日记		
		$note_submit = trim($_POST['note_submit']); //提交按钮
		$cancel_note = trim($_POST['cancel_note']); //取消发布按钮
		
		$isreply = intval($_POST['isreply']); //是否允许评论
		$note_title = trim($_POST['note_title']);
		$note_content = trim($_POST['note_content']);
		$note_id =  trim($_POST['note_id']);
		
		//预先执行添加一条记录
		$strLastnote = aac('site')->find('site_notes_content',array('userid'=>$userid, 'notesid'=>0));
		if($strLastnote['contentid']>0)
		{
			$noteid = $strLastnote['contentid'];
		}else{
			$noteid = aac('site')->create('site_notes_content',
				array('userid'=>$userid, 'notesid'=>0,'title'=>'0','content'=>'0','addtime'=>time())
			);
		}
		//浏览该noteid下的照片
		$arrPhotos = aac('site')->getPhotosByNoteid($userid, $noteid);
		//浏览该noteid下的视频
		$arrVideos = aac('site')->findAll('videos',array('userid'=>$userid, 'typeid'=>$noteid, 'type'=>'notes'));			
		//提交按钮
		if($note_submit)
		{
			if($note_title=='' || $note_content=='') ikNotice("标题和内容都不能为空！");
			if(mb_strlen($title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
			if(mb_strlen($content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
			//执行添加
			aac('site')->update('site_notes_content',
				array('contentid'=>$noteid),
				array('notesid'=>$notesid, 'title'=>$note_title,'content'=>htmlspecialchars($note_content),'addtime'=>time())
			);
			//执行更新图片***********************************************//
			foreach($arrPhotos as $key=>$item)
			{
				$photo_seqid = intval($_POST['p'.$item['seqid'].'_seqid']);
				$photodesc   = $_POST['p'.$item['seqid'].'_title'];
				$photo_align = $_POST['p'.$item['seqid'].'_align'];
				if($photo_seqid > 0)
				{
					//存在表单 开始执行更新
					$arrData = array(
						'photodesc'	=> $photodesc,
						'align' => $photo_align,
					);			
					aac('site')->update('site_note_photo',array('noteid'=>$note_id,'seqid'=>$photo_seqid), $arrData);						
				}				
			}
			
			////////////////////////////////////////////////////////////
			header("Location: ".SITE_URL.ikUrl('site','notes',array('notesid'=>$notesid,'noteid'=>$note_id)));
		}

		$title = '新加日记';
		include template('notes_create');
		break;	
	case "edit" :
		//判断权限
		aac('site')->isAllow($strNotes['userid'],$userid,'create');			
		//日记编辑 显示
		$noteid = intval($_GET['noteid']);
		$arrNote = aac('site')->find('site_notes_content',array('contentid'=>$noteid));	
		//浏览该noteid下的照片
		$arrPhotos = aac('site')->getPhotosByNoteid($userid, $noteid);
		//浏览该noteid下的照片
		$arrVideos = aac('site')->findAll('videos',array('userid'=>$userid, 'typeid'=>$noteid, 'type'=>'notes'));		
		//接收提交数据		
		$note_submit = trim($_POST['note_submit']); //提交按钮
		$cancel_note = trim($_POST['cancel_note']); //取消发布按钮		
		$isreply = intval($_POST['isreply']); //是否允许评论
		$note_title = trim($_POST['note_title']);
		$note_content = trim($_POST['note_content']);
		$note_id =  trim($_POST['note_id']);
		
		//提交按钮
		if($note_submit)
		{
			if($note_title=='' || $note_content=='') ikNotice("标题和内容都不能为空！");
			if(mb_strlen($title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
			if(mb_strlen($content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
			//执行更新
			aac('site')->update('site_notes_content',
				array('contentid'=>$noteid),
				array('notesid'=>$notesid, 'title'=>$note_title,'content'=>htmlspecialchars($note_content),'addtime'=>time())
			);
			//执行更新图片***********************************************//
			foreach($arrPhotos as $key=>$item)
			{
				$photo_seqid = intval($_POST['p'.$item['seqid'].'_seqid']);
				$photodesc   = $_POST['p'.$item['seqid'].'_title'];
				$photo_align = $_POST['p'.$item['seqid'].'_align'];
				if($photo_seqid > 0)
				{
					//存在表单 开始执行更新
					$arrData = array(
						'photodesc'	=> $photodesc,
						'align' => $photo_align,
					);			
					aac('site')->update('site_note_photo',array('noteid'=>$note_id,'seqid'=>$photo_seqid), $arrData);						
				}				
			}
			
			////////////////////////////////////////////////////////////
			header("Location: ".SITE_URL.ikUrl('site','notes',array('notesid'=>$notesid,'noteid'=>$note_id)));
		}
	
		$title = '编辑日记';
		include template('notes_edit');
		break;	
	case "delnote" :
		//判断权限
		aac('site')->isAllow($strNotes['userid'],$userid,'delete');		
		//日记del
		$noteid = intval($_GET['noteid']);
		//删除评论
		aac('site')->delete('site_note_comment',array('noteid'=>$noteid));
		//删除照片
		aac('site')->delete('site_note_photo',array('noteid'=>$noteid));		
		//删除帖子	
		aac('site')->delete('site_notes_content',array('contentid'=>$noteid,'notesid'=>$notesid));
		
	    header("Location: ".SITE_URL.ikUrl('site','notes',array('ik'=>'list','notesid'=>$notesid)));

		break;				
	case "list" :
		//日记列表
		$arrNote = array();
		$arrNotes = aac('site')->findAll('site_notes_content',array('notesid'=>$notesid),'addtime desc');
		foreach ($arrNotes as $key=>$item)
		{
			$arrNote[] = $item;
			$strcontent = $item['content'];
			//匹配视频
			preg_match_all ( '/\[(视频)(\d+)\]/is', $strcontent, $videos );		
			if(!empty($videos [2]))
			{
				//echo $photos [2][0];
				$arrvideo = aac('site')->find('videos',
					array('typeid'=>$item['contentid'],'type'=>'notes','seqid'=>$videos[2][0]));
				
				$arrNote[$key]['video']['imgurl']=  $arrvideo['imgurl'];
			}			
			//匹配链接
			preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
			$strcontent, $contenturl);
			foreach($contenturl[2] as $c1)
			{	
				$strcontent = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $strcontent);
				$strcontent = str_replace ( "[/url]", '</a>', $strcontent);
			}
			//echo $strcontent;	
			$strcontent = preg_replace ( '/\[(图片)(\d+)\]/is', '', $strcontent);
			$strcontent = preg_replace ( '/\[(视频)(\d+)\]/is', '', $strcontent);
			$arrNote[$key]['content'] = $strcontent;
			//匹配本地图片
			preg_match_all ( '/\[(图片)(\d+)\]/is', $item['content'], $photos );	
			
			if(!empty($photos [2]))
			{
				//echo $photos [2][0];
				$arrNote[$key]['photo'] = aac('site')->getPhotoByseq($item['contentid'],$photos [2][0]);
			}
			
			
		}		

		include template('notes_list');
		break;
	case "add_comment" :
		//判断权限
		$userid = aac('user')->isLogin();//登录发言		
		$noteid = intval($_GET['noteid']);
		$content = trim($_POST['content']);
		if($content=='')
		{
			ikNotice('没有任何内容是不允许你通过滴^_^');		
		}
		$commentid =aac('site')->create('site_note_comment',
				array('referid'=>'0','noteid'=>$noteid, 'userid'=>$userid,'content'=>htmlspecialchars($content),'addtime'=>time())
		);
		$strCount = aac('site')->getOneNote($noteid);
		if($commentid>0){
			//执行update回复数
			 aac('site')->update('site_notes_content',
				array('notesid'=>$notesid,'contentid'=>$noteid),
				array('count_comment'=>$strCount['count_comment']+1)
			);
		}
		header("Location: ".SITE_URL.ikUrl('site','notes',array('notesid'=>$notesid,'noteid'=>$noteid)));

		break;		
	case "del_comment" :	
		$noteid = intval($_GET['noteid']);
		$commentid = intval($_GET['commentid']);
		$strComment = aac('site')->find('site_note_comment',array('commentid'=>$commentid));
		//判断权限
		if($strNotes['userid']!=$userid && $strComment['userid']!=$userid)
		{	
			ikNotice('你没有执行该操作(del_comment)的权限！');	
			
		}else if(empty($userid)){
			
			ikNotice('你没有执行该操作(del_comment)的权限！','请登录后重试',SITE_URL.ikUrl('user','login'));	
		}
				
		aac('site')->delete('site_note_comment',array('commentid'=>$commentid,'noteid'=>$noteid));		
		$strCount = aac('site')->getOneNote($noteid);		
	
		//执行update回复数
		aac('site')->update('site_notes_content',
			array('notesid'=>$notesid,'contentid'=>$noteid),
			array('count_comment'=>$strCount['count_comment']-1)
		);
		
		header("Location: ".SITE_URL.ikUrl('site','notes',array('notesid'=>$notesid,'noteid'=>$noteid)));

		break;
	case "add_photo" :

		$note_id = $_POST['note_id'];
		$userid = intval($_POST['userid']); 
		//$ck = $_POST['ck'];
		$photonum = aac('site')->findCount('site_note_photo',array('noteid'=>$note_id));

		$arrUpload = ikUpload($_FILES['image_file'],$photonum+1,'site/note/'.$note_id,array('jpg','gif','png'));
		
		if($arrUpload)
		{	
			//插入数据库
			$arrData = array(
				'seqid'	    => $photonum+1,
				'userid'	=> $userid,
				'noteid'	=> $note_id,
				'photoname'	=> $arrUpload['name'],
				'phototype' => $arrUpload['type'],
				'photosize' => $arrUpload['size'],
				'path' => 'note/'.$note_id.'/'.$arrUpload['path'],
				'photourl' => 'note/'.$note_id.'/'.$arrUpload['url'],				
				'addtime'	=> time(),
			);			
			aac('site')->create('site_note_photo', $arrData);		
			//清除缓存图片
			//ClearAppCache($app.'/note/'.$note_id.'/'.$arrUpload['path']);
			
			//浏览该noteid下的照片
			$arrPhoto = aac('site')->getPhotoByseq($note_id,$photonum+1);
			
			$arrparam = array('file_name'=>$arrPhoto['photoname'], 'file_size'=>$arrPhoto['photosize'],
			'id'=>$note_id,'seq'=>$photonum+1,'thumb'=>$arrPhoto['photo_140']);	
								
			$arrJson = array('r'=>0, 'photo'=>$arrparam);
			echo json_encode($arrJson);	
			
		}else{
			$arrJson = array('r'=>1, 'err'=>"上传失败,请重试！");
			echo json_encode($arrJson); 
		}		

		//header("Content-Type: application/json", true);
		//echo json_encode($arrJson); 		
		break;	
		
	case "add_video" :		
		
		$url = urldecode(trim($_POST['url']));
		$note_id = intval($_POST['nid']); 
		$arrVideo = getVideoInfo($url);
		
		if(!empty($arrVideo['videourl']))
		{
			$seqnum = aac('site')->findCount('videos',array('typeid'=>$note_id,'type'=>'notes'));
			
			$imgurl = empty($arrVideo['imgurl']) ?  SITE_URL.'/public/images/video_default.gif' : $arrVideo['imgurl'];
			$arrJson = array('userid'=>$userid,'typeid'=>$note_id, 'type'=>'notes','videourl'=>$arrVideo['videourl'], 
			'title'=>$arrVideo['title'],'imgurl'=>$imgurl,'seqid'=>$seqnum+1,'url'=>$url,'addtime'=>time());
			
			$videoid = aac('site')->create('videos', $arrJson);	
			
			if($videoid>0)
			{
				header("Content-Type: application/json", true);
				echo json_encode($arrJson); 				
			}	
			
		}else{
			$arrJson = array('r'=>'true', 'error'=>"视频网址格式不正确,或是我们不支持的格式（请不要填写视频专辑地址）");
			header("Content-Type: application/json", true);
			echo json_encode($arrJson); 
		}
			

		
		break;
}