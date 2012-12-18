<?php
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();


switch($ts){
	
	case "":
		
		//分类 
		$arrCate = $new['note']->getArrCate($userid);
		if ($arrCate==''){
			$db->query("insert into ".dbprefix."note_cate (`userid`,`catename`) values ('$userid','默认分类')");
		}
		
		$title = '写日志';
		include template('add');
		
		break;
		
	case "do":
		
		$cateid = $_POST['cateid'];
		$title	= htmlspecialchars(trim($_POST['title']));
		$content = $_POST['content'];
		$addtime = time();
		
		if($title=='' || $content=='') qiMsg("标题和内容都不能为空！");
		if(mb_strlen($title,'utf8')>64) tsNotice('标题很长很长很长很长...^_^');
		if(mb_strlen($content,'utf8')>50000) tsNotice('发这么多内容干啥^_^');
		
		$isphoto = 0;
		$isattach = 0;
		
		//判断是否有图片和附件
		preg_match_all('/\[(photo)=(\d+)\]/is', $content, $photo);
		if($photo[2]){
			$isphoto = '1';
		}
		//判断附件
		preg_match_all('/\[(attach)=(\d+)\]/is', $content, $attach);
		if($attach[2]){
			$isattach = '1';
		}
		
		//isaudit=0 代表审核未通过
		$db->query("insert into ".dbprefix."note (`userid`,`cateid`,`title`,`content`,`isphoto`,`isattach`,`isaudit`,`addtime`) values ('$userid','$cateid','$title','$content','$isphoto','$isattach','0','$addtime')");
		
		$noteid = $db->insert_id();
		
		//处理标签
		aac('tag')->addTag('note','noteid',$noteid,trim($_POST['tag']));
		
		header("Location: ".SITE_URL.tsUrl('note','show',array('noteid'=>$noteid)));
	
		break;
	}

