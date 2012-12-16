<?php include template('header'); ?>

<!--main-->
<div class="midder"><?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=do&ts=options">
<table cellpadding="0" cellspacing="0">

	<tr>
		<td width="100">网站标题：</td>
		<td><input style="width: 300px;" name="site_title"
			value="<?php echo $strOption['site_title'];?>" /></td>
	</tr>
	<tr>
		<td>副标题：</td>
		<td><input style="width: 300px;" name="site_subtitle"
			value="<?php echo $strOption['site_subtitle'];?>" /> (例如：又一个爱客(12IK)社区小组)</td>
	</tr>

	<tr>
		<td>关键词：</td>
		<td><input style="width: 300px;" name="site_key"
			value="<?php echo $strOption['site_key'];?>" /> (关键词有助于SEO)</td>
	</tr>

	<tr>
		<td>网站说明：</td>
		<td><textarea
			style="width: 300px; height: 50px; font-size: 12px;" name="site_desc"><?php echo $strOption['site_desc'];?></textarea>
		(用简洁的文字描述本站点。)</td>
	</tr>

	<tr>
		<td>站点地址（URL）:</td>
		<td><input style="width: 300px;" name="site_url"
			value="<?php echo $strOption['site_url'];?>" />(必须以http://开头，以/结尾)</td>
	</tr>
	<tr>
		<td>电子邮件 :</td>
		<td><input style="width: 300px;" name="site_email"
			value="<?php echo $strOption['site_email'];?>" /></td>
	</tr>

	<tr>
		<td>ICP备案号 :</td>
		<td><input style="width: 300px;" name="site_icp"
			value="<?php echo $strOption['site_icp'];?>" /> （京ICP备09050100号）</td>
	</tr>

	<tr>
		<td>是否上传头像 :</td>
		<td><input type="radio" <?php if($strOption['isface']==
			'0') { ?> checked="select" <?php } ?>  name="isface" value="0" />不需要 <input
			type="radio" <?php if($strOption['isface']== '1') { ?> checked="select"
			<?php } ?>  name="isface" value="1" />需要</td>
	</tr>

	<tr>
		<td>是否邀请注册 :</td>
		<td><input type="radio" <?php if($strOption['isinvite']==
			'0') { ?> checked="select" <?php } ?>  name="isinvite" value="0" />开放注册 <input
			type="radio" <?php if($strOption['isinvite']== '1') { ?> checked="select"
			<?php } ?>  name="isinvite" value="1" />邀请注册 <input type="radio" <?php if($strOption['isinvite']==
			'2') { ?> checked="select" <?php } ?>  name="isinvite" value="2" />关闭注册</td>
	</tr>
	<tr>
		<td>Gzip压缩 :</td>
		<td><input type="radio" <?php if($strOption['isgzip']==
			'0') { ?> checked="select" <?php } ?> name="isgzip" value="0" />关闭 <input
			type="radio" <?php if($strOption['isgzip']== '1') { ?> checked="select"
			<?php } ?>  name="isgzip" value="1" />开启</td>
	</tr>

	<tr>
		<td>时区:</td>
		<td><select name="timezone">
			<?php foreach((array)$arrTime as $key=>$item) {?>
			<option <?php if($key==$strOption['timezone']) { ?> selected="selected"
				<?php } ?>  value="<?php echo $key;?>"><?php echo $item;?></option>
			<?php }?>
		</select></td>
	</tr>

	<tr>
		<td></td>
		<td><input type="submit" value="提 交" class="submit" /></td>
	</tr>
</table>
</form>
</div>

<?php include template('footer'); ?>
