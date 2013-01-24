<h2>小组管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=options">小组配置</a></li>
<li <?php if($mg=='group' && $ik=='list') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ik=list">全部小组</a></li>
</ul>
</div>