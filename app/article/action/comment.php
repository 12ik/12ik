<?php 
defined('IN_IK') or die('Access Denied.');

//不登陆不允许评论
$userid = aac('user')->isLogin();

switch($ts){
	//添加评论
	case "add":
		$nid = intval($_POST['nid']);
		$itemid = intval($_POST['itemid']); //属性id
		
		$content = trim($_POST['content']);

		if($content == '') tsNotice('没有任何内容是不允许你通过滴^_^');
		if(mb_strlen($content,'utf8')>10000) tsNotice('发这么多内容干啥,最多只能写1000千个字^_^,回去重写哇！');
		//正确之后执行	
		$arrData	= array(
			'nid'	=> $nid,
			'itemid'	=> $itemid,
			'userid'	=> $userid,
			'content'	=> htmlspecialchars($content),
			'addtime'	=> time()
		);
		//添加评论
		$commentid = aac('article') -> create('article_comments', $arrData);
		
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."article_comments 
		where nid='$nid'");
		//更新评论数
		$db->query("update ".dbprefix."article_spaceitems set replynum ='$count_comment' 
		where itemid='$itemid'");
		
		header("Location: ".SITE_URL.tsUrl('article','show',array('id'=>$nid)));
		
		break;
	
	//删除评论
	case "delete":
		
		$commentid = intval($_GET['commentid']);
		
		$strComment = aac('article')->find('article_comments',array('commentid'=>$commentid));

		$strArticleInfo = aac('article')->find('article_spaceitems',array('itemid'=>$strComment['itemid'],'uid'));
		//判断用户是有权限删除
		if($strArticleInfo['uid'] == $userid || $IK_USER['user']['isadmin']==1 || $userid==$strComment['userid']){
			
			aac('article')->delComment($commentid);
			//更新统计
			$db->query("update ".dbprefix."article_spaceitems set replynum = replynum -1 where itemid='".$strComment['itemid']."'");
		}
		
		//跳转
		header("Location: ".SITE_URL.tsUrl('article','show',array('id'=>$strComment['nid'])));
		
		break;
		
	//回复评论
	case "recomment":
		$referid = intval($_POST['referid']);
		$nid = $_POST['nid'];
		$itemid = $_POST['infoid'];
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
			'nid'	=> $nid,
			'itemid'	=> $itemid,
			'referid'   => $referid,
			'userid'	=> $userid,
			'content'	=> htmlspecialchars($content),
			'addtime'	=> time()
		);
		//添加评论
		$commentid = aac('article') -> create('article_comments', $arrData);
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."article_comments 
		where nid='$nid'");
		//更新评论数
		$db->query("update ".dbprefix."article_spaceitems set replynum ='$count_comment' 
		where itemid='$itemid'");		
		echo 0;
		
	    break;
}