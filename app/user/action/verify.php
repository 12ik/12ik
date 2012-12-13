<?php 
//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
	//发送验证
	case "post":

		$strUser = $db->once_fetch_assoc("select username,email,isverify,verifycode from ".dbprefix."user_info where userid='$userid'");

		if($strUser['verifycode']==''){
			$verifycode = random(11);
			$db->query("update ".dbprefix."user_info set `verifycode`='$verifycode' where `userid`='$userid'");
		}else{
			$verifycode = $strUser['verifycode'];
		}

		$email = $strUser['email'];

		//发送邮件
		$subject = $IK_SITE['base']['site_title'].'会员真实性验证';
		$content = '尊敬的'.$strUser['username'].'，<br />请点击以下链接进行会员验证：<a href="'.$IK_SITE['base']['site_url'].'index.php?app=user&ac=verify&ts=do&email='.$email.'&verifycode='.$verifycode.'">'.$IK_SITE['base']['site_url'].'index.php?app=user&ac=verify&ts=do&email='.$email.'&verifycode='.$verifycode.'</a>';

		$result = aac('mail')->postMail($email,$subject,$content);

		if($result == '0'){
			tsNotice("验证失败，可能是你的Email邮箱错误哦^_^");
		}elseif($result == '1'){
			tsNotice("系统已经向你的邮箱发送了验证邮件，请尽快查收^_^");
		}
		break;
		
	//接收验证 
	case "do":
		$email = $_GET['email'];
		$verifycode = $_GET['verifycode'];
		
		$verify = $db->once_fetch_assoc("select count(*) from ".dbprefix."user_info where `email`='$email' and `verifycode`='$verifycode'");
		
		if($verify['count(*)'] > 0){
			$db->query("update ".dbprefix."user_info set `isverify`='1' where `email`='$email'");
			tsNotice("Email验证成功！点击返回首页！",'点击回首页！',SITE_URL);
		}else{
			tsNotice("Email验证失败！");
		}
		
		break;
}