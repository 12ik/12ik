<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<h1><?php echo $title;?></h1>
<div class="cleft w700">

	<div class="topics">
	<ul>
		<?php foreach((array)$arrTopic as $item) {?>
		<li>
		<div class="content">
		<div class="title">
		<a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>
		</div>
	
		<p><?php echo getsubstrutf8(t($item['content']),0,100)?></p>
		<div class="from"><span class="reply-num"><a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>#comment"><?php echo $item['count_comment'];?> 回应</a></span> <span class="fav-num"><a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>#like"><?php echo $item['count_collect'];?> 喜欢</a></span>
		<div class="from-group">来自: <span class="group-name"><a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['group'][groupname];?></a> 小组</span></div>
		</div>
		</div>
		</li>
		<?php } ?>
	</ul>
	</div>
	
</div>



    <div class="cright w250">
   		 <?php include template('topic_cate'); ?>   	
    </div>

</div>
</div>
<?php include template('footer'); ?>
