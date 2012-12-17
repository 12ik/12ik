<div class="tabnav">
<ul>
<li <?php if($ac=='index') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('group','index')?>">最新话题</a></li>
<li <?php if($ac=='my' && $ts=='topic') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('group','my',array('ts'=>'topic'))?>">我发起的话题</a></li>
<li <?php if($ac=='my' && $ts=='reply') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('group','my',array('ts'=>'reply'))?>">我回复的话题</a></li>
<li <?php if($ac=='my' && $ts=='collect') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('group','my',array('ts'=>'collect'))?>">我收藏的话题</a></li>
</ul>
</div>
<div class="clear"></div>