<?php include template('header'); ?>

<!--main-->
<div class="midder">
<h2><?php echo $title;?></h2>
<form method="POST" action="index.php?app=system&a=do&ik=options">
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
		<td>网站编码:</td>
		<td><input style="width: 300px;" name="charset"
			value="<?php echo $strOption['charset'];?>" readonly /> （默认UTF-8）请勿更改</td>
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
			<option <?php if($key==$strOption['timezone']) { ?> selected="selected" <?php } ?>  value="<?php echo $key;?>"><?php echo $item;?></option>
			<?php }?>
		</select></td>
	</tr>
</table>

<h2>缩略图设置</h2>
<table cellpadding="0" cellspacing="0">

	<tr>
		<td>缩略图宽:</td>
		<td><input style="width: 300px;" name="thumbwidth"
			value="<?php echo $strOption['thumbwidth'];?>" /> （默认规格400）</td>
	</tr>
	<tr>
		<td>缩略图高:</td>
		<td><input style="width: 300px;" name="thumbheight"
			value="<?php echo $strOption['thumbheight'];?>" /> （默认规格300）</td>
	</tr>
</table>

<h2>本地路径设置</h2>
<table cellpadding="0" cellspacing="0">

	<tr>
		<td>站点附件目录:</td>
		<td><input style="width: 300px;" name="attachmentdir"
			value="<?php echo $strOption['attachmentdir'];?>" /> （默认：uploadfile/attachments <font color="red">注意：开头不加/ 末尾必须加 / </font>）</td>
	</tr>
     <tr>
		<td>站点附件归类方式:</td>
		<td>
        
        <select name="attachmentdirtype">
            <option value="all" <?php if($strOption['attachmentdirtype']== all) { ?> selected<?php } ?>>不归类</option>
            <option value="year" <?php if($strOption['attachmentdirtype']== year) { ?> selected<?php } ?>>按年归类</option>
            <option value="month" <?php if($strOption['attachmentdirtype']== month) { ?> selected<?php } ?>>按月归类</option>
            <option value="day" <?php if($strOption['attachmentdirtype']== day) { ?> selected<?php } ?>>按天归类</option>
            <option value="md5" <?php if($strOption['attachmentdirtype']== md5) { ?> selected<?php } ?>>随机归类</option>
        </select>
         （如：2012/12/11/1_a.jpg）
       </td>
	</tr>
    
</table>

<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>

<?php include template('footer'); ?>
