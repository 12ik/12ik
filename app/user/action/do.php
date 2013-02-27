<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	
	//设置头像
	case "setface":

		//上传
		$arrUpload = ikUpload($_FILES['picfile'],$userid,'user/face',array('jpg','gif','png'));
		
		if($arrUpload){

			$new['user']->update('user_info',array(
				'userid'=>$userid,
			),array(
				'path'=>'face/'.$arrUpload['path'],
				'face'=>'face/'.$arrUpload['url'],
			));
			
			//清除缓存图片
			ClearAppCache($app.'/face/'.$arrUpload['path']);

			
			ikNotice("头像修改成功！","点击返回",$_SERVER['HTTP_REFERER']);
			
		}else{
			ikNotice("上传出问题啦！");
		}

		break;
	
	//基本信息设置
	case "setbase":

		$strUser = $db->once_fetch_assoc("select username from ".dbprefix."user_info where userid='$userid'");
		$username = t($_POST['username']);

		if($IK_USER['user'] == '') ikNotice("机房重地，闲人免进！");
		if($username == '') ikNotice("不管做什么都需要有一个名号吧^_^");
		if(mb_strlen($username,'utf8') < 2 || mb_strlen($username,'utf8') > 14) ikNotice("名字长度必须在 2 到 14 汉字之间!");
		
		if($username != $strUser['username']){
			$isusername = $db->once_num_rows("select * from ".dbprefix."user_info where username='$username'");
			if($isusername > 0) ikNotice("用户名已经存在，请换个用户名！");
		}
		
		//更新数据
		$new['user']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'username' => $username,
			'sex'	=> $_POST['sex'],
			'signed'		=> h($_POST['signed']),
			'phone'	=> t($_POST['phone']),
			'blog'			=> t($_POST['blog']),
			'about'			=> h($_POST['about']),
		));

		ikNotice("基本资料更新成功！");

		break;
		
	//修改常居地
	case "setcity":
		
		$oneid = intval($_POST['oneid']);
		$twoid = intval($_POST['twoid']);
		$threeid = intval($_POST['threeid']);
		
		if($oneid != 0 && $twoid==0 && $threeid==0){
			$areaid = $oneid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid==0){
			$areaid = $twoid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid!=0){
			$areaid = $threeid;
		}else{
			$areaid = 0;
		}

		$db->query("update ".dbprefix."user_info set `areaid`='$areaid' where userid='$userid'");
		
		$_SESSION['ikuser']['areaid'] = $areaid;

		ikNotice("常居地更新成功！");
		
		break;
		
	//修改用户密码 
	case "setpwd":
		
		$userid = intval($IK_USER['user']['userid']);
		
		if($userid == 0) ikNotice('你应该出发去火星报到啦。');
		
		$oldpwd = trim($_POST['oldpwd']);
		$newpwd = trim($_POST['newpwd']);
		$renewpwd = trim($_POST['renewpwd']);
		
		if($oldpwd == '' || $newpwd=='' || $renewpwd=='') ikNotice("所有项都不能为空！");
		
		$strUser = $new['user']->find('user',array(
			'userid'=>$userid,
		));
		
		if(md5($strUser['salt'].$oldpwd) != $strUser['pwd']) ikNotice("旧密码输入有误！");
		
		if($newpwd != $renewpwd) ikNotice('两次输入新密码密码不一样！');
		
		//更新密码
		$salt = md5(rand());
		
		$new['user']->update('user',array(
			'pwd'=>md5($salt.$newpwd),
			'salt'=>$salt
		),array(
			'userid'=>$userid
		));
		
		ikNotice("密码修改成功！");
		
		break;
	
	//用户跟随
	case "user_follow":
	
		$userid_follow = intval($_GET['userid_follow']);

		if($userid_follow==0){
			header("Location: ".SITE_URL);
			exit;
		}
		
		$new['user']->isUser($userid_follow);
		
		$followNum = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid' and userid_follow='$userid_follow'");
		
		if($followNum > '0'){
			
			ikNotice("请不要重复关注同一用户！");
			
		}else{
			
			$db->query("insert into ".dbprefix."user_follow (`userid`,`userid_follow`,`addtime`) values ('$userid','$userid_follow','".time()."')");
			
			//统计更新跟随和被跟随数
			//统计自己的
			$count_follow = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid'");
			$count_followed = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid'");
			
			$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow',`count_followed`='$count_followed' where userid='$userid'");
			
			//统计别人的
			$count_follow_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid_follow'");
			$count_followed_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid_follow'");
			
			$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow_userid',`count_followed`='$count_followed_userid' where userid='$userid_follow'");
			
			//发送系统消息
			$strdoname = aac('user')->find('user_info',array('userid'=>$userid));
			$msg_userid = '0';
			$msg_touserid = $userid_follow;
			$msg_title = '恭喜，您被人跟随啦！看看他是谁吧';
			$msg_content = '恭喜，您被人跟随啦！看看他是谁吧<br />'.SITE_URL.U('hi','',array('id'=>$strdoname['doname']));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_title,$msg_content);
			
			$strUser = $db->once_fetch_assoc("select userid,username,path,face from ".dbprefix."user_info where `userid`='$userid_follow'");
			
			//feed开始
			$feed_template = '<a href="{link}"><img title="{username}" alt="{username}" src="{face}" class="broadimg"></a>
			<span class="pl">关注<a href="{link}">{username}</a></span>';
			
			$strdoname = aac('user')->find('user_info',array('userid'=>$userid_follow));
			$feed_data = array(
				'link'	=> SITE_URL.U('hi','',array('id'=>$strdoname['doname'])),
				'username'	=> $strUser['username'],
			);
			
			if($strUser['face']!=''){
				$feed_data['face'] = SITE_URL.ikXimg($strUser['face'],'user',48,48,$strUser['path']);
			}else{
				$feed_data['face'] = SITE_URL.'public/images/user_normal.jpg';
			}
			
			aac('feed')->add($userid,$feed_template,serialize($feed_data));
			//feed结束
			
			
			$strdoname = aac('user')->find('user_info',array('userid'=>$userid_follow));

			header("Location: ".SITE_URL.U('hi','',array('id'=>$strdoname['doname'])));
			
		}
		
		break;
	
	//用户取消跟随 
	case "user_nofollow":
		
		$userid_follow = $_GET['userid_follow'];
		
		$db->query("DELETE FROM ".dbprefix."user_follow WHERE userid = '$userid' AND userid_follow = '$userid_follow'");
		
		//统计更新跟随和被跟随数
		//统计自己的
		$count_follow = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid'");
		$count_followed = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid'");
		
		$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow',`count_followed`='$count_followed' where userid='$userid'");
		
		//统计别人的
		$count_follow_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid_follow'");
		$count_followed_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid_follow'");
		
		$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow_userid',`count_followed`='$count_followed_userid' where userid='$userid_follow'");
		
		$strdoname = aac('user')->find('user_info',array('userid'=>$userid_follow));
		header("Location: ".SITE_URL.U('hi','',array('id'=>$strdoname['doname'])));
		
		break;
		
	//用户取消跟随 
	case "user_nofollow_ajax":
		
		$userid_follow = $_POST['userid_follow'];
		
		$db->query("DELETE FROM ".dbprefix."user_follow WHERE userid = '$userid' AND userid_follow = '$userid_follow'");
		
		//统计更新跟随和被跟随数
		//统计自己的
		$count_follow = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid'");
		$count_followed = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid'");
		
		$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow',`count_followed`='$count_followed' where userid='$userid'");
		
		//统计别人的
		$count_follow_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid_follow'");
		$count_followed_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid_follow'");
		
		$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow_userid',`count_followed`='$count_followed_userid' where userid='$userid_follow'");
		
		$arrJson = array('r'=>0, 'html'=>'update  success');
		header("Content-Type: application/json", true);
		echo json_encode($arrJson); 	
		
		break;	
		
	//个性域名修改	
	case "setdoname":
		
		$doname = trim($_POST['doname']);
		if(empty($doname))
		{
		  ikNotice("个性域名不能为空！");
		}else if(strlen($doname)<2)
		{
		  ikNotice("个性域名至少要2位数字、字母、或下划线(_)组成！");	
		  
		}else if(!preg_match ( '/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*$/', $doname ))
		{
		   ikNotice("个性域名必须是数字、字母或下划线(_)组成！");	
		}
		$ishave = aac('user')->haveDoname($doname);
		if($ishave)
		{
			ikNotice("该域名已经被其他人抢注了,请试试别的吧！");
		}else{
			aac('user')->update('user_info',array('userid'=>$userid), array('doname'=>$doname));
			ikNotice("个性域名修改成功！");
		}
		break;
}
