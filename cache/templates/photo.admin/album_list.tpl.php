<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old"><td width="60">AlbumID</td><td width="120">图片</td><td>UserID</td><td>统计</td><td>操作</td></tr>
<?php foreach((array)$arrAlbum as $key=>$item) {?>
<tr><td><?php echo $item['albumid'];?></td><td><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=album&ts=photo&albumid=<?php echo $item['albumid'];?>">

<?php if($item['albumface']) { ?>
<img src="<?php echo SITE_URL;?><?php echo tsXimg($item['albumface'],'photo',100,100,$item['path'])?>" />
<?php } else { ?>
<img src="<?php echo SITE_URL;?>public/images/event_dft.jpg" />
<?php } ?>

</a></td><td><?php echo $item['userid'];?></td><td><?php echo $item['count_photo'];?></td><td>

<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=album&ts=isrecommend&albumid=<?php echo $item['albumid'];?>"><?php if($item['isrecommend']==0) { ?>推荐<?php } else { ?>取消推荐<?php } ?></a>

<a href="">修改</a> <a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=album&ts=del_album&albumid=<?php echo $item['albumid'];?>">删除</a></td></tr>
<?php }?>
</table>

</div>

<?php include template("admin/footer");?>