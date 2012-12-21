<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1><?php echo $title;?></h1>
<div class="cleft">

<form  method="post" action="<?php echo SITE_URL;?>index.php?app=photo&ac=album&ts=info_do">
    <div class="photo-complete">
    <?php foreach((array)$arrPhoto as $key=>$item) {?>
    <div class="photo-item">
    <div class="cover">
    <a href=""><img src="<?php echo SITE_URL;?><?php echo tsXimg($item['photourl'],'photo',100,100,$item['path'])?>"></a>
    <div class="choose-cover">
    <input type="hidden" name="photoid[]" value="<?php echo $item['photoid'];?>" />
    <input type="radio" <?php if($strAlbum['albumface']==$item['photourl']) { ?>checked="checked"<?php } ?> value="<?php echo $item['photourl'];?>" name="albumface" id="photo_<?php echo $key;?>"><label for="photo_<?php echo $key;?>">设置为封面</label>
    </div>
    </div>
    <div class="intro">
    <textarea class="most128" name="photodesc[]" maxlength="130"><?php echo $item['photodesc'];?></textarea>
    <p><a class="j a_confirm_link" title="删除这张照片" rel="nofollow" href="<?php echo SITE_URL;?>index.php?app=photo&ac=do&ts=photo_del&photoid=<?php echo $item['photoid'];?>">删除照片</a></p>
    </div>
    </div>
    <div class="clear"></div>
    <?php }?>
    </div>
    <div align="center">
        <input type="hidden" name="albumid" value="<?php echo $strAlbum['albumid'];?>" />
        <input class="submit" type="submit" value="保存">
    </div>
</form>

</div>

<div class="cright">
    <p class="pl2">
        &gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>photo,albumid=>$strAlbum['albumid']))?>">回相册“<?php echo $strAlbum['albumname'];?>”</a>
    </p>
</div>

</div>
</div>

<?php include template('footer'); ?>