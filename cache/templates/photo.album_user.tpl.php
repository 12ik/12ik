<?php include template('header'); ?>

<div class="midder">
<div class="mc">
		<h1><?php echo $title;?></h1>
        <div class="cleft">
            <div class="wr">
            <?php if($arrAlbum) { ?>
            <?php foreach((array)$arrAlbum as $key=>$item) {?>
                    <div class="albumlst">
                    <a href="<?php echo U('photo','album',array(ik=>photo,albumid=>$item['albumid']))?>" class="album_photo"><img src="<?php if($item['albumface'] == '') { ?><?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/photo_album.png<?php } else { ?><?php echo SITE_URL;?><?php echo ikXimg($item['albumface'],'photo',170,170,$item['path'],1)?><?php } ?>" class="album"></a>
                    <div class="albumlst_r">
                        <div><a href="<?php echo U('photo','album',array(ik=>photo,albumid=>$item['albumid']))?>"><?php echo $item['albumname'];?></a></div>
                    <div class="albumlst_descri"><?php echo $item['albumdesc'];?></div>
            
                    <span class="pl">
                    <?php echo $item['count_photo'];?>张照片&nbsp;
                       <?php echo date('Y-m-d',$item['addtime'])?>创建<br>
                    </span>
                    <?php if($userid == $IK_USER['user'][userid] || $IK_USER['user'][isadmin]==1) { ?>&gt;<a href="<?php echo SITE_URL;?>index.php?app=photo&a=album&ik=edit&albumid=<?php echo $item['albumid'];?>">修改相册属性</a>
                    &nbsp;&gt;<a href="<?php echo SITE_URL;?>index.php?app=photo&a=upload&albumid=<?php echo $item['albumid'];?>">添加照片</a><?php } ?>
                    </div>
                    <br>
                    </div>
            <?php }?>
            <?php } else { ?>
             <p class="pl">可以有自己的相册来存放照片了，你可以从 <a href="<?php echo U('photo','album',array('ik'=>'create'))?>">创建一个相册</a> 开始。</p>
            <?php } ?>
             <div class="clear"></div>
             <div class="page"><?php echo $pageUrl;?></div>
            </div>
        
        </div>

        <div class="c_right">
           	<?php if($userid == $IK_USER['user'][userid] ) { ?>
            <p class="pl2">&gt; <a href="<?php echo U('photo','album',array('ik'=>'create'))?>">创建相册</a></p>
            <?php } ?>
        </div>

</div>
</div>

<?php include template('footer'); ?>