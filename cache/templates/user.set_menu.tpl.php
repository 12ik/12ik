<h1 class="set_tit">用户信息管理</h1>
<div class="tabnav">
<ul>
<li <?php if($ik=="base") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>base))?>">基本信息</a></li>
<li <?php if($ik=="face") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>face))?>">会员头像</a></li>
<li <?php if($ik=="doname") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>doname))?>">个性域名</a></li>
<li <?php if($ik=="city") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>city))?>">常居地</a></li>
<li <?php if($ik=="tag") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>tag))?>">个人标签</a></li>
<li <?php if($ik=="pwd") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>pwd))?>">修改密码</a></li>
</ul>
</div>