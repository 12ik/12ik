<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
switch ($ik) {
	case "" :
		//分页
		$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : '0';
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = SITE_URL.U('article','list',array('cateid'=>$cateid,'page'=>''));
		$lstart = $page*15-15;
		if($cateid == 0)
		{
			$arrArticles = aac('article')->findAll('article_spaceitems',null,'dateline desc',null,$lstart.',15');
			$artNum =  aac('article')->findCount('article_spaceitems');
			$title = '文章 - 第'.$page.'页';
		}else{
		    $arrArticles = aac('article')->findAll('article_spaceitems',array('catid'=>$cateid),'dateline desc',null,$lstart.',15');
			$artNum =  aac('article')->findCount('article_spaceitems',array('catid'=>$cateid));
			$Cate = aac('article')->find('article_categories',array('catid'=>$cateid),'name');
			$title = $Cate['name'].' - 第'.$page.'页';
		}
		foreach($arrArticles as $key=>$item)
		{
			$arrArticle[] = $item;
			$arrArticle[$key]['news'] = aac('article')->find('article_spacenews',array('itemid'=>$item['itemid']));
			if($item['haveattach']==1)
			{
				//$arrArticle[$key]['attach'] = aac('article')->find('attachments',array('itemid'=>$item['itemid']));
				$arrAttach = aac('article')->find('attachments',array('itemid'=>$item['itemid']));

				$arrpath = explode('/', $arrAttach['filepath']);
				$path = '';
				for($i=0; $i<count($arrpath)-1; $i++)
				{
					$path .= $arrpath[$i].'/'; 
				}
				$pathdir = substr($path, 0,strlen($path)-1);
				$pathurl = $arrAttach['filepath'];
				
				$arrArticle[$key]['attach'] = SITE_URL.ikXimg($pathurl,'attachments',120,90,$path,1);	
			}
		}

		
		$pageUrl = pagination($artNum, 15, $page, $url);
		
		//获取分类
		$arrCate = aac('article')->findAll('article_categories');
		
		include template ( 'index' );
		break;
	
}

 
