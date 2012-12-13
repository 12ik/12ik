<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//加载风格
include_once 'theme.php';
include_once 'RoomFunction.php';

//页面
switch ($ts) {
	case "" :
		//房间显示页面
		$roomid = intval($_GET['roomid']);
		$strRoom = aac('site')->getOneRoom($roomid);
		//获取于该房间的应用
		/*$strBulletins = aac('site')->getBulletinByRoomid($roomid);
 	
		foreach($strBulletins as $key=>$item)
		{
			$str = $item['content'];
			preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
			$str, $content);
			foreach($content[2] as $c1)
			{
				$str = str_replace ( "[url={$c1}]", '<a href="'.$c1.'">', $str);
				$str = str_replace ( "[/url]", '</a>', $str);
			}
			$strBulletin[] = $item;
			$strBulletin[$key]['content'] = $str;
		}*/
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
		$title = $strRoom['name']." - ".$strSite['sitename']."的小站";
		include template("room");
		break;

}
