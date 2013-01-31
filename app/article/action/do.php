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
		//预添加一行数据
		$strLast= aac('article')->find('article_spaceitems',array('uid'=>$userid, 'catid'=>0));
		if($strLast['itemid']>0)
		{
			$itemid = $strLast['itemid'];
			
		}else{
			$itemid = aac('article')->create('article_spaceitems',
				array('uid'=>$userid, 'catid'=>0,'subject'=>'0')
			);
		}
		
		$title = "发表新文章";
		include template ( 'post' );
		break;
		
	case "update":
		//添加
		$title = trim($_POST['title']);
		$itemid = $_POST['itemid'];
		$catarr = explode('_', $_POST['import']); //分类
		$cateid = $catarr[1];
		$type = $catarr[0]; //分类别名
		$content = trim($_POST['content']);
		
		if($title==''){
			ikNotice('不要这么偷懒嘛，多少请写一点内容哦^_^');
			
		}elseif($content==''){

			ikNotice('没有任何内容是不允许你通过滴^_^');
			
		}elseif($cateid == ''){
			
			ikNotice('请选择一个分类再发表吧^_^');
			
		}elseif(mb_strlen($title,'utf8')>64){//限制发表内容多长度，默认为30
			
		 	ikNotice('标题很长很长很长很长...^_^');
		
		}elseif(mb_strlen($content,'utf8')>20000){//限制发表内容多长度，默认为1w
			
		 	ikNotice('发这么多内容干啥^_^');
		
		}else{
			$arrItemData = array(
				'subject'		=> htmlspecialchars($title),
				'catid'		=> $cateid,
				'type'		=> $type,
				'username'  => $_SESSION['ikuser']['username'],

				//'isvideo'		=> $isvideo,
				//'iscomment'		=> $iscomment,
				'dateline'		=> time()
			);
			$arrNewsData = array(
				'itemid'		=> $itemid,
				'message'		=> $content,
			);			
			//执行更新
			aac('article')->update('article_spaceitems', array('uid'=>$userid, 'itemid'=>$itemid),$arrItemData);
			//插入数据
			$nid = aac('article')->create('article_spacenews',$arrNewsData);
			
			if($nid>0)
			{
				header("Location: ".SITE_URL.ikUrl('article','show',array('id'=>$nid)));
			}
			
		}			

		break;	
		
	case "add_photo":
		$itemid  = $_POST['itemid'];
		$arrJson = array('r'=>1, 'html'=>'上传图片失败，请重新上传吧！'.$itemid);
		echo json_encode($arrJson); 
					
		break;				
}

 

