<div id="header">
       <div class="top-nav">
            <a class="logo" href="<?php echo SITE_URL;?>" title="<?php echo $IK_SITE['base'][site_title];?>"><?php echo $IK_SITE['base'][site_title];?></a>
            <div class="top-nav-info">
                <?php if($IK_USER['user'] == '') { ?>
				<a href="<?php echo SITE_URL;?><?php echo tsurl('user','login')?>">登录</a> <a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">注册</a>       
                <?php } else { ?>
                <a id="newmsg" href="<?php echo SITE_URL;?><?php echo tsurl('message','ikmail',array(ts=>inbox))?>">新消息</em></a>
                <a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>" target="_blank"><?php echo $IK_USER['user'][username];?>的帐号</a>
                <a href="<?php echo SITE_URL;?><?php echo tsurl('user','login',array(ts=>out))?>">退出</a>
                <?php } ?>                
                
            </div>
       </div>
       
<div class="sp-nav">
<!--sp-logo-->
<div class="sp-logo">
    <a class="logo" 
    href="<?php echo SITE_URL;?><?php echo tsurl('site','mine',array('siteid'=>$strSite['siteid']))?>" 
    title="<?php echo $strSite['sitename'];?>">
    <img width="48" height="48" style="background:url(<?php echo $strSite['icon_48'];?>) no-repeat 0 0;" 
    src="<?php echo SITE_URL;?>public/images/blank.gif" alt="<?php echo $strSite['sitename'];?>"><?php echo $strSite['sitename'];?></a>
</div>
<!--nav-items--> 
<div class="nav-items">
<ul>                    
<?php foreach((array)$strNavs as $item) {?>
<li <?php if($item['roomid'] == $roomid) { ?> class="on" <?php } ?>>
    <a hidefocus="true" href="<?php echo SITE_URL;?><?php echo tsurl('site','room',array('siteid'=>$strSite['siteid'],'roomid'=>$item['roomid']))?>" roomid="<?php echo $item['roomid'];?>">
         <span><?php echo $item['name'];?></span><?php if($item['roomid'] == $roomid && $strSite['userid'] == $IK_USER['user'][userid] ) { ?><em title="房间设置">房间设置</em> <?php } ?>
    </a>
</li>
<?php } ?>
<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?>
<li class="opt" id="room-admin">
	<a href="<?php echo SITE_URL;?><?php echo tsurl('site','admins',array('siteid'=>$strSite['siteid']))?>" id="admin-icon" title="管理小站">管理小站</a>
    <div class="user-guide" style="display:none">
        <em></em>
        <h1>小站设置</h1>
        <span>1/2</span>
        <p>16套主题模板，让你的小站与众不同。</p><a class="lnk-add" href="#" id="next-step">知道了</a>
    </div>
</li>
<?php } ?>
</ul>
</div>
<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?>
<script>
<?php if(empty($strLeftMod) && empty($strRightMod) && $isRoomEmpty==1) { ?>
var isRoomEmpty = true;//页面空 true 否则false
<?php } else { ?>
var isRoomEmpty = false; //页面空 true 否则false
<?php } ?>
<?php if($strSite['issetting']==0) { ?>
var isSiteFirstEnter = true;//页面空 true 否则false
<?php } else { ?>
var isSiteFirstEnter = false;//页面空 true 否则false
<?php } ?>
IK('slider', 'room-setting');
IK(function(){$(function(){$('.mod:has(.edit)').live('mouseenter', function(e){ $(e.currentTarget).addClass('mod-stat-active'); }).live('mouseleave', function(e){ $(e.currentTarget).removeClass('mod-stat-active');});});});
</script>
<?php } ?>
</div>
<!--//sp-nav-->

<?php if($roomid>0 && $strSite['userid'] == $IK_USER['user'][userid]) { ?>   
<!--sp-fn-box-->    
    <div class="sp-fn-box">
        <a href="#" class="box-close" style="display: block;">x</a>
        <div class="room-box" style="display: inline-block;">
            <input type="text" maxlength="15" value="<?php echo $strRoom['name'];?>" id="room-rename" roomid="<?php echo $roomid;?>" >
            <label class="icon-save">保存</label>
            <span class="widget-tips selected" id="type-normal">小站公共应用<em>▶</em></span>
            <span class="widget-tips" id="type-game">游戏应用<em>▶</em></span>
            <a class="room-del" hidefocus="true" id="room_1650259" href="javascript:;">删除房间</a>
        </div>
    
        <div id="widget-normal" class="widgets-box" style="display: inline-block;">
        <div class="widgets-slider">
        <ul class="list-s slider">
        <?php foreach((array)$strWidgets as $item) {?>
            <li>
                <div class="intro">
                <h2><?php echo $item['widgetname'];?></h2>
                <p><?php echo $item['widgetdesc'];?></p>
                </div>
            	<a class="lnk-add" id="k-<?php echo $item['othername'];?>" roomid="<?php echo $roomid;?>" href="#">添加</a>
            </li>
         <?php } ?>
        </ul>
        </div>
        <div class="slider-switcher">
            <ul class="list-s switcher-dot"></ul>
            <span class="switcher-prev switcher-dis">&lt;</span>
            <span class="switcher-next">&gt;</span>
        </div>
        </div>
    </div>
<!--//sp-fn-box-->    
<?php } ?>
</div><!--//header-->


