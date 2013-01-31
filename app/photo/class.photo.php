<?php 
defined('IN_IK') or die('Access Denied.');

class photo extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//getPhotoForApp
	function getPhotoForApp($photoid){
		$strPhoto = $this->db->once_fetch_assoc("select * from ".dbprefix."photo where photoid='$photoid'");
		return $strPhoto;
	}
	
	function getSamplePhoto($photoid){
		$strPhoto = $this->db->once_fetch_assoc("select path,photourl from ".dbprefix."photo where photoid='$photoid'");
		return $strPhoto;
	}
	//根据用户id获取所有相册
	function getAllAlbumByUserId($userid, $num='')
	{
		$arrAlbum = $this->db->fetch_all_assoc("select * from ".dbprefix."photo_album where userid=$userid limit $num");
		return $arrAlbum;
	}

	//根据用户typeid 和 seqID 帖子图片
	function getPhotoByseq($type,$typeid,$seq)
	{
		$arrPhoto = $this->find('photos',array('seqid'=>$seq, 'typeid'=>$typeid));
		$arrPhoto['photo_140'] = SITE_URL.ikXimg($arrPhoto['photourl'],$type,140,140,$arrPhoto['path'],1);
		$arrPhoto['photo_500'] = SITE_URL.ikXimg($arrPhoto['photourl'],$type,500,500,$arrPhoto['path'],1);			
		return $arrPhoto;	
	}	

}