<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ik) {
	case "user" :
		$userid = intval ( $_GET ['userid'] );
		//获取用户信息
		$strUser = aac('user')->getOneUser($userid);
		
		if($userid == 0) header("Location: ".SITE_URL."index.php");
		
		//分页
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = SITE_URL."index.php?app=note&ac=index&ik=user&userid=".$userid."&page=";
		$lstart = $page*10-10;
		
		$arrNotes = $db->fetch_all_assoc ( "select * from " . dbprefix . "note where  `userid`='$userid' order by addtime desc limit $lstart, 10" );
		
		foreach($arrNotes as $key=>$item){
			$arrNote[] = $item;
			$arrNote[$key]['photo'] = $new['note']->getOnePhoto($item['content']);
			$arrNote[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
			$arrNote[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrNote[$key]['cate'] = $new['note']->getOneCate($item['cateid']);
		}
		
		$noteNum = $db->once_num_rows("select * from ".dbprefix."note where `userid`='$userid' ");
		$pageUrl = pagination($noteNum, 10, $page, $url);
		
		//我的日志分类
		$arrCate = aac('note')->getArrCate($userid);
		
		if($IK_USER['user']['userid'] == $userid){
			$title = '我的日志';
			$userCateName = '我的日志分类';
		}else{
			$title = $strUser['username'].'的日志';
			$userCateName = $strUser['username'].'的日志分类';
		}
		include template ( 'index' );
		break;

}

 
