<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	
	//添加feed
	case "do":
	
		$content	= trim($_POST['content']);

		if($content==''){

			ikNotice('不要这么偷懒嘛，多少请写一点内容哦^_^');
			
		}elseif(mb_strlen($content,'utf8')>100){//限制发表内容多长度，默认为1w
			
		 	ikNotice('发这么多内容干啥^_^');
		
		}else{
			
			//feed开始
			$feed_template = '<span class="pl">说：</span><div class="quote"><span class="inq">{content}</span> <span></span></div>';
			$feed_data = array(
				//'link'	=> SITE_URL.ikUrl('group','topic',array('id'=>$topicid)),
				//'title'	=> $strTopic['title'],
				'content'	=>getsubstrutf8(htmlspecialchars($content),0,100),
			);
			aac('feed')->add($userid,$feed_template,$feed_data);
			//feed结束
		
		
			header("Location: ".SITE_URL.ikUrl('feed','index'));
			
		}
	
		break;

}