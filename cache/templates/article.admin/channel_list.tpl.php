<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old">
<td width="100">英文ID</td><td>频道名称</td> <td>操作</td>
</tr>

<?php foreach((array)$arrList as $key=>$item) {?>
<tr><td><?php echo $item['nameid'];?></td><td><?php echo $item['name'];?></td><td>
<a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ik=edit&nameid=<?php echo $item['nameid'];?>">修改</a> 
<a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=cate&ik=list&nameid=<?php echo $item['nameid'];?>">分类</a>
<a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=cate&ik=add&nameid=<?php echo $item['nameid'];?>">添加分类</a>
</td></tr>
<?php }?>

</table>

</div>

<?php include template("admin/footer");?>