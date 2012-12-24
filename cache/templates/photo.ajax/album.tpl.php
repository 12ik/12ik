<?php include template("ajax/header");?>
<div class="photolist">
<ul>
<?php foreach((array)$arrAlbum as $key=>$item) {?>
<li>
<div class="simg"><a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ts=photo&albumid=<?php echo $item['albumid'];?>"><img src="<?php if($item['albumface'] == '') { ?><?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/photo_album_100.png<?php } else { ?><?php echo SITE_URL;?><?php echo tsXimg($item['albumface'],'photo',100,100,$item['path'])?><?php } ?>" /></a></div>
<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ts=photo&albumid=<?php echo $item['albumid'];?>"><?php echo $item['albumname'];?></a>
<br>
<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ts=flash&albumid=<?php echo $item['albumid'];?>">上传照片</a>
</li>
<?php }?>
</ul>
</div>

</body>
</html>