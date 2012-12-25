<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	
	case "edit" :
		
		//分类 
		$arrCate = $new['note']->getArrCate($userid);
		$noteid = intval( $_GET['noteid'] );
		$strNote = $db->once_fetch_assoc ( "select * from " . dbprefix . "note where noteid='$noteid'" );
		
		$title = '编辑日志';
		include template('edit');
		
		break;
		
	case "edit_do" :
	
		$noteid = $_GET['noteid'];
		$cateid = $_POST['cateid'];
		$title	= htmlspecialchars(trim($_POST['title']));
		$content = $_POST['content'];
		
		if($title=='' || $content=='') qiMsg("标题和内容都不能为空！");
		if(mb_strlen($title,'utf8')>64) ikNotice('标题很长很长很长很长...^_^');
		if(mb_strlen($content,'utf8')>50000) ikNotice('发这么多内容干啥^_^');
		
		$isphoto = 0;
		$isattach = 0;
		
		//判断是否有图片和附件
		preg_match_all('/\[(photo)=(\d+)\]/is', $content, $photo);
		if($photo[2]){
			$isphoto = '1';
		}
		//判断附件
		preg_match_all('/\[(attach)=(\d+)\]/is', $content, $attach);
		if($attach[2]){
			$isattach = '1';
		}
		
		$arrData = array(
			'cateid' => $cateid,
			'title'			=> $title,
			'content'		=> $content,
		);

		$new['note']->update('note',array(
			'noteid'=>$noteid,
		),$arrData);
		
		//处理标签
		aac('tag')->addTag('note','noteid',$noteid, trim($_POST['tag']) );
		
		header("Location: ".SITE_URL.ikUrl('note','show',array('noteid'=>$noteid)));
	
		break;
		
	case "del" :
		
		//分类 
		$noteid = intval( $_GET['noteid'] );

		$strNote= $new['note']->find('note',array('noteid'=>$noteid));
		
		if( $userid == $strNote['userid'] || $IK_USER['user']['isadmin'] == '1'){
			
			//删除帖子
			$new['note']->delNote($noteid);
			header("Location: ".SITE_URL.ikUrl('note','index',array('ik'=>'user','userid'=>$userid)));
			
		}else{
			ikNotice('没有日志可以删除，别瞎搞！');
		}
		
		break;
	//case "" :
	
}

