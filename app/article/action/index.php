<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );


switch ($ts) {
	case "" :
		$arrArticle = aac('article')->getAllArticle();
		include template ( 'index' );
		break;

}

 
