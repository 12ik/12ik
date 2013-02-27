<?php 
defined('IN_IK') or die('Access Denied.');
$strInfo = $db->once_fetch_assoc("select * from ".dbprefix."home_info where `infokey`='$a'");
$title = '联系我们';
include template('contact');