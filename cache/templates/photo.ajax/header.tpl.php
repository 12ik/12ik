<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>相册管理</title>
<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/default/ajax.css" />
</head>
<body>
<div class="tabnav">
<ul>
<li <?php if($ik=='album' || $ik=='photo') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ik=album">我的相册</a></li>
<li <?php if($ik=='create') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ik=create">创建相册</a></li>
<li <?php if($ik=='net') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ik=net">网络图片</a></li>
</ul>
</div>