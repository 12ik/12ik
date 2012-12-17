<h1 class="set_tit">用户信息管理</h1>
<div class="tabnav">
<ul>
<li <?php if($ts=="base") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>">基本信息</a></li>
<li <?php if($ts=="face") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>face))?>">会员头像</a></li>
<li <?php if($ts=="doname") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>doname))?>">个性域名</a></li>
<li <?php if($ts=="city") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>city))?>">常居地</a></li>
<li <?php if($ts=="tag") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>tag))?>">个人标签</a></li>
<li <?php if($ts=="pwd") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>pwd))?>">修改密码</a></li>
</ul>
</div>