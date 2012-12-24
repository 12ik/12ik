<?php include template('header'); ?>

<div class="midder">
<div class="mc">

<div class="cleft">

<?php include template('menu'); ?>

<div id="container" class="wr">

<?php foreach((array)$arrAlbum as $key=>$item) {?>
        <div class="box albumlst">
        <a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>photo,albumid=>$item['albumid']))?>" class="album_photo"><img class="album" src="<?php if($item['albumface'] == '') { ?><?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/photo_album.png<?php } else { ?><?php echo SITE_URL;?><?php echo tsXimg($item['albumface'],'photo',170,170,$item['path'],'1')?><?php } ?>"></a>
        <div class="albumlst_r">
            <div><a href="<?php echo SITE_URL;?><?php echo tsurl('photo','albumid',array(ts=>photo,albumid=>$item['albumid']))?>"><?php echo $item['albumname'];?></a></div>
        <div class="albumlst_descri"><?php echo $item['albumdesc'];?></div>

        <span class="pl">
        <?php echo $item['count_photo'];?>张照片&nbsp;
           <?php echo date('Y-m-d',$item['addtime'])?>创建<br>
        </span>

        </div>
        <br>
        </div>
	<?php if($key%2) { ?><div class="clear"></div><?php } ?>
<?php }?>

<div class="clear"></div>
</div>
 
 <div class="page"><?php echo $pageUrl;?></div>

</div>

<div class="cright">

<h2>谁在评论照片</h2>

<ul class="mbt">
<?php foreach((array)$arrComment as $key=>$item) {?>
<li class="mbtl">
<?php if($item['user'][userid] !=$arrComment[$key-1][user][userid]) { ?>
<a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><img src="<?php echo $item['user'][face];?>"></a>
<?php } ?>
</li>
<li class="mbtrdot"><a href="<?php echo SITE_URL;?><?php echo tsurl('photo','show',array('photoid'=>$item['photoid']))?>"><?php echo $item['user'][username];?> : <?php echo $item['content'];?></a><span class="pl">  <?php echo getTime($item['addtime'],time())?></span>
<div class="clear"></div>
</li>
<?php }?>
</ul>
</div>

</div>
</div>

<?php include template('footer'); ?>