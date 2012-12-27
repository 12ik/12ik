<?php include template('header'); ?>

<div class="midder">
<div class="mc">

<?php include template('s_menu'); ?>
<div class="s_top">获得约 <?php echo $group_num;?> 条结果</div>

<?php foreach((array)$arrGroup as $key=>$item) {?>
<div class="result">
<div class="pic">
<a title="<?php echo $item['gname'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>" class="nbg"><img alt="<?php echo $item['groupname'];?>" src="<?php echo $item['icon_48'];?>" width="48" /></a>
</div>
<div class="content">
<h3><span>[小组] </span>&nbsp;<a  href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a></h3>
<div class="info">创建于 <?php echo date('Y-m-d',$item['addtime'])?> &nbsp; <a href="#"><?php echo $item['count_user'];?> 人</a></div>
<p><?php echo hview($item['groupdesc'])?></p>
</div>
</div>
<?php }?>

<div class="page"><?php echo $pageUrl;?></div>
</div>
</div>

<?php include template('footer'); ?>