<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table>
<tr class="old"><td width="60">PhotoId</td><td width="120">图片</td><td>AlbumID</td><td>UserId</td><td>操作</td></tr>
<?php foreach((array)$arrPhoto as $key=>$item) {?>
<tr><td><?php echo $item['photoid'];?></td><td><a target="_blank" href="<?php echo SITE_URL;?>uploadfile/photo/<?php echo $item['photourl'];?>">

<?php if($item['photourl']) { ?>
<img src="<?php echo SITE_URL;?><?php echo tsXimg($item['photourl'],'photo',100,100,$item['path'])?>" />
<?php } else { ?>
<img src="<?php echo SITE_URL;?>public/images/event_dft.jpg" />
<?php } ?>

</a></td><td><?php echo $item['albumid'];?></td><td><?php echo $item['userid'];?></td><td><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=album&ts=face&photoid=<?php echo $item['photoid'];?>">设为封面</a> 

<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=photo&ts=isrecommend&photoid=<?php echo $item['photoid'];?>"><?php if($item['isrecommend']==0) { ?>推荐<?php } else { ?>取消推荐<?php } ?></a> <a href="">修改</a> 

<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=admin&mg=album&ts=del_photo&photoid=<?php echo $item['photoid'];?>">删除</a></td></tr>
<?php }?>
</table>

</div>

<?php include template("admin/footer");?>