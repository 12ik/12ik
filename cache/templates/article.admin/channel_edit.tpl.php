<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>


<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ts=edit_do">
<table>
<tr>
<td width="100">频道名称：</td><td><input name="name" value="<?php echo $arrChannel['name'];?>" /></td>
</tr>
<tr>
<td width="100">英文ID：</td><td><?php echo $arrChannel['nameid'];?></td>
</tr>
<tr>
<td width="100">访问地址：</td><td><input name="url" value="<?php echo $arrChannel['url'];?>" /></td>
</tr>

<tr><td></td><td><input type="submit" value="保存修改" /></td></tr>

</table>
</form>

</div>

<?php include template("admin/footer");?>