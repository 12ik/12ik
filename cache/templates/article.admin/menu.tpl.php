<h2>配置管理</h2>
<div class="tabnav">
<ul>
<li  <?php if($mg=='options') { ?> class="select"  <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=options">配置</a></li>

<li  <?php if($mg=='article' && $ts=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=article&ts=list">文章管理</a></li>

<li  <?php if($mg=='channel' && $ts=='list') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ts=list">频道列表</a></li>

<li  <?php if($mg=='channel' && $ts=='add') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?>index.php?app=article&ac=admin&mg=channel&ts=add">添加频道</a></li>

<?php if($mg=='channel' && $ts=='edit') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=channel&ts=edit}">编辑频道</a></li><?php } ?>
<?php if($mg=='cate' && $ts=='list') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=cate&ts=list}">分类管理</a></li><?php } ?>
<?php if($mg=='cate' && $ts=='edit') { ?><li class="select"><a href="#">编辑分类</a></li><?php } ?>


</ul>
</div>