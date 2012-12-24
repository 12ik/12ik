<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old">
<td width="100">分类ID</td><td>分类名称</td> <td>操作</td>
</tr>

<?php foreach((array)$arrCate as $key=>$item) {?>
<tr><td><?php echo $item['catid'];?></td><td><?php echo $item['name'];?></td><td><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=cate&ts=edit&cateid=<?php echo $item['catid'];?>">修改</a>


</td></tr>
<?php }?>

</table>

</div>

<?php include template("admin/footer");?>