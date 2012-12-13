<div class="clear"></div>
<div class="tabnav">
<ul>

<li  <?php if($ac=='album' && $ts=='user') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array('ts'=>'user','userid'=>$userid))?>">
<?php echo $title;?></a></li>


<?php if(intval($IK_USER['user'][userid]) > '0') { ?>
<li  <?php if($ac=='album' && $ts=='create') { ?> class="select" <?php } ?> ><a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array('ts'=>'create'))?>">+创建新相册</a></li>
<?php } ?>
</ul>
</div>
<div class="clear"></div>