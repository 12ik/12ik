<?php

switch ($ts) {
	
	case "" :
		$robotid = $_GET ['robotid'];
		aac('robots')->delete('robots',array('robotid'=>$robotid));
		qiMsg ( "成功删除机器人" );
		break;

}
