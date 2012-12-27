<?php include template('header'); ?>

<div class="midder">

<div class="mc">

    <div class="s_index">
    
        <div class="s_menu">
        <a <?php if($ik=='') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search')?>">全部</a> | 
        <a <?php if($ik=='group') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','index',array(ik=>group))?>">小组</a> | 
        <a <?php if($ik=='topic') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','index',array(ik=>topic))?>">帖子</a> | 
        <a <?php if($ik=='user') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','index',array(ik=>user))?>">用户</a>
        </div>
    
    <div>
    <form method="GET" action="<?php echo SITE_URL;?>index.php">
        <input type="hidden" name="app" value="search" />
        <input type="hidden" name="ac" value="q" />
        
        <?php if($ik=='group') { ?>
        <input type="hidden" name="ik" value="group" />
        <?php } elseif ($ik=='topic') { ?>
        <input type="hidden" name="ik" value="topic" />
        <?php } elseif ($ik=='user') { ?>
        <input type="hidden" name="ik" value="user" />
        <?php } else { ?>
        <?php } ?>
        
        <input class="s_input" name="kw"  /> 
        <input style="font-size:14px;" class="submit" type="submit" value="搜 索" />
    </form>
    
</div>

</div>


<?php include template('footer'); ?>