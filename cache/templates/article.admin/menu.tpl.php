<h2>配置管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select"  <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=options">配置</a></li>

<li  <?php if($mg=='article' && $ik=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=article&ik=list">文章管理</a></li>

<li  <?php if($mg=='channel' && $ik=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ik=list">频道列表</a></li>

<li  <?php if($mg=='channel' && $ik=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ik=add">添加频道</a></li>

<?php if($mg=='channel' && $ik=='edit') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=channel&ik=edit">编辑频道</a></li><?php } ?>
<?php if($mg=='cate' && $ik=='list') { ?><li class="select"><a href="#">分类管理</a></li><?php } ?>

<?php if($mg=='cate' && $ik=='edit') { ?><li class="select"><a href="#">编辑分类</a></li><?php } ?>


</ul>
</div>