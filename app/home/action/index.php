<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//小组首页



if ($IK_USER ['user'] == '') {

	//推荐小组列表
	$arrRecommendGroups = aac ( 'group' )->getRecommendGroup ( '12' );
	foreach ( $arrRecommendGroups as $key => $item ) {
		$arrRecommendGroup [] = $item;
		$arrRecommendGroup [$key] ['groupdesc'] = getsubstrutf8 ( t ( $item ['groupdesc'] ), 0, 35 );
	}
	//最新10个小组
	$arrNewGroup = aac ( 'group' )->getNewGroup ( '10' );
	
	//最新发表日志
	$arrNewNote = aac('note')->getNewNote('15');
	//热门10个热门话题
	$arrHotTopics = aac('group')->findAll('group_topics',null,'count_comment desc','userid,topicid,title,content,count_comment,
	count_view,addtime,uptime',10);
	if( is_array($arrHotTopics)){
		foreach($arrHotTopics as $key=>$item){
			$arrHotTopic[] = $item;
			//$arrHotTopic[$key]['typename'] = $arrTopicType[$item['typeid']]['typename'];
			$arrHotTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			//$arrHotTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
			$arrHotTopic[$key]['content'] = getsubstrutf8(t($item['content']),0,50);
		}
	}
	//活跃会员
	$arrHotUser = aac('user')->getHotUser(16);
	//获取用户数
	$count_user = aac('user')->getUsers();
	
	//最新小站日志
	$arrSiteNote = aac('site')->findAll('site_notes_content',null,'addtime desc');



} else {
	
	header ( "Location: " . SITE_URL . tsUrl ( 'group' ) );

}
	/*
	//获取全部用户相册图片
	$user =  $IK_USER ['user'];
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	$lstart = $page*10-10;
	
	$url = SITE_URL.'index.php?app=photo&ac=admin&mg=photo&ts=list&page=';
	
	$arrPhoto = $db->fetch_all_assoc("select * from ".dbprefix."photo order by addtime desc limit $lstart,15");
	
	$photoNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."photo");
	$photoNum = $photoNum['count(*)'];
	*/

	
	$title = $IK_SITE ['base'] ['site_subtitle'];
	include template ( "index" );