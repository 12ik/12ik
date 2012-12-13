<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//判断用户是否登录
$userid = aac('user') -> islogin();

switch ($ts) {
	case "" :
		//创建小站
		$title = "创建小站";
		include template("new_site");
		break;
		
	case "create" :
		//开始创建
		$sitename = trim($_POST['sitename']);
		$sitedesc = trim($_POST['sitedesc']);
		//安全新检查
		if(mb_strlen($sitename,'utf8') > 15) tsNotice(mb_strlen($sitename,'utf8').'小站名称最多15个汉字或30个英文字母^_^');
		if(mb_strlen($sitename,'utf8') > 250) tsNotice(mb_strlen($sitename,'utf8').'小站描述最多250个汉字^_^');
		
		//配置文件是否需要审核 0: 未审核 1： 已审核
		$isaudit = intval($IK_APP['options']['isaudit']);
		//重复性检查
		$isSite = $db->once_fetch_assoc("select count(siteid) from ".dbprefix."site where sitename='$sitename'");
		if($isSite['count(siteid)'] > 0) tsNotice("小站名称已经存在，请更换其他名称！");
		//插入
		$arrData = array(
				'userid'	=> $userid,
				'sitename'	=> h($sitename),
				'sitedesc'	=> h($sitedesc),
				'isaudit'	=> $isaudit,
				'addtime'	=> time(),
			);
		$siteid = $db->insertArr($arrData,dbprefix.'site');
		//初始化 room
		$arrRoomData = array(
			'siteid' => $siteid,
			'userid' => $userid,
			'name' => '未命名房间',
			'addtime' => time(),
		 );
		$roomid = $db->insertArr($arrRoomData,dbprefix.'site_room');
		//初始化导航
		$NavOrderId = $db->insertArr(array('siteid'=>$siteid, 'ordertext'=>$roomid),dbprefix.'site_room_navorder');
		
		//处理标签
		aac('tag')->addTag('site','siteid',$siteid,trim($_POST['tag']));
		
		if($isaudit == '0')
		{
			$title = "提交申请成功";
			include template ( 'result' );
		}else{
			//跳转到 小站首页
		}
		break;
	

}