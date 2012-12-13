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

}