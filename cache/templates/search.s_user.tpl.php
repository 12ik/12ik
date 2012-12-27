<?php include template('header'); ?>

<div class="midder">
<div class="mc">

<?php include template('s_menu'); ?>
<div class="s_top">获得约 <?php echo $user_num;?> 条结果</div>

<?php foreach((array)$arrUser as $key=>$item) {?>
<div class="result">
<div class="pic">
<a title="<?php echo $item['username'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>" class="nbg"><img alt="<?php echo $item['username'];?>" src="<?php echo $item['face'];?>" width="48" /></a>
</div>
<div class="content">
<h3><span>[用户] </span>&nbsp;<a  href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a></h3>
<div class="info"><?php echo date('Y-m-d',$item['addtime'])?> 加入&nbsp; <a href="#"><?php echo $item['count_followed'];?> 人关注</a></div>
<p><?php echo $item['signed'];?></p>
</div>
</div>
<?php }?>
<div class="page"><?php echo $pageUrl;?></div>
</div>
</div>

<?php include template('footer'); ?>