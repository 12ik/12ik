<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
$strUser = aac('user')->getOneUser($userid);

//邀请好友
switch($ts){
	
	case "invite":
	
	$title = '爱客网邀请';
	include template("email_invite");
	
	break;
	
	case "sendmail":
	$emails  = trim($_POST['emails']);
	$emails  =  str_replace ( '，', ',', $emails);
	$stremail = explode("," , $emails);
	$message = t(trim($_POST['message']));
	

	
	if($emails==''){
		$msg = '<p class="attn" style="margin:5px 0px">请输入至少一个完整的Email地址！</p>';
	}else if(valid_email($stremail[0]) == false)
	{
		$msg = '<p class="attn" style="margin:5px 0px">Email邮箱输入有误！</p>';
	}else{
		
		foreach($stremail as $key=>$item)
		{
			
			//生成tomail加密
			$saltmail = substr(md5($item),8,16);	//16位加密
			//发送邮件
			$subject = '你的朋友'.$strUser['username'].'邀请你来爱客网';
			$inviteurl = SITE_URL.tsUrl('user','invited',array('confirmation'=>$saltmail));
			$content = '爱客网站的成员'.$strUser['username'].'('.$strUser['email'].')邀请您去看看，<br/>'.$message.'<br/>请点击以下链接接受邀请加入我们：<br/>(Your friend at '.$strUser['email'].' invites you to join him/her at 12ik.com. Please click this link to accept the invitation:)
	<a href="'.$inviteurl.'">'.$inviteurl.'</a><br/>如果您愿意先去随便逛逛，点<a href="http://www.12ik.com">http://www.12ik.com</a> 。你的朋友的爱客主页在 '.SITE_URL.tsUrl('hi','',array('id'=>$strUser['doname'])).' 。想注册请直接用以上链接，这样你和小麦狼会自动加入彼此的友邻行列。<br/>
	如果您的email程序不支持链接点击，请将上面的地址拷贝至您的浏览器(例如IE)的地址栏进入爱客网。<br/>
	希望您在爱客网的体验有益和愉快。<br/>----爱客网<br/>(这是一封自动产生的email，请勿回复。)';	
	
			//判断是否已经被注册
			$ishave = aac('user')->find('user',array('email'=>$item));
			if(empty($ishave))
			{
				$result = aac('mail')->postMail($stremail[0],$subject,$content);
				if($result == '1')
				{
					aac('user')->create('user_invited',array(
										'userid'=>$userid,
										'invitemail'=>$stremail[0],
										'saltmail'=>$saltmail,
										'addtime'=>time(),
										));			
					$msg = '<p class="inviteok" style="margin:8px 0px">邀请已经成功发出，继续邀请？</p>';
				}				
				
			}

		}

	}
	
	$title = '爱客网邀请';
	include template("email_invite");
	break;

}