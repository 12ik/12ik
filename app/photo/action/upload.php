<?php 
defined('IN_IK') or die('Access Denied.');
//上传照片
$userid = intval($IK_USER['user']['userid']);
if($userid == 0) header("Location: ".SITE_URL."index.php");

$albumid = intval($_GET['albumid']);
if($albumid == 0) header("Location: ".SITE_URL."index.php");

$strAlbum = $db->once_fetch_assoc("select * from ".dbprefix."photo_album where albumid='$albumid'");

if($userid != $strAlbum['userid']) header("Location: ".SITE_URL."index.php?app=photo&a=album&ik=user&userid=".$userid);

$addtime = time();

$title = '上传照片';
include template("upload");