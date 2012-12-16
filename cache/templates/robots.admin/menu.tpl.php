<h2>首页管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=robots&ac=admin&mg=options">机器人配置</a></li>

<li  <?php if($mg=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=robots&ac=admin&mg=list">机器人列表</a></li>

<li  <?php if($mg=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=robots&ac=admin&mg=add">添加新机器人</a></li>



</ul>
</div>