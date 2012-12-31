<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	
	//编辑帖子
	case "":
		$topicid = $topic_id = intval($_GET['topicid']);

		if($topicid == 0){
			header("Location: ".SITE_URL);
			exit;
		}

		$topicNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."group_topics where `topicid`='$topicid'");

		if($topicNum['count(*)']==0){
			header("Location: ".SITE_URL);
			exit;
		}



		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where `topicid`='".$topicid."'");

		$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where `groupid`='".$strTopic['groupid']."'");

		if($strTopic['userid'] == $userid || $strGroup['userid']==$userid || $IK_USER['user']['isadmin']==1){

		
		//浏览该topic_id下的照片
		$arrPhotos = aac('group')->getPhotosByTopicid($userid, $topic_id);
		//浏览视频
		$arrVideos = aac('group')->findAll('videos',array('typeid'=>$topic_id, 'type'=>'topic'));
		

		//帖子类型
	    $arrGroupType = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_type where `groupid`='".$strGroup['groupid']."'");

			$title = '编辑帖子';

			include template("topic_edit");
			
		}else{

			header("Location: ".SITE_URL);
			exit;

		}
		break;
		
	//编辑帖子执行	
	case "do":
	
		$topicid = $_POST['topicid'];
		
		$title = trim($_POST['title']);
		
	 	//$typeid = $_POST['typeid']; //帖子类型
		
		$content = trim($_POST['content']);
		
		$iscomment = $_POST['iscomment'];
		
		if($topicid == '' || $title=='' || $content=='') ikNotice("都不能为空的哦!");
		
		if($title==''){
			ikNotice('不要这么偷懒嘛，多少请写一点内容哦^_^');
			
		}elseif($content==''){

			ikNotice('没有任何内容是不允许你通过滴^_^');
			
		}elseif(mb_strlen($title,'utf8')>64){//限制发表内容多长度，默认为30
			
		 	ikNotice('标题很长很长很长很长...^_^');
		
		}elseif(mb_strlen($content,'utf8')>20000){//限制发表内容多长度，默认为1w
			
		 	ikNotice('发这么多内容干啥^_^');
		
		}
		
		//编辑帖子标签
		doAction('group_topic_edit',$title,$content);
		
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='".$topicid."'");
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='".$strTopic['groupid']."'");
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $IK_USER['user']['isadmin']==1){
		
			$arrData = array(
				//'typeid' => $typeid,
				'title'			=> htmlspecialchars($title),
				'content'		=> htmlspecialchars($content),
				'iscomment' => $iscomment,
			);

			$new['group']->update('group_topics',array(
				'topicid'=>$topicid,
			),$arrData);
			
			//浏览该noteid下的照片
			$arrPhotos = aac('group')->getPhotosByTopicid($userid, $topicid);
			//执行更新图片***********************************************//
			if(!empty($arrPhotos))
			{
				
				foreach($arrPhotos as $key=>$item)
				{
					$photo_seqid = intval($_POST['p_'.$item['seqid'].'_seqid']); 
					$photodesc   = $_POST['p_'.$item['seqid'].'_title'];
					$photo_align = $_POST['p_'.$item['seqid'].'_layout'];
					if($photo_seqid > 0)
					{
						//存在表单 开始执行更新
						$arrData = array(
							'photodesc'	=> $photodesc,
							'align' => $photo_align,
						);	
						
						aac('group')->update('group_topics_photo',array('topicid'=>$topicid,'seqid'=>$photo_seqid), $arrData);						
					}				
				}
			}
			////////////////////////////////////////////////////////////				
			
		

			header("Location: ".SITE_URL.ikUrl('group','topic',array('id'=>$topicid)));
			
		}else{
			header("Location: ".SITE_URL);
			exit;
		}
		break;

}