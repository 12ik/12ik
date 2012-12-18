<h2>配置管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select"  <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=options">配置</a></li>

<li  <?php if($mg=='article' && $ts=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=article&ts=list">文章管理</a></li>

<li  <?php if($mg=='cate' && $ts=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=cate&ts=list">频道分类</a></li>

<li  <?php if($mg=='channel' && $ts=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ts=add">添加频道</a></li>

</ul>
</div>