<?php 
defined('IN_IK') or die('Access Denied.');
switch($ik){
	case "list":
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		
		$lstart = $page*10-10;
		
		$url = SITE_URL.'index.php?app=photo&ac=admin&mg=album&ik=list&page=';
		
		$arrAlbum = $db->fetch_all_assoc("select * from ".dbprefix."photo_album order by addtime desc limit $lstart,10");
		
		$albumNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."photo_album");
		
		$pageUrl = pagination($albumNum['count(*)'], 10, $page, $url);
		
		include template("admin/album_list");
		break;
	
	//图片 
	case "photo":
		$albumid = $_GET['albumid'];
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		
		$lstart = $page*10-10;
		
		$url = SITE_URL.'index.php?app=photo&ac=admin&mg=album&ik=photo&albumid='.$albumid.'&page=';
		
		$arrPhoto = $db->fetch_all_assoc("select * from ".dbprefix."photo where albumid='$albumid' limit $lstart,10");
		
		$photo_num = $db->once_fetch_assoc("select count(photoid) from ".dbprefix."photo where albumid='$albumid'");
		
		$pageUrl = pagination($photo_num['count(photoid)'], 10, $page, $url);
		
		include template("admin/album_photo");
		
		break;
		
	//删除相册
	case "del_album":
		$albumid = $_GET['albumid'];
		
		$db->query("delete from ".dbprefix."photo_album where albumid='$albumid'");
		$arrPhoto = $db->fetch_all_assoc("select * from ".dbprefix."photo where albumid='$albumid'");
		foreach($arrPhoto as $item){
			unlink('uploadfile/photo/'.$item['photourl']);
		}
		
		$db->query("delete from ".dbprefix."photo where albumid='$albumid'");
		
		qiMsg("相册删除成功！");
		
		break;
		
	//删除照片
	case "del_photo":
		$photoid = $_GET['photoid'];
		
		$strPhoto = $db->once_fetch_assoc("select * from ".dbprefix."photo where photoid='$photoid'");
		$albumid = $strPhoto['albumid'];
		
		$db->query("delete from ".dbprefix."photo where photoid='$photoid'");
		
		unlink('uploadfile/photo/'.$strPhoto['photourl']);
		
		$count_photo = $db->once_num_rows("select * from ".dbprefix."photo where albumid='$albumid'");
		
		$db->query("update ".dbprefix."photo_album set `count_photo`='$count_photo' where albumid='$albumid'");
		
		qiMsg("图片删除成功!");
		
		break;
		
	//设为封面
	case "face":
		$photoid = $_GET['photoid'];
		$strPhoto = $db->once_fetch_assoc("select * from ".dbprefix."photo where photoid='$photoid'");
		
		$albumid = $strPhoto['albumid'];
		$albumface = $strPhoto['photourl'];
		
		$db->query("update ".dbprefix."photo_album set `albumface`='$albumface' where albumid='$albumid'");
		
		qiMsg("封面设置成功！");
		
		break;
		
	//统计 
	case "count":
		
		$arrAlbum = $db->fetch_all_assoc("select albumid from ".dbprefix."photo_album");
		
		foreach($arrAlbum as $item){
			$albumid = $item['albumid'];
			$count_photo = $db->once_num_rows("select photoid from ".dbprefix."photo where albumid='$albumid'");
			$db->query("update ".dbprefix."photo_album set `count_photo`='$count_photo' where albumid='$albumid'");
		}
		
		qiMsg("统计完成！");
		
		break;
		
	//推荐相册 
	case "isrecommend":
	
		$albumid = $_GET['albumid'];
		
		$strAlbum = $db->once_fetch_assoc("select isrecommend from ".dbprefix."photo_album where `albumid`='$albumid'");
		
		if($strAlbum['isrecommend']==0){
			$db->query("update ".dbprefix."photo_album set `isrecommend`='1' where `albumid`='$albumid'");
		}else{
			$db->query("update ".dbprefix."photo_album set `isrecommend`='0' where `albumid`='$albumid'");
		}
	
		qiMsg("操作成功！");
	
		break;
	
}