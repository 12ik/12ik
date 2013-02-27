<?php 
defined('IN_IK') or die('Access Denied.');
class site extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	//判断是否存在小站
	function isSite($siteid){
		$isSite = $this->findCount('site',array('siteid'=>$siteid));
		if($isSite > 0){
			return true;
		}else{
			return false;
		}
	}
	//判断是否存在房间
	function isRoom($roomid){
		$isRoom = $this->findCount('site_room',array('roomid'=>$roomid));
		if($isRoom > 0){
			return true;
		}else{
			return false;
		}
	}
	//获取一个小站
	function getOneSite($siteid){
		if($this->isSite($siteid)){
			$strSite=$this->find('site',array(
				'siteid'=>$siteid,
			));
			if($strSite['siteicon'] == ''){
				$strSite['icon_180'] = SITE_URL.'public/images/icon_default_large.png';
				$strSite['icon_75'] = SITE_URL.'public/images/icon_default_small.png';
				$strSite['icon_48'] = SITE_URL.'public/images/icon_default_small.png';
			}else if($strSite['imgpos']!=''){
				//如果截图位置不为空 说明是切图 x y width
				$arrPos = explode('_',$strSite['imgpos']);
				$bigImg = ikXimg($strSite['siteicon'],'site',180,220,$strSite['iconpath'],0);
				$strSite['icon_180'] = SITE_URL.$bigImg;
				$strSite['icon_75'] = SITE_URL.ikXimg($strSite['siteicon'],'site',75,75,$strSite['iconpath'],1);
				$strSite['icon_48'] = SITE_URL.ikXimg($strSite['siteicon'],'site',48,48,$strSite['iconpath'],1);
				//$strSite['icon_75'] = SITE_URL.ikXimg($bigImg,'site',75,75,$strSite['iconpath'],1,array(
				//'X'=>$arrPos[0], 'Y'=>$arrPos[1],'W'=>$arrPos[2],'H'=>$arrPos[2],'R'=>1));
				//$strSite['icon_48'] = SITE_URL.ikXimg($bigImg,'site',48,48,$strSite['iconpath'],1,array(
				//'X'=>$arrPos[0], 'Y'=>$arrPos[1],'W'=>$arrPos[2],'H'=>$arrPos[2],'R'=>1));
			}else{
				$strSite['icon_180'] = SITE_URL.ikXimg($strSite['siteicon'],'site',180,220,$strSite['iconpath'],0);
				$strSite['icon_75'] = SITE_URL.ikXimg($strSite['siteicon'],'site',75,75,$strSite['iconpath'],0);
				$strSite['icon_48'] = SITE_URL.ikXimg($strSite['siteicon'],'site',48,48,$strSite['iconpath'],0);
			}
			return $strSite;
			
		}else{
			//header("Location: ".SITE_URL);
			//exit;
			return;
		}
	}
	//根据roomid获取一个房间
	function getOneRoom($roomid){
		if($this->isRoom($roomid)){
			$strRoom=$this->find('site_room',array(
				'roomid'=>$roomid,
			));
			
			return $strRoom;
			
		}else{
			header("Location: ".SITE_URL);
			exit;
		}
	}
	//根据siteid获取多个房间
	function getRooms($siteid){
		$strRoom = $this->findAll('site_room',array(
				'siteid'=>$siteid,
			));
		return $strRoom;
	}
	//根据siteid获取排序好的导航
	function getNavOrders($siteid)
	{
		$navOrders = array();
		$ordertext = $this->getNavOrderBysiteId($siteid);
		$strNavtext = explode("," ,  $ordertext['ordertext']);
		foreach($strNavtext as $key=>$item)
		{
			$navOrders[$key] = $this->getOneRoom($item); 
		}
		return $navOrders;
	}
	function getNavOrderBysiteId($siteid)
	{
		$strNavOrder = $this->find('site_room_navorder',array(
				'siteid'=>$siteid,
			));
		return $strNavOrder;
	}	
	//根据siteid获取该小站theme
	function getSiteThemeBySiteid($siteid){
		if($this->isSite($siteid)){
			$strSite=$this->find('site_theme',array(
				'siteid'=>$siteid,
			));

			return $strSite;
			
		}else{
			header("Location: ".SITE_URL);
			exit;
		}
	}
	//根据noteid获取日记信息
	function getOneNote($noteid){
		$str = $this->find('site_notes_content',array('contentid'=>$noteid));
		return $str;
	}
	//根据notesid获取日记信息
	function getOneNotes($notesid){
		$str = $this->find('site_notes',array('notesid'=>$notesid));
		return $str;
	}
	//根据bulletinid获取公告栏信息
	function getOneBulletin($bulletinid){
		$str = $this->find('site_bulletin',array('bulletinid'=>$bulletinid));
		return $str;
	}
	//根据roomid获取公告栏信息
	function getBulletinByRoomid($roomid){
		$str = $this->findAll('site_bulletin',array('roomid'=>$roomid), 'addtime desc');
		return $str;
	}
	function getOneWidget($array){
		$str = $this->find('site_widget',$array);
		return $str;
	}
	//根据参数获取组件信息 param：public 代表公用组件
	function getWidgets(){
		$str = $this->findAll('site_widget');
		return $str;
	}
	//添加房间组件模版数据
	/*function addHtml($userid,$roomid,$template,$data){
	
		$userid = intval($userid);
		
		if(is_array($data)){
			
			$data = serialize($data);
			
			$data = addslashes($data);

			$this->create('site_room_widget',array(
				'userid'=>$userid,
				'roomid'=>$roomid,
				'template'=>$template,
				'data'=>$data,
				'addtime'=>time(),
			));
		}
		
	}
	*/
	//根据roomid获取排序
	function getRoomWidgetSort($roomid){
		$str = $this->find('site_room_widget',array('roomid'=>$roomid));
		return $str;
	}
	//更新布局 如果 布局不存在则创建默认布局
	function updateLayout($roomid,$leftitem){
		$str = $this->find('site_room_widget',array('roomid'=>$roomid));
		if($str){
			$leftitem = empty($str['leftmod']) ? $leftitem : $leftitem.','.$str['leftmod'];
			$this->update('site_room_widget', array('roomid'=>$roomid), array('leftmod'=>$leftitem));
		}else{
			$this->create('site_room_widget', array('roomid'=>$roomid, 'leftmod'=>$leftitem));
		}
	}
	//根据roomid去除组件栏的组件
	function delWidget($roomid, $strwidget)
	{
		$modsort = $this->getRoomWidgetSort($roomid);
		$leftTable = explode(',',$modsort['leftmod']);
		$rightTable = explode(',',$modsort['rightmod']);
		$leftstr = $rightstr = '';
		$strarr = array();
		if(in_array($strwidget, $leftTable))
		{
			$leftstr = $this->substrWidget($strwidget,$leftTable);
			$strarr['leftmod'] = $leftstr;
		}
		if(in_array($strwidget, $rightTable))
		{
			$rightstr = $this->substrWidget($strwidget,$rightTable);
			$strarr['rightmod'] = $rightstr;
		}
		return $strarr;
	}
	function substrWidget($strwidget,$strarr)
	{
		foreach($strarr as $key=>$item)
		{
			if($item!=$strwidget)
			{
				$leftstr = $leftstr.','.$item;
			}
		}
		return 	substr_replace($leftstr, '',0,1);
	}
	//移动房间内的组件
	function moveWidget($currRoomid, $targetRoomid, $strWideget)
	{
		$targetRoom = $this->find('site_room',array('roomid'=>$targetRoomid));
		//$currRoom = $this->find('site_room',array('roomid'=>$currRoomid));
		if($targetRoom['count_widget']==6)
		{
			return array('status'=>1, 'roomname'=>$targetRoom['name']);
		}else
		{
			//更新当前房间组件数目
			$this->db->query("update ".dbprefix."site_room set count_widget = count_widget-1  where roomid='$currRoomid'");
			//更新移动后房间组件数目
			$this->db->query("update ".dbprefix."site_room set count_widget = count_widget+1  where roomid='$targetRoomid'");
			//更新移动后房间组件布局
			$this->updateLayout($targetRoomid,$strWideget);
			//更新当前房间布局
			$currt_room_widget = $this->delWidget($currRoomid, $strWideget);
			$this->update('site_room_widget',array('roomid'=>$currRoomid),$currt_room_widget);
			
			return array('status'=>0, 'roomname'=>$targetRoom['name']);
		}
				
	}
	//判断是否有权限执行模块操作
	function isAllow($obj_userid,$userid,$type)
	{
		if($obj_userid!=$userid && $userid)
		{	
			ikNotice('你没有执行该操作('.$type.')的权限！');	
			
		}else if(empty($userid)){
			
			ikNotice('你没有执行该操作('.$type.')的权限！','请登录后重试',SITE_URL.U('user','login'));	
		}
		return;		
	}
	//根据用户id 日记内容ID 获取该日记内的图片
	function getPhotosByNoteid($userid,$noteid)
	{
		$arrPhotos = $this->findAll('site_note_photo',array('userid'=>$userid, 'noteid'=>$noteid));
		foreach($arrPhotos as $key=>$item)
		{
			$arrPhoto[] = $item;
			$arrPhoto[$key]['photo_140'] = SITE_URL.ikXimg($item['photourl'],'site',140,170,$item['path'],0);
			$arrPhoto[$key]['photo_600'] = SITE_URL.ikXimg($item['photourl'],'site',600,730,$item['path'],0);			
		}
		return $arrPhoto;	
	}	
	//根据用户id 日记内容ID 获取该日记内的图片
	function getPhotoByseq($noteid,$seq)
	{
		$arrPhoto = $this->find('site_note_photo',array('seqid'=>$seq, 'noteid'=>$noteid));
		$arrPhoto['photo_140'] = SITE_URL.ikXimg($arrPhoto['photourl'],'site',140,170,$arrPhoto['path'],0);
		$arrPhoto['photo_600'] = SITE_URL.ikXimg($arrPhoto['photourl'],'site',600,730,$arrPhoto['path'],0);			
		return $arrPhoto;	
	}
	//获取最新推荐小站
	function getRecommendSite($num)
	{
		$arrRecommends = $this->db->fetch_all_assoc("select siteid from ".dbprefix."site where isrecommend='1' limit $num");
		$arrRecommend = array();
		if(is_array($arrRecommends)){
			foreach($arrRecommends as $item){
				$arrRecommend[] = $this->getOneSite($item['siteid']);
			}
		}
		return $arrRecommend;
	} 
}
