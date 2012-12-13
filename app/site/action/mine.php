<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//加载风格
include_once 'theme.php';
include_once 'RoomFunction.php';
//个人小站
switch ($ts) {
	case "" :
		//个人小站
		$roomid = $strNavs[0]['roomid'];
		$strRoom = aac('site')->getOneRoom($roomid);
		//左侧组件
		$modsort = aac('site')->getRoomWidgetSort($roomid);

		$leftTable = explode(',',$modsort['leftmod']);
		$rightTable = explode(',',$modsort['rightmod']);
		
		$strLeftMod  = sortMod($leftTable);
		$strRightMod = sortMod($rightTable);
		
		//是否有存档
		$countAchives = aac('site')->findCount('site_archive', array('roomid'=>$roomid)); 
		//isRoomEmpty 作标记 不是room的页面全部 false
		$isRoomEmpty = 1 ;
		
		//查询是否被我关注
		$userid = $_SESSION['tsuser']['userid'];
		if($userid>0)
		{
			$ismyfollow = aac('site')->find('site_follow', array('userid'=>$userid,'follow_siteid'=>$siteid)); 
		}
		//查询喜欢该小站的成员
		$likeUsers = aac('site')->findAll('site_follow', array('follow_siteid'=>$siteid));
		$likesiteNum = 0;
		foreach($likeUsers as $key=>$item) 
		{
			$likesiteNum = $key + 1;
			$arrlikeUser[] = aac('user')->getOneUser($item['userid']);
			
		}
		$title = $strSite['sitename']."的小站";
		include template("room");
		break;

}