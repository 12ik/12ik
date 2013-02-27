<?php
defined('IN_IK') or die('Access Denied.');

$title = '找回登陆密码';


switch($ik){

	case "":

		include template("forgetpwd");

		break;
	
	//执行登录
	case "do":
	
		$email	= trim($_POST['email']);
		
		$emailNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."user where `email`='$email'");
		
		if($email==''){
			ikNotice('Email输入不能为空^_^');
		}elseif($emailNum['count(*)'] == '0'){
			ikNotice("Email不存在，你可能还没有注册^_^");
		}else{
		
			//随机MD5加密
			$resetpwd = md5(rand());
		
			$db->query("update ".dbprefix."user set resetpwd='$resetpwd' where email='$email'");
			
			//发送邮件
			$subject = $IK_SITE['base']['site_title'].'会员密码找回';
			
			$content = '您的登陆信息：<br />Email：'.$email.'<br />重设密码链接：<br /><a href="'.$IK_SITE['base']['site_url'].'index.php?app=user&a=resetpwd&mail='.$email.'&set='.$resetpwd.'">'.$IK_SITE['base']['site_url'].'index.php?app=user&a=resetpwd&mail='.$email.'&set='.$resetpwd.'</a>';
			
			$result = aac('mail')->postMail($email,$subject,$content);
			
			if($result == '0'){
				ikNotice("找回密码所需信息不完整^_^");
			}elseif($result == '1'){
				ikNotice("系统已经向你的邮箱发送了邮件，请尽快查收^_^");
			}
			
		}
		
		break;
		
}