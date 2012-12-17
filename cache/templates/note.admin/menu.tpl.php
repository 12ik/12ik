<h2>配置管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select"  <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=options">配置</a></li>

<li  <?php if($mg=='note' && $ts=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=note&ts=list">全部日志</a></li>

<li  <?php if($mg=='cate' && $st=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=cate&ts=list">日志分类</a></li>

<li  <?php if($mg=='cate' && $st=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&ac=admin&mg=cate&ts=add">添加分类</a></li>

</ul>
</div>