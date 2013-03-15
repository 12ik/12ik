<div class="tabnav">
    <ul>
<!--
<li <?php if($ik=="notification") { ?> class="select" <?php } ?> >
<a href="<?php echo U('message','ikmail',array(ik=>notification))?>">提醒</a>
</li>
-->
<li <?php if($ik=="outbox") { ?>class="select"<?php } ?> ><a href="<?php echo U('message','ikmail',array(ik=>outbox))?>">发件箱</a></li>
<li <?php if($ik=="inbox" || $ik=="spam" || $ik=="unread") { ?>class="select"<?php } ?> ><a href="<?php echo U('message','ikmail',array(ik=>inbox))?>">收件箱</a></li>
    </ul>
</div>