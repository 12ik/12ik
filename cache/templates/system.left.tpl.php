<?php if($ik=='') { ?>
<li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">首页</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('system','main')?>" target="MainIframe">首页</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="javascript:void(0)" target="MainIframe">系统升级</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="javascript:void(0)" target="MainIframe">数据备份</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="javascript:void(0)" target="MainIframe">CNZZ统计</a></li>
    </ul>
</li>
<?php } ?>
<?php if($ik=='system') { ?>
<li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">系统管理</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('system','options')?>" target="MainIframe">站点配置</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('system','theme')?>" target="MainIframe">系统主题</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('system','urltype')?>" target="MainIframe">链接形式</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('system','cache')?>" target="MainIframe">缓存管理</a></li>
     </ul>
</li>    
<?php } ?>
<?php if($ik=='apps') { ?>
<li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">APP应用</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('system','apps',array('ik'=>'list'))?>" target="MainIframe">应用列表</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('system','installonline',array('ik'=>'list'))?>" target="MainIframe">安装应用</a></li>
     </ul>
</li>    
<?php } ?>