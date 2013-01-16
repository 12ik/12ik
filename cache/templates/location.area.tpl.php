<?php include template('header'); ?>

<div class="midder">

<div class="mc">

<div class="cleft">
<h1>同城<?php if($arrArea['one']) { ?> - <a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$arrArea['one'][areaid]))?>"><?php echo $arrArea['one'][areaname];?></a><?php } ?><?php if($arrArea['two']) { ?> - <a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$arrArea['two'][areaid]))?>"><?php echo $arrArea['two'][areaname];?></a><?php } ?><?php if($arrArea['three']) { ?> - <a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$arrArea['three'][areaid]))?>"><?php echo $arrArea['three'][areaname];?></a><?php } ?></h1>

<h2>同城里的人</h2>
<div class="obu_bar">
<?php foreach((array)$arrUser as $key=>$item) {?>
<dl class="obu">
<dt><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>" class="nbg"><img src="<?php echo $item['face'];?>" class="m_sub_img" /></a></dt>
<dd><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a></dd>
</dl>
<?php }?>
</div>
<div class="clear"></div>

</div>

<div class="cright">

<div style="margin-bottom: 10px;">
<div class="bd">
今天 <span class="date"><?php echo date('Y')?>年<?php echo date('m')?>月<?php echo date('d')?>日</span> 
<span class="week">星期<?php echo date('w')?></span>
</div>
</div>

<?php if($referArea) { ?>
<h2><?php echo $strArea['areaname'];?>下的区域</h2>
<div>
<?php foreach((array)$referArea as $key=>$item) {?>
<a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$item['areaid']))?>"><?php echo $item['areaname'];?></a>
<?php }?>
</div>
<?php } ?>

</div>

</div>
</div>

<?php include template('footer'); ?>