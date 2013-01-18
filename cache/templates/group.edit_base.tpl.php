<?php include template('header'); ?>
<!--main-->
<div class="midder">

<div class="mc">
<?php include template('edit_xbar'); ?>

<div class="cleft">

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=do&ik=edit_base">
<table align="center" style="width:100%;clear: both;" class="table_1">
	<tr><th>小组名称：</th>
    <td><input type="text" value="<?php echo $strGroup['groupname'];?>" maxlength="63" size="31" name="groupname" gtbfieldid="13" class="txt" placeholder="请填写小组名称"></td></tr>
    <tr><th>小组介绍：</th>
    <td><textarea style="width:100%;height:300px;" name="groupdesc" id="editor_mini" class="txt"   placeholder="请填写小组介绍"><?php echo $strGroup['groupdesc'];?></textarea></td></tr>
    <tr>
    	<th>&nbsp;</th>
        <td>
          <input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
          <input class="submit" type="submit" tabinde="8" value="更新小组设置" >
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
<!--加载编辑器-->
<?php include template('footer'); ?>