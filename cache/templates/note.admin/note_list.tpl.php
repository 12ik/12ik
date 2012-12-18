<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old">
<td>日志ID</td><td>日志名称</td><td>日志分类</td><td>操作</td>
</tr>

<?php foreach((array)$arrNote as $key=>$item) {?>
<tr><td><?php echo $item['noteid'];?></td><td><?php echo $item['title'];?></td><td><?php echo $item['catename'];?></td>
<td><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=note&ts=edit&noteid=<?php echo $item['noteid'];?>">修改</a></td></tr>
<?php }?>

</table>

</div>

<?php include template("admin/footer");?>