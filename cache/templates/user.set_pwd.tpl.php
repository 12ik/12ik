<?php include template('header'); ?>

<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>

<div class="utable">
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ik=setpwd">
<table cellpadding="5" cellspacing="5">
<tr>
<th>旧密码：</th><td><input class="uinput" name="oldpwd" value="" type="password" /></td>
</tr>
<tr>
<th>新密码：</th><td><input class="uinput" name="newpwd" value="" type="password" /></td>
</tr>
<tr>
<th>重复新密码：</th><td><input class="uinput" name="renewpwd" value="" type="password" /></td>
</tr>

<tr><th></th><td><input class="submit" type="submit" value="修改密码"  /></td></tr>

</table>
</form>
</div>



</div>
</div>

<?php include template('footer'); ?>