<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>


<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&a=admin&mg=channel&ik=add_do">
<table>
<tr>
<td width="100">频道名称：</td><td><input name="name" value="" /></td>
</tr>
<tr>
<td width="100">英文ID：</td><td><input name="nameid" value="" /> (请不要包含下划线)</td>
</tr>
<tr>
<td width="100">访问地址：</td><td><input name="url" value="" /></td>
</tr>
<tr>
<td width="100">文章分类：</td><td>
<textarea cols="37" id="category" rows="8" name="category"></textarea> (一行一个分类，多个元素用"回车"格开。)</td>
</tr>


<tr><td></td><td><input type="submit" value="添加" /></td></tr>

</table>
</form>

</div>

<?php include template("admin/footer");?>