<h2>系统管理</h2>
<div class="tabnav">
<ul>
	<li <?php if($ac== 'options') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&ac=options">常规选项</a></li>

	<li <?php if($ac== 'theme') { ?> class="select"<?php } ?> ><a
		href="index.php?app=system&ac=theme">系统主题</a></li>

	<li <?php if($ac== 'urltype') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&ac=urltype">链接形式</a></li>
    <li <?php if($ac== 'cache') { ?> class="select"<?php } ?>><a
		href="index.php?app=system&ac=cache">缓存管理</a></li>

</ul>
</div>