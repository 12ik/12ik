<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=options&ik=do">
<table  cellpadding="0" cellspacing="0">

<tr><td width="100">APP名称：</td><td><input style="width:300px;" name="appname" value="<?php echo $strOption['appname'];?>" /></td></tr>
<tr><td>APP介绍：</td><td><textarea style="width:300px;" name="appdesc"><?php echo $strOption['appdesc'];?></textarea></td></tr>
<tr><td>APP是否启用:</td><td><input <?php if($strOption['isenable']=='0') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="0" />启用 <input <?php if($strOption['isenable']=='1') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="1" />关闭</td></tr>

<tr>
<td>用户验证 :</td>
<!--0不验证，1Email验证，2手机验证-->
<td><input <?php if($strOption['isvalidate']=='0') { ?>checked="select"<?php } ?> name="isvalidate" type="radio" value="0" />不验证  <input <?php if($strOption['isvalidate']=='1') { ?>checked="select"<?php } ?> name="isvalidate" type="radio" value="1" />Email验证 </td>
</tr>

<tr><td>默认加入小组 :</td><td><input style="width:300px;" name="isgroup" value="<?php echo $strOption['isgroup'];?>" /> （输入小组的ID，不是小组名称，多个请用,号分开，如1,2,3）</td></tr>

<tr><td></td><td><input type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template("admin/footer");?>