<?php include template('header'); ?>

<div class="midder">
<div class="mc">
<?php include template('s_menu'); ?>

<div class="s_top">获得约 <?php echo $topic_num;?> 条结果</div>

<?php foreach((array)$arrTopic as $key=>$item) {?>
<div class="result">
<div class="pic">
<a title="<?php echo $item['user'][username];?>" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>" class="nbg"><img alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>" width="48" /></a>
</div>
<div class="content">
<h3><span>[话题] </span>&nbsp;<a  href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a></h3>
<div class="info">发表于 <?php echo date('Y-m-d',$item['addtime'])?> &nbsp; <a href="#"><?php echo $item['count_comment'];?> 回复</a></div>
<p></p>
</div>
</div>
<?php }?>


<div class="page"><?php echo $pageUrl;?></div>
</div>
</div>

<?php include template('footer'); ?>