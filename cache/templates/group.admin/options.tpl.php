<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=options&ts=do">
<table  cellpadding="0" cellspacing="0">

<tr><td width="150">APP名称：</td><td><input style="width:300px;" name="appname" value="<?php echo $strOption['appname'];?>" /></td></tr>
<tr><td>APP介绍：</td><td><textarea style="width:300px;" name="appdesc"><?php echo $strOption['appdesc'];?></textarea></td></tr>

<tr><td>是否允许用户创建小组 :</td><td><input <?php if($strOption['iscreate']=='0') { ?>checked="select"<?php } ?> name="iscreate" type="radio" value="0" />允许 <input <?php if($strOption['iscreate']=='1') { ?>checked="select"<?php } ?> name="iscreate" type="radio" value="1" />不允许(只有管理员可以创建小组)</td></tr>

<tr><td>创建小组是否需要审核 :</td><td><input <?php if($strOption['isaudit']=='1') { ?>checked="select"<?php } ?> name="isaudit" type="radio" value="1" />审核 <input <?php if($strOption['isaudit']=='0') { ?>checked="select"<?php } ?> name="isaudit" type="radio" value="0" />不审核</td></td></tr>

<tr><td></td><td><input type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template("admin/footer");?>