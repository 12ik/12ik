<h2>系统管理</h2>
<div class="tabnav">
<ul>
	<li <?php if($a== 'options') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&a=options">常规选项</a></li>

	<li <?php if($a== 'theme') { ?> class="select"<?php } ?> ><a
		href="index.php?app=system&a=theme">系统主题</a></li>

	<li <?php if($a== 'urltype') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&a=urltype">链接形式</a></li>
    <li <?php if($a== 'cache') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&a=cache">缓存管理</a></li>

</ul>
</div>