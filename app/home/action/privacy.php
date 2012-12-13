<?php 
defined('IN_IK') or die('Access Denied.');
$strInfo = $db->once_fetch_assoc("select * from ".dbprefix."home_info where `infokey`='$ac'");
$title = '隐私声明';
include template('privacy');