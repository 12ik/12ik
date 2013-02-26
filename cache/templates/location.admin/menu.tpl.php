<h2>区域管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=options">区域配置</a></li>

<li <?php if($mg=='list' && $ik=='one') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=list&ik=one">顶级区域列表</a></li>

<?php if($mg=='list' && $ik=='two') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=list&ik=two&referid=<?php echo $referid;?>">二级区域列表</a></li><?php } ?>

<?php if($mg=='list' && $ik=='three') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=list&ik=three&referid=<?php echo $referid;?>">三级区域列表</a></li><?php } ?>

<?php if($mg=='edit') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=edit&areaid=<?php echo $strArea['areaid'];?>">修改区域名称</a></li><?php } ?>

<li <?php if($mg=='add' && $ik=='one') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=add&ik=one">添加顶级区域</a></li>

<?php if($mg=='add' && $ik==two) { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=add&ik=two&referid=<?php echo $referid;?>">添加二级区域</a></li><?php } ?>

<?php if($mg=='add' && $ik==three) { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=location&ac=admin&mg=add&ik=three&referid=<?php echo $referid;?>">添加三级区域</a></li><?php } ?>

<li <?php if($mg=='plugin') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=<?php echo $app;?>&ac=admin&mg=plugin&ik=list">插件管理</a></li>

</ul>
</div>