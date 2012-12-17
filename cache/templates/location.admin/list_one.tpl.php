<?php include template("admin/header");?>
<!--main-->
<div class="midder">
<?php include template("admin/menu");?>

<div><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=add&ts=one">添加顶级区域>></a></div>

<div class="page"><?php echo $pageUrl;?></div>
<table  cellpadding="0" cellspacing="0">
<tr class="old"><td>区域ID</td><td>区域名字</td><td>二级区域</td><td>操作</td></tr>
<?php foreach((array)$arrOne as $key=>$item) {?>
<tr class="odd"><td><?php echo $item['areaid'];?></td><td><?php echo $item['areaname'];?></td><td><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=list&ts=two&referid=<?php echo $item['areaid'];?>">查看二级区域</a></td><td><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=add&ts=two&referid=<?php echo $item['areaid'];?>">添加二级区域</a> | <a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=edit&areaid=<?php echo $item['areaid'];?>">修改</a> | <a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=del&areaid=<?php echo $item['areaid'];?>">删除</a></td></tr>
<?php }?>
</table>
</div>
<?php include template("admin/footer");?>