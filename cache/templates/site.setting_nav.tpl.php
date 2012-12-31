<ul class="type-nav">
    <li <?php if($ik=='remind'||$ik=='') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'remind',
    'siteid'=>$strSite['siteid']))?>">提醒</a></li>
    <li <?php if($ik=='postpermission') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'postpermission',
    'siteid'=>$strSite['siteid']))?>">权限</a></li>
    <li <?php if($ik=='log') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'log',
    'siteid'=>$strSite['siteid']))?>">日志</a></li>
    <li <?php if($ik=='kedou') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'kedou',
    'siteid'=>$strSite['siteid']))?>">客豆</a></li>
    <li <?php if($ik=='info') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'info',
    'siteid'=>$strSite['siteid']))?>">资料</a></li>
    <li <?php if($ik=='design') { ?> class="on" <?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'design',
    'siteid'=>$strSite['siteid']))?>">设计</a></li>
</ul>