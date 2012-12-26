<?php include template('header'); ?>
<div class="midder">
<div class="mc">
	<h1><?php echo $title;?></h1>
    <div class="cleft">
        
        
        <div class="footer">
            <span>这里看上去很冷清？尝试喜欢更多小站来发现感兴趣的内容吧</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo SITE_URL;?><?php echo ikurl('site','explore',array('ik'=>'site'))?>">发现更多小站</a>
        </div>
   
    </div>

    <div class="cright">
 		    <?php if($IK_USER['user'][userid] !='' ) { ?>
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('site','explore',array('ik'=>'site'))?>">发现更多小站</a></p>
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('site','new_site')?>">申请创建小站</a></p>
            <?php } ?>
    </div>
    
</div>
</div>
<?php include template('footer'); ?>