<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old">
<td>文章ID</td>
<td>文章名称</td>
<td>文章分类</td>
<td>操作</td>
</tr>

<?php foreach((array)$arrList as $key=>$item) {?>
<tr>
<td><?php echo $item['itemid'];?></td>
<td><?php echo $item['subject'];?></td>
<td><?php echo $item['catid'];?></td>
<td><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=note&ik=edit&noteid=<?php echo $item['noteid'];?>">修改</a></td></tr>
<?php }?>

</table>

</div>

<?php include template("admin/footer");?>