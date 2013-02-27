<h2>相册管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&a=admin&mg=options">相册配置</a></li>

<li <?php if($mg=='album') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&a=admin&mg=album&ik=list">相册列表</a></li>

<li <?php if($mg=='photo') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=photo&a=admin&mg=photo&ik=list">图片列表</a></li>

</ul>
</div>