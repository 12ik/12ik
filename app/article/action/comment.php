<?php 
defined('IN_IK') or die('Access Denied.');

//不登陆不允许评论
$userid = aac('user')->isLogin();

switch($ts){
	//添加评论
	case "add":
		$noteid = intval($_POST['noteid']);
		$content = trim($_POST['content']);

		if($content == '') tsNotice('没有任何内容是不允许你通过滴^_^');
		if(mb_strlen($content,'utf8')>10000) tsNotice('发这么多内容干啥,最多只能写1000千个字^_^,回去重写哇！');
		//正确之后执行	
		$arrData	= array(
			'noteid'	=> $noteid,
			'userid'	=> $userid,
			'content'	=> htmlspecialchars($content),
			'addtime'	=> time()
		);
		//添加评论
		$commentid = $new['note'] -> create('note_comment', $arrData);
		
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."note_comment 
		where noteid='$noteid'");
		//更新评论数
		$db->query("update ".dbprefix."note set count_comment='$count_comment' 
		where noteid='$noteid'");
		
		header("Location: ".SITE_URL.tsUrl('note','show',
			array('noteid'=>$noteid)));
		break;
	
	//删除评论
	case "delete":
		
		$commentid = intval($_GET['commentid']);
		
		$strComment = $new['note']->find('note_comment',array(
			'commentid'=>$commentid,
		));
		//根据回复id查找note
		$strNote = $new['note']->find('note',array(
			'noteid'=>$strComment['noteid'],
		));
		//判断用户是有权限删除
		if($strNote['userid'] == $userid || $IK_USER['user']['isadmin']==1){
			
			$new['note']->delComment($commentid);
			//更新统计
			$db->query("update ".dbprefix."note set count_comment=count_comment-1 where noteid='".$strComment['noteid']."'");
		}
		
		//跳转
		header("Location: ".SITE_URL.tsUrl('note','show',array('noteid'=>$strComment['noteid'])));
		
		break;
		
	//回复评论
	case "recomment":
		$referid = intval($_POST['referid']);
		$noteid = $_POST['noteid'];
		$content = trim($_POST['content']);
		$addtime = time();
		//安全性检查
		if( mb_strlen($content, 'utf8') > 10000)
		{
			echo 1;
			exit ();
		}
		//正确之后执行	
		$arrData	= array(
			'noteid'	=> $noteid,
			'referid'   => $referid,
			'userid'	=> $userid,
			'content'	=> htmlspecialchars($content),
			'addtime'	=> time()
		);
		//添加评论
		$commentid = $new['note'] -> create('note_comment', $arrData);
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."note_comment 
		where noteid='$noteid'");
		//更新评论数
		$db->query("update ".dbprefix."note set count_comment='$count_comment' 
		where noteid='$noteid'");
		echo 0;
		
	    break;
}