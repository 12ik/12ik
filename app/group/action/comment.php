<?php 
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){

	//添加评论
	case "do":
	
		$topicid	= intval($_POST['topicid']);
		$content	= trim($_POST['content']);
		
		//添加评论标签
		doAction('group_comment_add','',$content,'');
		
		if($content==''){
		
			ikNotice('没有任何内容是不允许你通过滴^_^');
			
		}else if(mb_strlen($content,'utf8')>10000){
			
			ikNotice('发这么多内容干啥,最多只能写1000千个字^_^,回去重写哇！');
			
		}else{
		
			$arrData	= array(
				'topicid'			=> $topicid,
				'userid'			=> $userid,
				'content'	=> htmlspecialchars($content),
				'addtime'		=> time(),
			);
			
			$commentid = $db->insertArr($arrData,dbprefix.'group_topics_comments');
			
			//上传图片开始
		/**	$arrUpload = ikUpload($_FILES['picfile'],$commentid,'comment',array('jpg','gif','png'));
			if($arrUpload){

				$new['group']->update('group_topics_comments',array(
					'commentid'=>$commentid,
				),array(
					'path'=>$arrUpload['path'],
					'photo'=>$arrUpload['url'],
				));
			}
			//上传图片结束
			
			//上传附件开始
			$attUpload = ikUpload($_FILES['attfile'],$commentid,'comment',array('zip','rar','doc','txt','pdf','ppt','docx','xls','xlsx'));
			if($attUpload){

				$new['group']->update('group_topics_comments',array(
					'commentid'=>$commentid,
				),array(
					'path'=>$attUpload['path'],
					'attach'=>$attUpload['url'],
					'attachname'=>$attUpload['name'],
				));
			}
			//上传附件结束
			
			**/
			
			//统计评论数
			$count_comment = $db->once_num_rows("select * from ".dbprefix."group_topics_comments where topicid='$topicid'");
			
			//更新帖子最后回应时间和评论数
			$uptime = time();
			
			$db->query("update ".dbprefix."group_topics set uptime='$uptime',count_comment='$count_comment' where topicid='$topicid'");
			
			//积分记录
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','回帖','20','".time()."')");
			
			$strScore = $db->once_fetch_assoc("select sum(score) score from ".dbprefix."user_scores where userid='".$userid."'");
			
			//更新积分
			$db->query("update ".dbprefix."user_info set `count_score`='".$strScore['score']."' where userid='$userid'");
			
			//发送系统消息(通知楼主有人回复他的帖子啦)
			$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");
			if($strTopic['userid'] != $IK_USER['user']['userid']){
			
				$msg_userid = '0';
				$msg_touserid = $strTopic['userid'];
				$msg_title = '你的帖子：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧';
				$msg_content = '你的帖子：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧^_^ <br /><a href="'.SITE_URL.U('group','topic',array('id'=>$topicid)).'">'.SITE_URL.U('group','topic',array('id'=>$topicid)).'</a>';
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_title,$msg_content);
				
			}
			
			
			//feed开始
			$feed_template = '<span class="pl">评论了帖子：<a href="{link}">{title}</a></span><div class="quote"><span class="inq">{content}</span> <span><a class="j a_saying_reply" href="{link}" rev="unfold">回应</a>
	</span></div>';
			$feed_data = array(
				'link'	=> SITE_URL.U('group','topic',array('id'=>$topicid)),
				'title'	=> $strTopic['title'],
				'content'	=>getsubstrutf8(htmlspecialchars($content),0,100),
			);
			aac('feed')->add($userid,$feed_template,$feed_data);
			//feed结束
			
			header("Location: ".SITE_URL.U('group','topic',array('id'=>$topicid)));
		}	
	
		break;
		
	//删除评论
	case "delete":
		
		$commentid = intval($_GET['commentid']);
		
		$strComment = $new['group']->find('group_topics_comments',array(
			'commentid'=>$commentid,
		));
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$strComment['topicid'],
		));
		
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$strTopic['groupid'],
		));
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $IK_USER['user']['isadmin']==1){
			
			$new['group']->delComment($commentid);
			
			//统计
			$db->query("update ".dbprefix."group_topics set count_comment=count_comment-1 where topicid='".$strComment['topicid']."'");
		}
		
		//跳转回到帖子页
		header("Location: ".SITE_URL.U('group','topic',array('id'=>$strComment['topicid'])));
		
		break;

}