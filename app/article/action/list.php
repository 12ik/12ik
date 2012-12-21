<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
switch ($ts) {
	case "" :
		//分页
		$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : '0';
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = SITE_URL.tsUrl('article','list',array('cateid'=>$cateid,'page'=>''));
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
				$arrArticle[$key]['attach'] = aac('article')->find('attachments',array('itemid'=>$item['itemid']));
			}
		}

		
		$pageUrl = pagination($artNum, 15, $page, $url);
		
		//获取分类
		$arrCate = aac('article')->findAll('article_categories');
		
		include template ( 'index' );
		break;
	
}

 
