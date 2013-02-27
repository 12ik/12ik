<?php
//创建小组
defined('IN_IK') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();


switch($ik){
	
	case "":
	
		//先判断加入多少个小组啦 
		$userGroupNum = $new['group']->findCount('group_users',array('userid'=>$userid));
		
		if($userGroupNum >= 20) ikNotice('你加入的小组总数已经到达20个，不能再创建小组！');
		
		if($IK_APP['options']['iscreate'] == 0 || $IK_USER['user']['isadmin']==1){
		
			$title = '创建小组';

			include template("create");
		
		}else{
		
			ikNotice('系统不允许会员创建小组！');
		
		}
	

	
		break;
	
	
	//执行创建小组
	case "do":
	
		if($IK_APP['options']['iscreate'] == 0 || $IK_USER['user']['isadmin']==1){
	
			if($_POST['grp_agreement'] != 1) ikNotice('不同意社区指导原则是不允许创建小组的！');
			
			if($_POST['groupname']=='' || $_POST['groupdesc']=='') ikNotice('小组名称和介绍不能为空！');
			
			//配置文件是否需要审核
			$isaudit = intval($IK_APP['options']['isaudit']);
			
			$groupname = t($_POST['groupname']);
			$groupdesc = trim($_POST['groupdesc']);
			
			$tags = trim($_POST['tag']);
			$tags = str_replace(' ',' ',$tags);
			$arrtag = explode(' ',$tags);
			
			if( mb_strlen($groupname,'utf8')>20)
			{
				ikNotice('小组名称太长啦，最多20个字...^_^！');
				
			}else if( mb_strlen($groupdesc, 'utf8') > 10000)
			{
				ikNotice('写这么多内容干啥，超出1万个字了都^_^');
			}else if(count($arrtag)>5)
			{
				ikNotice('最多 5 个标签，写的太多了...^_^！');
			}
			for($i=0; $i<count($arrtag); $i++)
			{
				if(mb_strlen($arrtag[$i], 'utf8') > 8)
				{
				  ikNotice('小组标签太长啦，最多8个字...^_^！');
				}
			}
			
			$isGroup = $db->once_fetch_assoc("select count(groupid) from ".dbprefix."group where groupname='$groupname'");
			
			if($isGroup['count(groupid)'] > 0) ikNotice("小组名称已经存在，请更换其他小组名称！");
			
			$arrData = array(
				'userid'			=> $userid,
				'groupname'	=> $groupname,
				'groupdesc'		=> htmlspecialchars($_POST['groupdesc']),
				'isaudit'	=> $isaudit,
				'addtime'		=> time(),
			);
			
			$groupid = $db->insertArr($arrData,dbprefix.'group');
			
			//添加tag
			aac('tag')->addTag('group','groupid',$groupid,$tags);			

			//上传
			$arrUpload = ikUpload($_FILES['picfile'],$groupid,'group',array('jpg','gif','png'));
			
			if($arrUpload){

				$new['group']->update('group',array(
					'groupid'=>$groupid,
				),array(
					'path'=>$arrUpload['path'],
					'groupicon'=>$arrUpload['url'],
				));
			}
			
			//绑定成员
			$db->query("insert into ".dbprefix."group_users (`userid`,`groupid`,`addtime`) values ('".$userid."','".$groupid."','".time()."')");
			
			//更新
			$db->query("update ".dbprefix."group set `count_user` = '1' where groupid='".$groupid."'");

			header("Location: ".SITE_URL.U('group','show',array('id'=>$groupid)));
		}
		break;
	
}