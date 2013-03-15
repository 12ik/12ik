<?php 
include IKCORE.'/function/IKUpload.php';
if(!empty($_FILES['file']))
{
	$ad = savelocalfile($_FILES['file']);
	var_dump($ad);
}

include template("test");

