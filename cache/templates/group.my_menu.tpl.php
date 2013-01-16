<div class="tabnav">
<ul>
<li <?php if($ac=='index') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','index')?>">最新话题</a></li>
<li <?php if($ac=='my' && $ik=='topic') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my',array('ik'=>'topic'))?>">我发起的话题</a></li>
<li <?php if($ac=='my' && $ik=='reply') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my',array('ik'=>'reply'))?>">我回复的话题</a></li>
<li <?php if($ac=='my' && $ik=='collect') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my',array('ik'=>'collect'))?>">我收藏的话题</a></li>
</ul>
</div>
<div class="clear"></div>