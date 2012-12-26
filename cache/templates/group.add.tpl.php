<?php include template('header'); ?>

<div class="midder">
<div class="mc">
<h1 class="group_tit">
<?php echo $strGroup['groupname'];?>发布帖子
</h1>

<?php if($isGroupUser == '0') { ?>
<div style="font-size:14px;padding-top:50px;text-align:center;">不好意思，你不是本组成员不能发表帖子，请加入后再发帖</div>
<?php } else { ?>
<form method="POST" action="<?php echo SITE_URL;?><?php echo ikurl('group','add',array('ik'=>'do'))?>" onsubmit="return newTopicFrom(this)"  enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="0" class="table_1">

	<tr>
    	<th>标题：</th>
		<td><input style="width:400px;" type="text" value="" maxlength="100" size="50" name="title" gtbfieldid="2" class="txt"   placeholder="请填写标题"></td></tr>	
    <tr>
        <th>内容：</th><td><textarea style="width:99.5%;height:300px;" id="editor_full" cols="55" rows="20" name="content" class="txt"   placeholder="请填写内容"></textarea></td>
    </tr>
    <tr>
        <th>评论：</th>
        <td><input type="radio" checked="select" name="iscomment" value="0" />允许 <input type="radio" name="iscomment" value="1" />不允许</td>
    </tr>	
    <tr><th>&nbsp;</th><td>
        
        <input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
        
        <input class="submit" type="submit" value="好啦，发布"> <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?>">返回</a>
        </td>
    </tr>
</table>
</form>
<?php } ?>


</div>
</div>


<?php include template('footer'); ?>