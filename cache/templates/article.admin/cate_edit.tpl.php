<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>


<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=cate&ts=edit_do">
<table>
<tr>
<td width="100">分类名称：</td><td><input name="name" value="<?php echo $strCate['name'];?>" /></td>
</tr>

<tr><td></td><td>
<input type="hidden" name="cateid" value="<?php echo $strCate['catid'];?>" />
<input type="hidden" name="type" value="<?php echo $strCate['type'];?>" />
<input type="submit" value="保存" /></td></tr>

</table>
</form>

</div>

<?php include template("admin/footer");?>