<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ts) {
	case "" :
		$arrArticles = aac('article')->getAllArticle();
		foreach($arrArticles as $key=>$item)
		{
			$arrArticle[] = $item;
			$arrArticle[$key]['items'] = aac('article')->find('article_spaceitems',array('itemid'=>$item['itemid']));
			if($arrArticle[$key]['items']['haveattach']==1)
			{
				$arrArticle[$key]['items']['attach'] = aac('article')->find('attachments',array('itemid'=>$item['itemid']));
			}
		}
		//获取分类
		$arrCate = aac('article')->findAll('article_categories');
		$title = '最新文章';
		include template ( 'index' );
		break;

}

 
