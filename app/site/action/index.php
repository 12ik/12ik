<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$userid = aac('user')->isLogin();

switch ($ik) {
	//我的小站
	case "" :
		//我管理的小站
		$strSites = aac('site')->findAll('site',array('userid'=>$userid), 'addtime desc', 'siteid');
		if(!empty($strSites))
		{
			foreach($strSites as $key=>$item)
			{
				$strMysite[$key] =  aac('site')->getOneSite($item['siteid']);
			}
		}

	
		//我喜欢的小站
		$arrMylikeSite = aac('site')->findAll('site_follow',array('userid'=>$userid), 'addtime desc', null, 18);
		if(!empty($arrMylikeSite))
		{
			$strMylikeSite = array();
			foreach($arrMylikeSite as $key=>$items)
			{
				$strMylikeSite[$key] = $tempsite = aac('site')->getOneSite($items['follow_siteid']);
				
				//查看已经关注的小站动态 暂时只关注日记动态
				//根据userid 获取最新发表的日记
				$contentAll = $db->fetch_all_assoc("SELECT c.*,n.siteid  FROM ".dbprefix."site_notes_content as c LEFT JOIN ".dbprefix."site_notes AS n ON  n.siteid=".$items['follow_siteid']." and c.userid=".$tempsite['userid']." and c.notesid in (n.notesid) and c.notesid>0 WHERE n.siteid is not null order by addtime desc limit 2");
				
				$arrNote = array();
				foreach($contentAll as $k=>$item)
				{
					$arrNote[] = $item;
					$strcontent = $item['content'];
					
					//匹配链接 去链接
					preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
					$strcontent, $contenturl);
					foreach($contenturl[2] as $c1)
					{	
						$strcontent = str_replace ( "[url={$c1}]", '', $strcontent);
						$strcontent = str_replace ( "[/url]", '', $strcontent);
					}
					//去图片
					$arrNote[$k]['content'] = preg_replace ( '/\[(图片)(\d+)\]/is', '', $strcontent);
					//匹配本地图片
					preg_match_all ( '/\[(图片)(\d+)\]/is', $item['content'], $photos );	
					
					if(!empty($photos [2]))
					{
						//echo $photos [2][0];
						$arrNote[$k]['photo'] = aac('site')->getPhotoByseq($item['contentid'],$photos [2][0]);
						
					}				
				}
				
				//返回数据
				$strMylikeSite[$key]['notes']  = $arrNote;

			}
		}
		
		
		
		$title = "我的小站";
		include template("index");
		break;

}