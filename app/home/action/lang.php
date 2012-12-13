<?php 
defined('IN_IK') or die('Access Denied.');
$hl = $_GET['hl'];

setcookie("ik_lang", $hl, time()+3600*30,'/');

header("Location: ".SITE_URL.'index.php');