<div id="db-usr-profile">
<div class="pic">
<a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$strUser['doname']))?>">
<img alt="<?php echo $strUser['username'];?>" src="<?php echo $strUser['face'];?>">
</a>
</div>
<div class="info">
<h1>
<?php echo $strUser['username'];?>
</h1>

<ul>
	<li><a href="<?php echo SITE_URL;?><?php echo tsurl('note','list',array('userid'=>$strUser['userid']))?>">日志</a></li>
    <li><a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array('userid'=>$strUser['userid']))?>">相册</a></li>
    <?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
    <li><a href="<?php echo SITE_URL;?>index.php?app=feed">广播</a></li>
    <li><a href="<?php echo SITE_URL;?><?php echo tsurl('message','ikmail',array(ts=>inbox))?>">站内信</a></li>
    <li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>">设置</a></li>
    <?php } ?>
</ul>

</div>
</div>
