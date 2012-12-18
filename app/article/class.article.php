<?php 
defined('IN_IK') or die('Access Denied.');
class article extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//根据userid获取所有分类
	function getArrCate($userid){
		$arrCate = $this->db->fetch_all_assoc("select * from ".dbprefix."note_cate where `userid`='$userid'");
		return $arrCate;
	}
	
	//获取一个分类 
	function getOneCate($cateid){
		$strCate = $this->db->once_fetch_assoc("select * from ".dbprefix."note_cate where `cateid`='$cateid'");
		return $strCate;
	}
	
	//获取文章的第一张图片
	function getOnePhoto($content) {
			preg_match_all('/\[(photo)=(\d+)\]/is', $content, $photo);
			$photoid = $photo[2][0];
			$strPhoto = aac('photo')->getSamplePhoto($photoid);
			return $strPhoto;
	}
	//根据noteid 获取日志
	function getOneNote($noteid) {
		  $strNote = $this->find('note',array('noteid'=>$noteid));
		  return $strNote; 
	}
	//根据noteid获取评论数量
	function getCommnetnum($noteid) {
		  $num = $this->findCount("note_comment",array('noteid'=>$noteid));
		  return $num;
	}
	//删除评论
	public function delComment($commentid){

		$this->delete('note_comment',array(
			'commentid'=>$commentid,
		));
		return true;
	}
	//根据referid 获取回复评论
	function getRecomment($referid){
		$strComment = $this->find('note_comment',array('commentid'=>$referid));
		$strComment['user'] = aac('user')->getOneUser($strComment['userid']);
		$strComment['content'] = editor2html($strComment['content']);
		
		return $strComment;
	}
	//删除日志
	function delNote($noteid){
		
		$this->delete('note',array('noteid'=>$noteid));//删除日志
		
		$this->delete('note_comment',array('noteid'=>$noteid));//删评论
		
		//$this->delete('tag_note_index',array('noteid'=>$noteid)); //删除tag标签
		
		return true;
	}
	//获取最新日志
	function getNewNote($num){
		$arrNewNotes = $this->db->fetch_all_assoc("select noteid from ".dbprefix."note where isaudit='0' order by addtime desc limit $num");
		if(is_array($arrNewNotes)){
			foreach($arrNewNotes as $item){
				$arrNewNote[] = $this->getOneNote($item['noteid']);
			}
		}
		return $arrNewNote;
	}
	
}
