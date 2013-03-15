<h1>更改<?php echo $strGroup['groupname'];?>设置</h1>
<div class="tabnav">
<ul>
<li <?php if($ik=="base") { ?>class="select"<?php } ?>><a href="<?php echo U('group','edit',array('ik'=>'base','groupid'=>$strGroup['groupid']))?>">基本信息</a></li>

<li <?php if($ik=="icon") { ?>class="select"<?php } ?>><a href="<?php echo U('group','edit',array('ik'=>'icon','groupid'=>$strGroup['groupid']))?>">小组图标</a></li>

</ul>
</div>