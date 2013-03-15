<?php include template('header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/validate.css" id="skin" />
<!--main-->
<div class="midder">
<div class="mc">
<h1 class="user_tit">用户登录</h1>

<div class="user_left">
<form method="POST" action="<?php echo U('user','login',array('ik'=>'do'))?>" id="signupform">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="Tabletext">
<tr><td class="label">Email：</td><td class="field"><input class="uinput" type="email" name="email" autofocus/></td></tr>
<tr><td class="label">密码：</td><td class="field"><input class="uinput" type="password" name="pwd" /></td></tr>

<tr>
<td>&nbsp;</td>
<td class="field">
<input type="hidden" name="jump" value="<?php echo $jump;?>" />
<input type="hidden" name="cktime" value="2592000">
<input class="submit" type="submit" value="登录" style="margin-top:8px"/> 
&nbsp;&nbsp;<a href="<?php echo U('user','register')?>">还没有帐号？</a> | <a href="<?php echo U('user','forgetpwd')?>">忘记密码</a>
</td>
</tr>
</table>
</form>
</div>


<div class="aside">
<?php doAction('user_login_footer')?>
</div>

<div class="cl"></div>

</div>
</div>

<?php include template('footer'); ?>