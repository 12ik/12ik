<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>
<table>
<tr><td width="100">全站：</td><td><a href="index.php?app=system&ac=cache&ts=delall">清理全站缓存</a></td></tr>


<tr><td>模板：</td><td><a href="index.php?app=system&ac=cache&ts=deltpl">清理模板缓存</a></td></tr>

<tr><td>相册：</td><td><a href="index.php?app=system&ac=cache&ts=delphoto">清理相册缓存</a></td></tr>

<tr><td>小组头像：</td><td><a href="index.php?app=system&ac=cache&ts=delgroup">清理小组头像缓存</a></td></tr>

<tr><td>用户头像：</td><td><a href="index.php?app=system&ac=cache&ts=deluser">清理用户头像缓存</a></td></tr>

</table>

</div>
<?php include template('footer'); ?>