<?php
defined('IN_IK') or die('Access Denied.');

$userid = $_POST['userid'];
$touserid = $_POST['touserid'];
$title = $_POST['title'];
$content = $_POST['content'];

$new['message']->sendmsg($userid,$touserid,$title,$content);

echo '1';