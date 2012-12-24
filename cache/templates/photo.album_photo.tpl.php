<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1><?php echo $title;?></h1>

<div class="cleft">
<div class="pl photitle">
<?php if($strAlbum['userid'] == $IK_USER['user'][userid] || $IK_USER['user'][isadmin]==1) { ?>    &nbsp;&gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array('ts'=>'edit','albumid'=>$strAlbum['albumid']))?>">修改相册属性</a>
    &nbsp;&gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','upload',array('albumid'=>$strAlbum['albumid']))?>">添加照片</a>
    <?php if($strAlbum['count_photo']>'0') { ?>&nbsp;&gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array('ts'=>'info','albumid'=>$strAlbum['albumid']))?>">批量修改</a><?php } ?><?php } ?>
    &nbsp;&gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(userid=>$strAlbum['userid']))?>">返回<?php if($strAlbum['userid'] == $IK_USER['user'][userid]) { ?>我<?php } else { ?><?php echo $strUser['username'];?><?php } ?>的相册首页</a>
</div>

<div id="container" class="photolst clearfix">
<?php if($arrPhoto) { ?>
<?php foreach((array)$arrPhoto as $key=>$item) {?>
    <div class="box photo_wrap">
    	
        <a title="<?php echo $item['photodesc'];?>" class="photolst_photo" href="<?php echo SITE_URL;?><?php echo tsurl('photo','show',array(photoid=>$item['photoid']))?>">
        <?php if($item['hash']) { ?>
        <img src="<?php echo SITE_URL;?><?php echo tsXimg($item['photourl'],'attachments',170,170,$item['path'],1)?>">
        <?php } else { ?>
        <img src="<?php echo SITE_URL;?><?php echo tsXimg($item['photourl'],'photo',170,170,$item['path'],1)?>">
        <?php } ?>
        </a><br>
        <div class="pl"><?php echo $item['photodesc'];?></div>
        <div style="color:#999">
                    &nbsp;<?php echo $item['count_view'];?>浏览
        </div>
    </div>
	
	<?php if(is_int(($key+1)/3)) { ?>
	<div class="clear"></div>
	<?php } ?>
	
<?php }?>
<?php } else { ?>
<br>
<div class="pl">这个相册现在还没有照片
<?php if($strAlbum['userid'] == $IK_USER['user'][userid]) { ?>, 你可以<a href="<?php echo SITE_URL;?>index.php?app=photo&ac=upload&albumid=<?php echo $strAlbum['albumid'];?>">添加照片</a><?php } ?>
</div>
<br>
<?php } ?>
</div>
<div class="clear"></div>

<div class="page"><?php echo $pageUrl;?></div>

<div style="padding-bottom:30px" class="pl"><?php echo $strAlbum['albumdesc'];?></div>
<div class="wr">
<span class="pl">
    <?php echo $strAlbum['count_view'];?> 人浏览
</span>
<span class="pl"><?php echo $strAlbum['count_photo'];?>&nbsp;张照片
&nbsp;<?php echo date('Y-m-d',$strAlbum['addtime'])?>&nbsp;创建
</span>
<?php if($strAlbum['userid'] == $IK_USER['user'][userid] || $IK_USER['user'][isadmin]==1) { ?>
<span class="gact">&nbsp;&gt;&nbsp;<a  class="j a_confirm_link" rel="nofollow" href="<?php echo SITE_URL;?>index.php?app=photo&ac=album&ts=del&albumid=<?php echo $strAlbum['albumid'];?>">删除相册</a></span>
<?php } ?>
</div>


<div>

</div>
</div>

<div class="cright"></div>

</div>
</div>

<?php include template('footer'); ?>