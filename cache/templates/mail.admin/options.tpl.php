<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=mail&ac=admin&mg=do&ik=options">
<table  cellpadding="0" cellspacing="0">

<tr><td width="150">APP名称：</td><td><input name="appname" value="<?php echo $strOption['appname'];?>" /></td></tr>
<tr><td>APP介绍：</td><td><textarea name="appdesc"><?php echo $strOption['appdesc'];?></textarea></td></tr>
<tr><td>APP是否启用:</td><td><input <?php if($strOption['isenable']=='0') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="0" />启用 <input <?php if($strOption['isenable']=='1') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="1" />关闭</td></tr>

<tr><td>邮箱Host :</td><td><input name="mailhost" value="<?php echo $strOption['mailhost'];?>" /> (例如：smtp.qq.com)</td></tr>
<tr><td>邮箱端口 :</td><td><input name="mailport" value="<?php echo $strOption['mailport'];?>" /> (例如：25)</td></tr>
<tr><td>邮箱用户 :</td><td><input name="mailuser" value="<?php echo $strOption['mailuser'];?>" /> (例如：user@qq.com)</td></tr>
<tr><td>邮箱密码 :</td><td><input name="mailpwd" value="<?php echo $strOption['mailpwd'];?>" /> (例如：123456)</td></tr>

<tr><td></td><td><input type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template("admin/footer");?>