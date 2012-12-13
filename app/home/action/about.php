<?php 
defined('IN_IK') or die('Access Denied.');
$strInfo = $db->once_fetch_assoc("select * from ".dbprefix."home_info where `infokey`='$ac'");

$title = '关于我们';
include template('about');