<?php
	$targ_w = $targ_h = 200;
	$jpeg_quality = 100;
	$x = 80;
	$y = 80;
	$w = 50;
	$h = 50;
	

	$src = '5.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	imagecopyresampled($dst_r,$img_r,0,0,$x,$y,
	$targ_w,$targ_h,$w,$h);
	

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
	imagedestroy($dst_r);
?>

	