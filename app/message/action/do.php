<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
$messageid = empty($_POST['messageid']) ? $_GET['messageid'] : $_POST['messageid'];


switch($ik){

	//删除
	case "del":
		if($_GET['type']=='inbox')
		{
			$status = aac('message')->update('message',array('touserid'=>$userid,'messageid'=>$messageid),array('isinbox'=>1));
		}
		if($_GET['type']=='outbox')
		{
			$status = aac('message')->update('message',array('userid'=>$userid,'messageid'=>$messageid),array('isoutbox'=>1));
		}		
		header("Location: ".$_SERVER['HTTP_REFERER']);
	break;
	
	case "spam":
		$status = aac('message')->update('message',array('messageid'=>$messageid,'touserid'=>$userid),array('isspam'=>1));
		header("Location: ".SITE_URL.U('message','ikmail',array('ik'=>'spam')));
	break;	

	case "all":
		if(trim($_POST['mc_submit'])=='删除' && $_POST['type']=='inbox')
		{
			for($i=0; $i<count($messageid); $i++)
			{	
				aac('message')->update('message',array('touserid'=>$userid,'messageid'=>$messageid[$i]),array('isinbox'=>1));
			}
			//删除
			aac('message')->delete('message',array('isinbox'=>'1','isoutbox'=>'1'));	
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		if(trim($_POST['mc_submit'])=='删除' && $_POST['type']=='outbox')
		{
			for($i=0; $i<count($messageid); $i++)
			{	
				aac('message')->update('message',array('userid'=>$userid,'messageid'=>$messageid[$i]),array('isoutbox'=>1));					
			}
			//删除
			aac('message')->delete('message',array('isinbox'=>'1','isoutbox'=>'1'));	
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}		
		if(trim($_POST['mc_submit'])=='垃圾消息')
		{
			for($i=0; $i<count($messageid); $i++)
			{
				aac('message')->update('message',array('messageid'=>$messageid[$i],'touserid'=>$userid),array('isspam'=>1));
			}
			header("Location: ".SITE_URL.U('message','ikmail',array('ik'=>'spam')));
		}
		if(trim($_POST['mc_submit'])=='标记为已读')
		{
			for($i=0; $i<count($messageid); $i++)
			{
				aac('message')->update('message',array('messageid'=>$messageid[$i],'touserid'=>$userid),array('isread'=>1));
			}
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}		
		
	break;		
}

