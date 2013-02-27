<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="160780470@qq.com" />
<meta name="Copyright" content="<?php echo $IK_SOFT['info'][copyright];?>" />
<title><?php echo $title;?> - <?php echo $IK_APP['options'][appname];?> -
<?php echo $IK_SITE['base'][site_title];?></title>
<link type="text/css" rel="stylesheet" href="app/<?php echo $app;?>/skins/<?php echo $skin;?>/main.css" id="skin" />
<script src="public/js/jquery.js" type="text/javascript"></script>
<script language="javascript">
$(function(){
	//窗口
	var set_h = function(){
        var heights = document.documentElement.clientHeight-80;
        $("#MainIframe, .menubox").height(heights-9);
        $('body').css('overflow','hidden');
    }
    $(window).resize(function(){
        set_h();
    });
    set_h();
	//菜单事件
    //默认载入左侧菜单
    $('.MenuList').load($('.MenuList').attr('data-uri'));
	//左侧菜单收缩
	$('.actuator').live('click',function(){
		var _self = $(this), par = _self.parent();
		if(par.attr('class')=='treemenu_on')
		{
			par.removeClass().addClass('treemenu_off');
			par.find('.submenu').slideUp(100);
		}else{
			par.removeClass().addClass('treemenu_on');
			par.find('.submenu').slideDown(100);
		}		
	});	

    //顶部菜单点击
    $('#topnav a').live('click', function(){
        var data_id = $(this).attr('data-id');
        //改变样式
        $(this).parent().addClass("on").siblings().removeClass("on");
        //改变左侧
		$.get($('.MenuList').attr('data-uri'), { ik: data_id },
			function(data){
				$('.MenuList').html(data);
				$('#MainIframe').attr('src',$('.MenuList li ul li a').attr('href'));
		});
    });	
	$('.submenu li').live('click',function(){
		$('.submenu li').each(function(i){
			$(this).find('a').removeClass();
		});
		$(this).find('a').removeClass().addClass('submenuB');
	});
});
function refresh() {
	parent.MainIframe.location.reload();
}
</script>
</head>
<body scroll="no" style="margin:0; padding:0;">

<div class="header">
    <div class="logo"><a href="<?php echo U('home')?>" >&nbsp;</a></div>
    <div class="nav_sub">
       您好,<?php echo $IK_USER['admin'][username];?>&nbsp; | <a href="<?php echo SITE_URL;?>" target="_blank">返回前台</a> | 
       <a href="javascript:void(0);" onclick="refresh();">刷新</a> | 
       <a href="<?php echo U('system','login',array('ik'=>'out'))?>">[退出]</a><br>    
    </div>
    <div class="nav" id="topnav">
         <li class="on"><a style="outline:none;" hidefocus="true" data-id="" href="javascript:;">首页</a></li>
         <li><a style="outline:none;" hidefocus="true" data-id="system" href="javascript:;">系统管理</a></li>
         <li><a style="outline:none;" hidefocus="true" data-id="apps" href="javascript:;">APP应用</a></li>
         <li><a style="outline:none;" hidefocus="true" data-id="pubs" href="javascript:;">插件管理</a></li>
    </div>                   
</div>
<div class="LeftMenu">
    <div class="menubox">
        <ul id="root_index" class="MenuList" data-uri="<?php echo U('system','left')?>"></ul>
        <div class="cl"></div>
    </div>
                        
</div>

<div class="right_main">
	<div class="header_line"><span>&nbsp;</span></div>
	<iframe width="100%" scrolling="yes" height="100%" frameborder="0" noresize="" src="<?php echo U('system','main')?>" name="MainIframe" id="MainIframe"></iframe>
</div>

</body>
</html>
