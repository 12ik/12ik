<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1>移动帖子：<?php echo $strTopic['title'];?></h1>
<div class="cleft">
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&a=do&ik=topic_move">
<p>选择小组：
<select name="groupid">
<?php foreach((array)$arrGroup as $key=>$item) {?>
<option value="<?php echo $item['groupid'];?>"><?php echo $item['groupname'];?></option>
<?php }?>
</select>
</p>
<p>
<input type="hidden" name="topicid" value="<?php echo $topicid;?>" />
<input class="submit" type="submit" value="移动" /></p>
</form>
</div>


</div>
</div>

<?php include template('footer'); ?>