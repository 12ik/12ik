<?php if($IK_SITE['base'][isgzip]==1) { ?><?php ob_start('ob_gzip');?><?php } ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="all" />
<meta name="author" content="<?php echo $IK_SOFT['info'][email];?>" />
<meta name="Copyright" content="<?php echo $IK_SOFT['info'][name];?>" />
<meta name="baidu_union_verify" content="f67264028a31c2617ff3b5c78113034e">
<title>
<?php if($a=='index') { ?>
<?php echo $IK_SITE['base'][site_title];?> - <?php echo $title;?>
<?php } else { ?>
<?php echo $title;?> - <?php echo $IK_APP['options'][appname];?>
<?php } ?>
</title>
<?php if($app=='home' && $a=='index') { ?>
<meta name="keywords" content="<?php echo $IK_SITE['base'][site_key];?>" /> 
<meta name="description" content="<?php echo $IK_SITE['base'][site_desc];?>" /> 
<?php } ?>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>public/images/fav.ico" type="image/x-icon">
<style>
<?php if(is_file('theme/'.$site_theme.'/base.css')) { ?>
@import url(<?php echo SITE_URL;?>theme/<?php echo $site_theme;?>/base.css);
<?php } ?>
<?php if(is_file('app/'.$app.'/skins/'.$skin.'/style.css')) { ?>
@import url(<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/style.css);
<?php } ?>
</style>
<!--[if gte IE 7]><!-->
    <link href="<?php echo SITE_URL;?>public/js/dialog/skins5/idialog.css" rel="stylesheet" />
<!--<![endif]-->
<!--[if lt IE 7]>
    <link href="<?php echo SITE_URL;?>public/js/dialog/skins5/idialog.css" rel="stylesheet" />
<![endif]-->
<script>var siteUrl = '<?php echo SITE_URL;?>';</script>
<script src="<?php echo SITE_URL;?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/common.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/all.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="<?php echo SITE_URL;?>public/js/html5.js"></script>
<![endif]-->
<script src="<?php echo SITE_URL;?>public/js/dialog/jquery.artDialog.min5.js" type="text/javascript"></script>
<?php if(is_file('app/'.$app.'/js/extend.func.js')) { ?>
<script src="<?php echo SITE_URL;?>app/<?php echo $app;?>/js/extend.func.js" type="text/javascript"></script>
<?php } ?>
<?php doAction('pub_header_top')?>
</head>
<body>
<header>
<div class="top_nav">
  <div class="top_bd">
    
    <div class="top_info">
        <?php if($IK_USER['user'] == '') { ?>
		<a href="<?php echo U('user','login')?>">登录</a> | <a href="<?php echo U('user','register')?>">注册</a>       
        <?php } else { ?>
        <a id="newmsg" href="<?php echo U('message','ikmail',array(ik=>inbox))?>"></a> | 
        <?php $globalUser = aac('user')->getOneUser($IK_USER['user'][userid]);?>
        <a href="<?php echo U('hi','',array('id'=>$globalUser['doname']))?>">
        <?php echo $globalUser['username'];?>
        </a> | 
        <a href="<?php echo U('user','set',array(ik=>base))?>">设置</a> | 
        <a href="<?php echo U('user','login',array(ik=>out))?>">退出</a>
        <?php } ?>
    </div>


    <div class="top_items">
        <ul>
                <li>
                <a href="<?php echo SITE_URL;?>">爱客</a>
                </li>             
                <li>
                <a href="<?php echo U('location')?>">同城</a>
                </li>
                <li>
                <a href="<?php echo U('group')?>">小组</a>
                </li>
                <li>
                <a href="<?php echo U('haomiwo')?>" target="_blank">好米窝</a>
                </li> 
                <li><a href="<?php echo U('article')?>">文章</a></li>
<!--                 <li><a href="<?php echo U('tribe')?>">部落</a></li> -->
                <li><a href="<?php echo U('home','down')?>">源码下载</a></li>                                              

        </ul>
    </div>
  
  	<div class="cl"></div>
    
  </div>
  
</div>
<!--header-->


<div id="header">
    
	<div class="site_nav">
    	<?php if($app == 'group' ) { ?>
        <div class="site_logo nav_logo">
            <a href="<?php echo U('group','')?>">爱客小组</a>
        </div>
        <?php } else { ?>
        <div class="site_logo">
            <a href="<?php echo SITE_URL;?>" title="<?php echo $IK_SITE['base'][site_title];?>"><?php echo $IK_SITE['base'][site_title];?></a>
        </div>        
        <?php } ?> 
         
         
        <?php if($IK_USER['user'] == '') { ?>
         
        <?php if(is_array($IK_SITE['appnav']) && $IK_SITE['appnav'][$app] !='') { ?>
        <div class="appnav">
            <ul id="nav_bar">
                <?php foreach((array)$IK_SITE['appnav'] as $key=>$item) {?>
                <li  <?php if($app==$key) { ?> class="select" <?php } ?> ><a href="<?php echo U($key)?>"><?php echo $item;?></a></li>
                <?php }?>
                <li><a href="<?php echo U('home','down')?>">源码下载</a></li>
            </ul>
           <form action="<?php echo SITE_URL;?>index.php"  method="get" onsubmit="return searchForm(this);">
           <input type="hidden" name="app" value="search" /><input type="hidden" name="ac" value="q" />
            <div id="search_bar">
            	<div class="inp"><input type="text" name="kw"  class="key" value="小组、话题、日志、成员、小站" placeholder="小组、话题、日志、成员、小站"/></div>
                <div class="inp-btn"><input type="submit"  value="搜索" class="search-button"/></div>
            </div>
            </form>
        </div>
        <?php } ?>
        <?php } else { ?>
        	<?php if($app == 'group' ) { ?>
            <div class="appnav">
                <ul id="nav_bar">
                    <li><a href="<?php echo U('group','')?>">我的小组</a></li>
                    <li><a href="<?php echo U('group','explore')?>">发现小组</a></li>
                    <li><a href="<?php echo U('group','explore_topic')?>">发现话题</a></li>
                    <li><a href="<?php echo U('group','nearby',array('ik'=>'beijing'))?>">北京话题</a></li>
                </ul>
               <form action="<?php echo SITE_URL;?>index.php"  method="get" onsubmit="return searchForm(this);">
               <input type="hidden" name="app" value="search" /><input type="hidden" name="ac" value="q" />
                <div id="search_bar">
                    <div class="inp"><input type="text" name="kw"  class="key" value="小组、话题、日志、成员、小站" placeholder="小组、话题、日志、成员、小站"/></div>
                    <div class="inp-btn"><input type="submit"  value="搜索" class="search-button"/></div>
                </div>
                </form>
            </div>
            <?php } else { ?>
            <div class="appnav">
                <ul id="nav_bar">
                    <li><a href="<?php echo SITE_URL;?>">首页</a></li>
                    <li><a href="<?php echo U('feed')?>">友邻广播</a></li>
                    <li><a href="<?php echo U('hi','',array('id'=>$globalUser['doname']))?>">我的爱客</a></li>
                    <li><a href="<?php echo U('group')?>">我的小组</a></li>
                    <li><a href="<?php echo U('site')?>">我的小站</a></li>
                    <li><a href="<?php echo U('article')?>">文章</a></li>
                    <li><a href="<?php echo U('tribe')?>">部落</a></li>
                    
                </ul>
               <form action="<?php echo SITE_URL;?>index.php"  method="get" onsubmit="return searchForm(this);">
               <input type="hidden" name="app" value="search" /><input type="hidden" name="ac" value="q" />
                <div id="search_bar">
                    <div class="inp"><input type="text" name="kw"  class="key" value="小组、话题、日志、成员、小站" placeholder="小组、话题、日志、成员、小站"/></div>
                    <div class="inp-btn"><input type="submit"  value="搜索" class="search-button"/></div>
                </div>
                </form>
            </div>            
            <?php } ?>
                    	
        <?php } ?>
        
        
		
        <div class="cl"></div>

	</div>
        
</div>
<!--APP NAV-->

</header>


