<?php 
defined('IN_IK') or die('Access Denied.');
class article extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}

	//根据referid 获取回复评论
	function getRecomment($referid){
		$strComment = $this->find('article_comments',array('commentid'=>$referid));
		$strComment['user'] = aac('user')->getOneUser($strComment['userid']);
		$strComment['content'] = editor2html($strComment['content']);
		
		return $strComment;
	}
	//删除评论
	public function delComment($commentid){

		$this->delete('article_comments',array(
			'commentid'=>$commentid,
		));
		return true;
	}		
	
	
}
