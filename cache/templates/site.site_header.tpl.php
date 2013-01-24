<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="<?php echo date("Y-m-d H:i:s");?>">
<meta name="robots" content="all" />
<meta name="Copyright" content="<?php echo $IK_SOFT['info'][name];?>" />
<meta name="keywords" content="<?php echo $title;?>" /> 
<meta name="description" content="<?php echo $strSite['sitedesc'];?>">
<title><?php echo $title;?></title>
<link rel="icon" type="image/ico" href="<?php echo SITE_URL;?>public/images/fav.ico">
<style>
@import url(<?php echo SITE_URL;?>app/<?php echo $app;?>/css/core.css);
@import url(<?php echo SITE_URL;?>app/<?php echo $app;?>/css/site/common.css);
<?php if($ac=='admins') { ?>
@import url(<?php echo SITE_URL;?>app/<?php echo $app;?>/css/site/setting.css);
<?php } ?>
</style>

<script>var siteUrl = '<?php echo SITE_URL;?>';</script>
<script src="<?php echo SITE_URL;?>public/js/IK.js" type="text/javascript" data-cfg-corelib="<?php echo SITE_URL;?>public/js/jquery.js"></script>

<script type="text/javascript">
IK.add('common', {path: '<?php echo SITE_URL;?>app/site/js/common.js', type: 'js'});
IK.add('sharetool', {path: '<?php echo SITE_URL;?>public/js/lib/sharetool.js', type: 'js' , requires: ['common']});
IK.add('common-eventhandler', {path: '<?php echo SITE_URL;?>app/site/js/common_eventhandler.js', type: 'js', requires: ['common']});
IK.add('setting-eventhandler', {path: '<?php echo SITE_URL;?>app/site/js/setting_eventhandler.js', type: 'js', requires: ['common']});
IK.add('dialog-css', {path: '<?php echo SITE_URL;?>public/css/ui/dialog.css', type: 'css'});
IK.add('dialog', {path: '<?php echo SITE_URL;?>public/js/ui/dialog.js', type: 'js', requires: ['dialog-css']});
//Do.add('swf', {path: '<?php echo SITE_URL;?>public/js/swfobject.js', type: 'js'});
//Do.add('video', {path: '<?php echo SITE_URL;?>public/js/site/video.js', type: 'js'});
//Do.add('artist', {path: '<?php echo SITE_URL;?>public/js/site/artist.js', type: 'js', requires: ['swf']});
IK.add('slider', {path: '<?php echo SITE_URL;?>app/site/js/slider.js', type: 'js'});
IK.add('effects', {path: '<?php echo SITE_URL;?>public/js/ui/jquery-ui-effects-core.min.js', type: 'js'});
IK.add('room-setting', {path: '<?php echo SITE_URL;?>app/site/js/room-setting.js', type: 'js'});
IK.add('room-action', {path: '<?php echo SITE_URL;?>app/site/js/room-action.js', type: 'js' , requires: ['common']});
IK.global('common', 'common-eventhandler');

var STATIC_FILE_VER = '53019';
var roomHoverColor = 'rgb(90,83,12)';
</script>

<?php if($strSite['istheme'] == 0) { ?>

    <link id="sys-theme" rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/css/site/theme/1/core.css" />
    <style id="init-theme">
    #theme-bg {background-color: #e7e3cd}
    #theme-banner {background-color:#f56147}
    #theme-tag-bg {background-color:#7a7643}
    #theme-tag-link {background-color:#7b6363}
    #theme-link {background-color: #938c1b}
    </style>

<?php } else { ?>

    <?php if($strTheme['theme_id'] == 0) { ?>
<link id="sys-theme" rel="stylesheet" type="text/css" href="" />
    <?php } else { ?>
<link id="sys-theme" rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/css/site/theme/<?php echo $strTheme['theme_id'];?>/core.css" />   
    <?php } ?>

<style id="init-theme">
#theme-bg {background-color: <?php echo $strTheme['background_color'];?>}
#theme-banner {background-color: <?php echo $strTheme['banner_color'];?>}
#theme-tag-bg {background-color: <?php echo $strTheme['tab_color'];?>}
#theme-tag-link {background-color: <?php echo $strTheme['tab_link_color'];?>}
#theme-link {background-color: <?php echo $strTheme['link_color'];?>}
</style>
<style id="custom-theme">
/* global custom theme */

<?php if($strTheme['background_color']) { ?>
.bg { background-color: <?php echo $strTheme['background_color'];?> }
<?php } ?>

<?php if($strTheme['background_cancel']=='true' ) { ?>
.bg { background-image: none}
<?php } ?>
<?php if($strTheme['background_cancel']=='false' && $strTheme['background_image']!='') { ?>
.bg { background-image:url(<?php echo SITE_URL;?>uploadfile/site/custom/theme/<?php echo $strTheme['background_ver'];?>/<?php echo $strTheme['background_image'];?>?ver=<?php echo $strTheme['background_ver'];?>);}
<?php } ?>

.bg .mask { display: none }
<?php if($strTheme['background_pos']) { ?>
.bg { background-position: <?php echo $strTheme['background_pos'];?> top }
<?php } ?>
<?php if($strTheme['background_repeat']) { ?>
.bg { background-repeat: <?php echo $strTheme['background_repeat'];?> }
<?php } ?>

<?php if($strTheme['link_color']) { ?>
.top-nav a:link, .top-nav a:visited, .top-nav a:hover, .top-nav a:active, .mod a, #footer a, .content-nav a { color: <?php echo $strTheme['link_color'];?>}
.top-nav .top-nav-info a:hover, .mod a:hover, #footer a:hover, .content-nav a:hover { color: #fff; background-color: <?php echo $strTheme['link_color'];?> }
<?php } ?>

<?php if($strTheme['banner_color']) { ?>
.sp-nav { background-color: <?php echo $strTheme['banner_color'];?> }
<?php } ?>

<?php if($strTheme['tab_color']) { ?>
.nav-items li { background-color: <?php echo $strTheme['tab_color'];?> }
.nav-items li.on { border-color: <?php echo $strTheme['tab_color'];?> }
.nav-items li#room-more ul { border-color: <?php echo $strTheme['tab_color'];?>; }
<?php } ?>
<?php if($strTheme['tab_link_color']) { ?>
.nav-items li a:link,
.nav-items li a:visited { color: <?php echo $strTheme['tab_link_color'];?> }
<?php } ?>

<?php if($strTheme['tab_color']) { ?>
.nav-items li a:hover { background-color: <?php echo $strTheme['tab_color'];?>; }
<?php } ?>

<?php if($strTheme['tab_color'] ||  $strTheme['tab_link_color'] ) { ?>
.nav-items li#room-more li a:hover { background-color: <?php echo $strTheme['tab_color'];?> ;color: <?php echo $strTheme['tab_link_color'];?> }
.type-nav .on a, .type-nav a:hover{ background-color: <?php echo $strTheme['tab_color'];?>; color:#fff}
<?php } ?>
</style>
<?php } ?>


</head>
<body id="<?php echo $strSite['siteid'];?>">
<div class="wrapper">