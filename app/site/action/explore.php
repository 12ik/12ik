<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ts) {
	case "site" :
		//发现更多小站
		//分页
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = SITE_URL."index.php?app=site&ac=explore&ts=site&page=";
		$lstart = $page*10-10;
		
		$arrSites = $db->fetch_all_assoc ( "select * from " . dbprefix . "site order by addtime desc limit $lstart, 10" );
		
		foreach($arrSites as $key=>$item){
			//$arrSite[] = $item;
			//$arrSite[$key]['sitedesc'] = getsubstrutf8(t($item['sitedesc']),0,30);
			$arrSite[] = aac('site')->getOneSite($item['siteid']);
		}
		//最新推荐小站
		$recommendSite = aac('site')->getRecommendSite(5);
		$recommendSites = array();
		if($recommendSite)
		{
			foreach($recommendSite as $key=>$item)
			{
				$recommendSites[] = $item;
				$recommendSites[$key]['likenum'] = 	aac('site')->findCount('site_follow', array('follow_siteid'=>$item['siteid']));
			}
		}
		
		$title = "发现小站";
		include template("site");
		break;
	
	//根据tag ajax 加载 小站
	case "tag" :
		$tagname = urldecode(trim($_POST['tagname']));
		$tagid = aac('tag')->getTagId(t($tagname));
		$strTag = $db->once_fetch_assoc("select * from ".dbprefix."tag where tagid='$tagid'");
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$lstart = $page*10-10;
		$arrTagId = $db->fetch_all_assoc("select * from ".dbprefix."tag_site_index where tagid='$tagid' limit $lstart,10");
		
		$site_num = $db->once_fetch_assoc("select count(siteid) from ".dbprefix."tag_site_index where tagid='$tagid'");
		
		$url = SITE_URL.tsUrl('site','site_tag',array('siteid'=>$siteid,'page'=>''));
		
		foreach($arrTagId as $item){
			$arrSites[] = aac('site')->getOneSite($item['siteid']);
		}
		foreach($arrSites as $key=>$item){
			$arrSite[] = $item;
			$arrSite[$key]['url'] = SITE_URL.tsUrl('site','mine',array('siteid'=>$item[siteid]) );
			$arrSite[$key]['sitedesc'] = getsubstrutf8(t($item['sitedesc']),0,30);
			$arrSite[$key]['tagname'] = $tagname;
			$arrSite[$key]['page'] =  @ceil($site_num['count(siteid)']/10) ;
		}
		
		echo json_encode($arrSite);
		break;

}