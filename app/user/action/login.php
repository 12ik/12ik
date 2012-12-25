<?php
defined('IN_IK') or die('Access Denied.');
//程序主体
switch($ik){
	case "":
		if(intval($IK_USER['user']['userid']) > 0) ikNotice("已经登陆啦!");
		
		//记录上次访问地址
		$jump = $_SERVER['HTTP_REFERER'];
		
		$title = '登录';
		include template("login");
		break;
	
	//执行登录
	case "do":
	
		if($IK_USER['user'] != '') header("Location: ".SITE_URL);
		
		$jump = trim($_POST['jump']);
		
		$email = trim($_POST['email']);
		
		$pwd = trim($_POST['pwd']);
		
		$cktime = $_POST['cktime'];
		
		if($email=='' || $pwd=='') ikNotice('Email和密码都不能为空！');
		
		$isEmail = $new['user']->findCount('user',array(
			'email'=>$email,
		));
		
		if($isEmail == 0) ikNotice('Email不存在，你可能还没有注册！');
		
		$strUser = $new['user']->find('user',array(
			'email'=>$email,
		));
			
		if(md5($strUser['salt'].$pwd)!==$strUser['pwd']) ikNotice('密码错误！');	
		
		//用户信息
		$userData = $new['user']->find('user_info',array(
			'email'=>$email,
		));
		
		//记住登录Cookie
		 if($cktime != ''){   
			 setcookie("ik_email",  $userData['email'], time()+$cktime,'/');   
			 setcookie("ik_uptime", $userData['uptime'], time()+$cktime,'/');
		 }
		//修改人 小麦 尝试设置cookie
		$chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789';
		for ( $i = 0; $i < 4; $i++ )
		{
			$randCode .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		setcookie("ck",$randCode,0,'/');
			
		//用户session信息
		$sessionData = array(
			'userid' => $userData['userid'],
			'username'	=> $userData['username'],
			'doname'	=> $userData['doname'],
			'areaid'	=> $userData['areaid'],
			'path'	=> $userData['path'],
			'face'	=> $userData['face'],
			'count_score'	=> $userData['count_score'],
			'isadmin'	=> $userData['isadmin'],
			'uptime'	=> $userData['uptime'],
		);
		$_SESSION['ikuser']	= $sessionData;
		
		//用户userid
		$userid = $userData['userid'];
		
		//积分记录
		$new['user']->create('user_scores',array(
			'userid'=>$userid,
			'scorename'=>'登录',
			'score'=>'10',
			'addtime'=>time(),
		));
		
		//一天之内登录只算一次积分
		if($strDate['uptime'] < strtotime(date('Y-m-d'))){
			//积分记录
			$new['user']->create('user_scores',array(
				'userid'=>$userid,
				'scorename'=>'登录',
				'score'=>'10',
				'addtime'=>time(),
			));
		}
		
		$strScore = $new['user']->find('user_scores',array(
			'userid'=>$userid,
		),'sum(score) score');
		
		//更新积分
		$new['user']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'count_score'=>$strScore['score'],
		));
		
		//更新登录时间
		$new['user']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'uptime'=>time(),
			'count_score'=>$strScore['score'],
		));

		//跳转
		if($jump != ''){
			header("Location: ".$jump);
		}else{
			header('Location: '.SITE_URL);
		}
		
		break;
	
	//退出	
	case "out":
				
		session_destroy();
		//记住登录用户名
		//setcookie("ik_email", '', time()+3600,'/');   
		setcookie("ik_pwd", '', time()+3600,'/');
		//ck
		setcookie("ck", '', time()+3600,'/');

		header('Location: '.SITE_URL.ikUrl('user','login'));
		
		break;
}