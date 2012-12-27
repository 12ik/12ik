<div class="s_menu">
<a <?php if($ik=='') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','q',array(kw=>urldecode($kw)))?>">全部</a> | 
<a <?php if($ik=='group') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','q',array(ik=>group,kw=>urldecode($kw)))?>">小组</a> | 
<a <?php if($ik=='topic') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','q',array(ik=>topic,kw=>urldecode($kw)))?>">帖子</a> | 
<a <?php if($ik=='user') { ?>class="s_select"<?php } ?> href="<?php echo SITE_URL;?><?php echo ikurl('search','q',array(ik=>user,kw=>urldecode($kw)))?>">用户</a>
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

<input class="s_input" name="kw" value="<?php echo urldecode($kw)?>"  /> 
<input class="submit f14" type="submit" value="搜 索" />
</form>
<br />
<br />
</div>