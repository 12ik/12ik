<?php include template('header'); ?>

<div class="midder"><?php include template('menu'); ?>

<div class="theme">
<form method="POST" action="index.php?app=system&ac=theme&ts=do">
<ul>
	<?php foreach((array)$arrTheme as $key=>$item) {?>
	<li><img src="theme/<?php echo $item;?>/preview.gif"> <br />
	<input type="radio" <?php if($IK_SITE['base'][site_theme]==$item) { ?>
		checked="checked" <?php } ?>  name="site_theme" value="<?php echo $item;?>" /> <?php echo $item;?>
	</li>
	<?php }?>
</ul>

<div class="clear"></div>
<input type="submit" value="更改主题" /></form>

</div>

</div>
<?php include template('footer'); ?>
