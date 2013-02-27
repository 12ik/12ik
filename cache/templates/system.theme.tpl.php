<?php include template('header'); ?>

<div class="midder">
<h2><?php echo $title;?></h2>
<div class="theme">
<form method="POST" action="index.php?app=system&a=theme&ik=do">
<ul>
	<?php foreach((array)$arrTheme as $key=>$item) {?>
	<li><img src="theme/<?php echo $item;?>/preview.gif"> <br />
	<input type="radio" <?php if($IK_SITE['base'][site_theme]==$item) { ?>
		checked="checked" <?php } ?>  name="site_theme" value="<?php echo $item;?>" /> <?php echo $item;?>
	</li>
	<?php }?>
</ul>

<div class="clear"></div>

<div class="page_btn"><input type="submit" value="更改主题" class="submit" /></div>

</form>

</div>

</div>
<?php include template('footer'); ?>
