<?php 
defined('IN_IK') or die('Access Denied.');

switch($ik){
	
	case "list";
	$cateid = intval($_GET['cateid']);

	//列表 
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$url = SITE_URL.U('note','cate',array('ik'=>'list','cateid'=>$cateid,'page'=>''));
	$lstart = $page*10-10;
	
	$arrNotes = $db->fetch_all_assoc("select * from ".dbprefix."note where `cateid`='$cateid' and `isaudit`='0' order by addtime desc limit $lstart, 10");
	
	$articleNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."note where `cateid`='$cateid'");
	
	$pageUrl = pagination($articleNum['count(*)'], 10, $page, $url);
	
	foreach($arrNotes as $key=>$item){
		$arrNote[] = $item;
		$arrNote[$key]['photo'] = $new['note']->getOnePhoto($item['content']);
		$arrNote[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
		$arrNote[$key]['user'] = aac('user')->getOneUser($item['userid']);
	}
	//根据用户获取文章分类 
	$strCate = $new['note']->getOneCate($cateid);
    $userid = $strCate['userid'];
    $arrCate = $new['note']->getArrCate($userid);
	
	$title = $strCate['catename'];
	
	include template('cate_list');
	break;
	
	case "edit";
	$userid = aac('user')->isLogin();
	//根据用户获取文章分类 
	$arrCate = $new['note']->getArrCate($userid);
	
	$title = "分类管理";
	include template('edit_cate');
	break;
	
}