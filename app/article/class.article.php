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
	//根据typeid 和 seqID 获取文章图片
	function getPhotoByseq($typeid,$seq)
	{
		$arrPhoto = $this->find('article_photos',array('seqid'=>$seq, 'typeid'=>$typeid));
		$arrPhoto['photo_140'] = SITE_URL.ikXimg($arrPhoto['photourl'],'article',140,140,$arrPhoto['path'],1);
		$arrPhoto['photo_500'] = SITE_URL.ikXimg($arrPhoto['photourl'],'article',500,500,$arrPhoto['path'],1);			
		return $arrPhoto;	
	}	
	//根据用户userid itemid 获取文章图片
	function getPhotosByItemid($userid,$itemid)
	{
		$arrPhotos = $this->findAll('article_photos',array('userid'=>$userid, 'typeid'=>$itemid));
		foreach($arrPhotos as $key=>$item)
		{
			$arrPhoto[] = $item;
			$arrPhoto[$key]['photo_140'] = SITE_URL.ikXimg($item['photourl'],'article',140,140,$item['path'],1);
			$arrPhoto[$key]['photo_500'] = SITE_URL.ikXimg($item['photourl'],'article',500,500,$item['path'],1);			
		}
		return $arrPhoto;	
	}			
	
	
}
