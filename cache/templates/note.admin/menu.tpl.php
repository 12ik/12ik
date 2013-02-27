<h2>配置管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select"  <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&a=admin&mg=options">配置</a></li>

<li  <?php if($mg=='note' && $ik=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&a=admin&mg=note&ik=list">全部日志</a></li>

<li  <?php if($mg=='cate' && $st=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&a=admin&mg=cate&ik=list">日志分类</a></li>

<li  <?php if($mg=='cate' && $st=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=note&a=admin&mg=cate&ik=add">添加分类</a></li>

</ul>
</div>