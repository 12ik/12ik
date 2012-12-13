<?php 
defined('IN_IK') or die('Access Denied.');
$strInfo = $db->once_fetch_assoc("select * from ".dbprefix."home_info where `infokey`='$ac'");
$title = '用户协议';
include template('agreement');