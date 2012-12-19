<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>


<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ts=add_do">
<table>
<tr>
<td width="100">频道名称：</td><td><input name="name" value="<?php echo $arrChannel['name'];?>" /></td>
</tr>
<tr>
<td width="100">英文ID：</td><td><input name="nameid" value="<?php echo $arrChannel['nameid'];?>" /> (请不要包含下划线)</td>
</tr>
<tr>
<td width="100">访问地址：</td><td><input name="url" value="<?php echo $arrChannel['url'];?>" /></td>
</tr>
<tr>
<td width="100">文章分类：</td><td>
<textarea cols="37" id="category" rows="8" name="category"><?php foreach((array)$arrChannel['category'] as $item) {?><?php echo $item['name'].'\n';?><?php } ?></textarea> (一行一个分类，多个元素用"回车"格开。)</td>
</tr>


<tr><td></td><td><input type="submit" value="添加" /></td></tr>

</table>
</form>

</div>

<?php include template("admin/footer");?>