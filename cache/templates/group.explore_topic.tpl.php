<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<h1><?php echo $title;?></h1>
<div class="cleft">

	<div class="topics">
	<ul>
		<?php foreach((array)$arrTopic as $item) {?>
		<li>
		<div class="content">
		<div class="title">
		<a href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>""><?php echo $item['title'];?></a>
		</div>
	
		<p><?php echo getsubstrutf8(t($item['content']),0,100)?></p>
		<div class="from"><span class="reply-num"><a href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>#comment"><?php echo $item['count_comment'];?> 回应</a></span> <span class="fav-num"><a href="#">164 喜欢</a></span>
		<div class="from-group">来自: <span class="group-name"><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['group'][groupname];?></a> 小组</span></div>
		</div>
		</div>
		</li>
		<?php } ?>
	</ul>
	</div>
	
</div>



<div class="cright"></div>

</div>
</div>
<?php include template('footer'); ?>
