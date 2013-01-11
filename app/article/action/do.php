<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

//用户是否登录
$userid = aac('user')->isLogin();

switch ($ik) {
	case "post" :
		//发布页面
		//获取资讯分类
		$arrChannel = aac('article')->findAll('article_channels');
		$arrSelect = '';//初始化下拉列表
		$arrCatename = array();
		foreach ($arrChannel as $key=>$item)
		{
			$arrCatename = aac('article')->findAll('article_categories',array('type'=>$item['nameid']));
			$arrSelect .='<optgroup label="'.$item['name'].'">';
			foreach($arrCatename as $key1=>$item1)
			{
				
				$arrSelect .='<option  value="'.$item1['type'].'_'.$item1['catid'].'" >'.$item1['name'].'</option>';
				
			}
			$arrSelect .='</optgroup>';

		}
		
		$title = "发表新文章";
		include template ( 'post' );
		break;
		
	case "add":
		//添加
		$title = "发表新文章";
		//include template ( 'post' );
		break;	
		
	case "add_photo":
		$itemid  = $_POST['itemid'];
		$arrJson = array('r'=>1, 'html'=>'上传图片失败，请重新上传吧！'.$itemid);
		echo json_encode($arrJson); 
					
		break;				
}

 

