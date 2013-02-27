<h2>用户管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=options">用户配置</a></li>
<li <?php if($mg=='user' && $ik=='list') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=user&ik=list">用户管理</a></li>

<?php if($mg=='user' && $ik=='view') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=user&ik=list"><?php echo $strUser['username'];?>用户信息</a></li>
<?php } ?>
</ul>
</div>