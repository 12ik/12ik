<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1>编辑：<?php echo $strTopic['title'];?></h1>
<div class="cleft">
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=topic_edit&ik=do">
<table cellpadding="0" cellspacing="0" class="table_1">
	<tr>
    <th width="50">标题：</tg>
    <td><input style="width:400px;" type="text" value="<?php echo $strTopic['title'];?>" maxlength="100" size="50" name="title" gtbfieldid="2" class="txt"    placeholder="请填写标题"></td>
    </tr>
    
    <tr>
	<th>内容：</th>
    <td><textarea id="editor_full" style="width:100%;height:300px;" name="content" class="txt"   placeholder="请填写内容"><?php echo $strTopic['content'];?></textarea></td>
    </tr>
	
	<tr>
    <th>评论：</th>
    <td><input type="radio"  <?php if($strTopic['iscomment']=='0') { ?> checked="select" <?php } ?>    name="iscomment" value="0" />允许 
    <input type="radio"  <?php if($strTopic['iscomment']=='1') { ?> checked="select" <?php } ?>   name="iscomment" value="1" />不允许
    </td>
    </tr>
	
    <tr>
    <th>&nbsp;</th>
    <td>
	<input type="hidden" name="topicid" value="<?php echo $strTopic['topicid'];?>" />
    <input type="submit" class="submit" value="修改">&nbsp;&nbsp;<a href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$strTopic['topicid']))?>">返回</a>
	</td>
    </tr>
</table>
</form>
</div>

    <div class="cright">
        <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?>">返回<?php echo $strGroup['groupname'];?></a></p>
    </div>


</div>
</div>

<?php include template('footer'); ?>