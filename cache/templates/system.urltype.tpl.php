<?php include template('header'); ?>

<div class="midder">
<h2><?php echo $title;?></h2>
<div>
<form method="POST" action="index.php?app=system&a=urltype&ik=do">

<table>
	<tr>
		<td width="100">形式1：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==1) { ?> checked="select" <?php } ?>
		name="site_urltype" value="1" /> index.php?app=group&a=topic&id=1</td>
	</tr>
	<tr>
		<td>形式2：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==2) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="2" />
		index.php/group/topic/id-1</td>
	</tr>
	<tr>
		<td>形式3：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==3) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="3" />
		group-topic-topicid-1.html</td>
	</tr>    
	<tr>
		<td>形式4：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==4) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="4" />
		group/topic/ik-user/id-1 (暂只支持apache环境的rewrite，非apache环境勿动)</td>
	</tr>
	<tr>
		<td>形式5：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==5) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="5" />
		group/topic/1 (暂只支持apache环境的rewrite，非apache环境勿动)</td>
	</tr>
	<tr>
		<td>形式6：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==6) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="6" />
		group/topic/id/1 (暂只支持apache环境的rewrite，非apache环境勿动)</td>
	</tr>
	<tr>
		<td>形式7：</td>
		<td><input type="radio" <?php if($IK_SITE['base'][site_urltype]==7) { ?>
			checked="select" <?php } ?>  name="site_urltype" value="7" />
		group/topic/1/ (暂只支持apache环境的rewrite，非apache环境勿动)</td>
	</tr>            
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>
</form>

</div>

</div>
<?php include template('footer'); ?>
