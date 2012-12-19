<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ts) {
	case "" :
		$arrArticles = aac('article')->getAllArticle();
		foreach($arrArticles as $key=>$item)
		{
			$arrArticle[] = $item;
			$arrArticle[$key]['items'] = aac('article')->find('article_spaceitems',array('itemid'=>$item['itemid']));
		}
		
		include template ( 'index' );
		break;

}

 
