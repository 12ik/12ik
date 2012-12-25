<?php
defined('IN_IK') or die('Access Denied.');
switch($ik){
	case "flash":
		
		$userid = intval($_POST['userid']);
		if($userid=='0'){
			echo '00000';
			exit;
		}
		
		$albumid = intval($_POST['albumid']);
		
		$arrData = array(
			'userid'	=> $userid,
			'albumid'	=> $albumid,
			'addtime'	=> time(),
		);
		
		$photoid = $db->insertArr($arrData,dbprefix.'photo');
		
		//上传
		$arrUpload = ikUpload($_FILES['Filedata'],$photoid,'photo',array('jpg','gif','png'));
		
		if($arrUpload){

			$new['photo']->update('photo',array(
				'photoid'=>$photoid,
			),array(
				'photoname'=>$arrUpload['name'],
				'phototype'=>$arrUpload['type'],
				'path'=>$arrUpload['path'],
				'photourl'=>$arrUpload['url'],
				'photosize'=>$arrUpload['size'],
			));
			
		}
		
		echo $photoid;
		
		break;
		
	//删除照片
	case "photo_del":
	
		//用户是否登录
		$userid = intval($IK_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.ikUrl('user','login'));
			exit;
		}
		
		aac('user')->isUser($userid);
		
		$photoid = $_GET['photoid'];
		$strPhoto = $db->once_fetch_assoc("select * from ".dbprefix."photo where photoid='$photoid'");
		if($strPhoto['userid']!=$userid) qiMsg("非法操作！");
		
		$albumid = $strPhoto['albumid'];
		
		unlink('uploadfile/photo/'.$strPhoto['photourl']);
		
		$db->query("delete from ".dbprefix."photo where photoid='$photoid'");
		
		$count_photo = $db->once_num_rows("select * from ".dbprefix."photo where albumid='$albumid'");
		
		$db->query("update ".dbprefix."photo_album set `count_photo`='$count_photo' where albumid='$albumid'");
		
		qiMsg("照片删除成功！",'点击返回','index.php?app=photo&ac=album&ik=photo&albumid='.$albumid);
		
		break;
	
	//添加评论
	case "comment_do":
		$photoid	= intval($_POST['photoid']);
		$content	= h($_POST['content']);
		
		//用户是否登录
		$userid = intval($IK_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.ikUrl('user','login'));
			exit;
		}
		
		aac('user')->isUser($userid);
		
		//标签
		doAction('add_comment','',$content,'');
		
		$arrData	= array(
			'photoid'			=> $photoid,
			'userid'			=> $userid,
			'content'	=> $content,
			'addtime'		=> time(),
		);
		
		$commentid = $db->insertArr($arrData,dbprefix.'photo_comment');
		
		
		//发送系统消息(通知楼主有人回复他的帖子啦)
		$strPhoto = $db->once_fetch_assoc("select * from ".dbprefix."photo where photoid='$photoid'");
		if($strPhoto['userid'] != $userid){
		
			$msg_userid = '0';
			$msg_touserid = $strPhoto['userid'];
			$msg_title = '你有照片新增一条评论，快去看看给个回复吧';
			$msg_content = '你有照片新增一条评论，快去看看给个回复吧^_^ <br />'
										.$IK_SITE['base']['site_url'].'index.php?app=photo&ac=show&photoid='.$photoid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_title,$msg_content);
			
		}
		
		header("Location: ".SITE_URL."index.php?app=photo&ac=show&photoid=".$photoid);

		break;
		
	//删除评论
	case "delcomment":
	
		//用户是否登录
		$userid = intval($IK_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.ikUrl('user','login'));
			exit;
		}
	
		$commentid = $_GET['commentid'];
		
		$strComment = $db->once_fetch_assoc("select photoid,userid from ".dbprefix."photo_comment where `commentid`='$commentid'");
		
		$strPhoto = $db->once_fetch_assoc("select userid from ".dbprefix."photo where `photoid`='".$strComment['photoid']."'");
		
		if($userid == $strPhoto['userid'] || $IK_USER['user']['isadmin']=='1'){
		
			$db->query("delete from ".dbprefix."photo_comment where `commentid`='$commentid'");
			
			qiMsg("删除评论成功！");
			
		}else{
			qiMsg("非法操作！");
		}
		
		
	
		break;
}
