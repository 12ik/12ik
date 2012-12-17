<h1><?php echo $title;?></h1>
<div class="tabnav">
<ul>
<li <?php if($ts=="edit") { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('note','cate',array('ts'=>'edit'))?>">全部分类</a></li>
</ul>
</div>