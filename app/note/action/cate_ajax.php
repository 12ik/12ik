<?php 
defined('IN_IK') or die('Access Denied.');
//用户是否登录
$userid = aac('user')->isLogin();

switch($ik){
	case "":
		
		$catename = $_GET['catename'];

		
		include template("add_ajax");
		break;
		
	case "add":
	
		$catename = t($_POST['catename']);
		
		if($userid == '0'){
			echo 0;
		}elseif(empty($catename)){
			echo 1;
		}else{
			$db->query("insert into ".dbprefix."note_cate (`userid`,`catename`) values ('".$userid."','".$catename."')");
			$arrCate = $new['note']->getArrCate($userid);
			
			header("Content-Type: application/json", true);
	        echo json_encode($arrCate);
		}
	
		break;
	case 'update':
		$catename = t($_POST['catename']);
		$cateid = intval($_POST['cateid']);
		if($userid == '0'){
			echo 0;//未登录
		}else if(empty($catename) || mb_strlen($catename,'utf8')>16)
		{
			echo 1;//为空或长度太长
		}else{
			//执行update
			$arrData = array('catename'=>$catename);
			$new['note']->update('note_cate',array(
				'cateid'=>$cateid
			),$arrData);
			//根据cateid获取分类名称
			$strCate = $new['note']->getOneCate($cateid);
			header("Content-type: application/json", true);
			echo json_encode($strCate);
		}
		break;
}