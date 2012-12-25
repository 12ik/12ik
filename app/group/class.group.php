<?php 
defined('IN_IK') or die('Access Denied.');

class group extends IKApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//显示所有小组分类带分页
	function getArrCate($page='1',$prePageNum,$where=''){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$cates	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_cates ".$where." ".$limit."");
		if($cates){
		foreach($cates as $item){
			$topCate = $this->getOneCateById($item['catereferid']);
			$arrCate[] = array(
				'cateid'			=> $item['cateid'],
				'catename'	=> $item['catename'],
				'topcateid'		=> $topCate['cateid'],
				'topcatename'		=> $topCate['catename'],
			);
		}}
		
		return $arrCate;
	}
	
	//获取一条分类的名字BY cateid
	function getOneCateById($cateid){

		$strCate = $this->find('group_cates',array(
			'cateid'=>$cateid,
		));
		
		return $strCate;
	}
	
	//获取一个小组
	function getOneGroup($groupid){
	
		if($this->isGroup($groupid)){
			
			$strGroup=$this->find('group',array(
				'groupid'=>$groupid,
			));
			
			if($strGroup['groupicon'] == ''){
				$strGroup['icon_48'] = SITE_URL.'public/images/group.jpg';
				$strGroup['icon_16'] = SITE_URL.'public/images/group.jpg';
			}else{
				$strGroup['icon_48'] = SITE_URL.ikXimg($strGroup['groupicon'],'group',48,48,$strGroup['path'],1);
				$strGroup['icon_16'] = SITE_URL.ikXimg($strGroup['groupicon'],'group',16,16,$strGroup['path'],1);
			}
			
			return $strGroup;
			
		}else{
			
			header("Location: ".SITE_URL);
			exit;
			
		}

	}
	
	/*
	 *获取小组全部内容列表
	 */

	function getGroupContent($page = 1, $prePageNum,$groupid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContent	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_topics where groupid='$groupid' order by addtime desc $limit");
		return $arrGroupContent;
	}
	
	//获取推荐的小组
	function getRecommendGroup($num){
		$arrRecommendGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isrecommend='1' limit $num");
		
		$arrRecommendGroup = array();
		
		if(is_array($arrRecommendGroups)){
			foreach($arrRecommendGroups as $item){
				$arrRecommendGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrRecommendGroup;
	}
	
	//获取最新创建的小组
	function getNewGroup($num){
		$arrNewGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isshow='0' order by addtime desc limit $num");
		if(is_array($arrNewGroups)){
			foreach($arrNewGroups as $item){
				$arrNewGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrNewGroup;
	}
		
	
	/*
	 *获取小组全部内容数
	 */
	
	function getGroupContentNum($virtue, $setvirtue){
		$where = 'where '.$virtue.'='.$setvirtue.'';
		$sql = "SELECT * FROM ".dbprefix."group_topics $where";
		$groupContentNum = $this->db->once_num_rows($sql);
		return $groupContentNum;
	}
	
	/*
	 *获取内容
	 */
	 
	function getOneGroupContent($topicid){
		$strGroupContent = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid=$topicid");
		return $strGroupContent;
	}
	
	/*
	 *获取内容评论列表
	 */
	
	function getGroupContentComment($page = 1, $prePageNum,$topicid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContentComment	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_topics_comments where topicid='$topicid' order by addtime desc $limit");
		
		if(is_array($arrGroupContentComment)){
			foreach($arrGroupContentComment as $key=>$item){
				$arrGroupContentComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
				$arrGroupContentComment[$key]['content'] = editor2html($item['content']);
				$arrGroupContentComment[$key]['recomment'] = $this->recomment($item['referid']);
			}
		}
		
		return $arrGroupContentComment;
	}
	
	//Refer二级循环，三级循环暂时免谈
	function recomment($referid){
		$strComment = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where commentid='$referid'");
		$strComment['user'] = aac('user')->getOneUser($strComment['userid']);
		$strComment['content'] = editor2html($strComment['content']);
		
		return $strComment;
	}

	
	//是否存在帖子 
	public function isTopic($topicid){
		
		$isTopic = $this->findCount('group_topics',array(
			'topicid'=>$topicid,
		));
		
		if($isTopic > 0){
		
			return true;
		
		}else{
			
			return false;
			
		}
		
	}
	
	//获取一条帖子 
	public function getOneTopic($topicid){
		
		if($this->isTopic($topicid)){
		
			$strTopic = $this->find('group_topics',array(
				'topicid'=>$topicid,
			));
			
			return $strTopic;
			
		}else{
			
			header("Location: ".SITE_URL);
			
			exit;
			
		}
		
	}
	
	//删除帖子
	public function delTopic($topicid){

		$strTopic = $this->find('group_topics',array(
			'topicid'=>$topicid,
		));

		$this->delete('group_topics',array('topicid'=>$topicid));
		
		$this->delete('group_topics_comments',array('topicid'=>$topicid));
		
		$this->delete('tag_topic_index',array('topicid'=>$topicid)); //删除tag标签
		
		$this->delete('group_topics_collects',array('topicid'=>$topicid)); 
		
		
		//删除图片
		//if($strTopic['photo']){
		//	unlink('uploadfile/topic/'.$strTopic['photo']);
		//}
		//删除文件
		//if($strTopic['attach']){
		//	unlink('uploadfile/topic/'.$strTopic['attach']);
		//}
		
		//删除话题评论
		$this->delTopicComment($topicid);
		
		return true;
		
	}
	
	//删除话题评论
	public function delTopicComment($topicid){
		$arrComment = $this->findAll('group_topics_comments',array(
			'topicid'=>$topicid,
		));
		
		foreach($arrComment as $item){
			$this->delComment($item['commentid']);
		}
		
		return true;
		
	}
	
	//删除评论
	public function delComment($commentid){

		$this->delete('group_topics_comments',array(
			'commentid'=>$commentid,
		));
		
		return true;
		
	}
	
	//判断是否存在小组
	function isGroup($groupid){
		
		$isGroup = $this->findCount('group',array(
			'groupid'=>$groupid,
		));
		
		if($isGroup > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	//获取帖子第一张图片
	function getOnePhoto($topicid){
	
		$strTopic = $this->getOneTopic($topicid);
		
		if($strTopic['isphoto']=='1'){
			preg_match_all('/\[(photo)=(\d+)\]/is', $strTopic['content'], $photos);
			$photoid = $photos[2][0];
			
			$strPhoto = aac('photo')->getSamplePhoto($photoid);
			
			return $strPhoto;
			
		}
	}
	
	
	//析构函数
	public function __destruct(){
		
	}
	
}