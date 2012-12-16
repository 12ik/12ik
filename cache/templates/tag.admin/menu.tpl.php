<h2>标签管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tag&ac=admin&mg=options">标签配置</a></li>
<li <?php if($mg=='list') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tag&ac=admin&mg=list">全部标签</a></li>
</ul>
</div>