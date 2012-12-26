<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php include template('site_header'); ?>
</head>

<body>

<div class="wrapper">
<!--头部-->
<?php include template('site_nav'); ?>
<!--//头部-->
<!--内容-->
<div id="content">
    <!--main-->
    <div class="main">           
        <h1>小站管理</h1>               
        <div class="mod" id="sp-setting">
            <div class="hd">
					<?php include template('setting_nav'); ?>
            </div>
        
            <div class="mod notification-items">
                <div class="bd">
                    <ul style="text-align:center" class="old">目前没有新的提醒了</ul>
                </div>
            </div>
        </div>
    </div>
    <!--//main-->
    
     <!--aside-->    
    <div class="aside">
        <?php include template('admins_aside'); ?>
    </div>
    <!--//aside-->  
 

    <div class="extra">
            
    </div>
 
</div>
<!--//内容-->
<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->
    
</div>

<div class="bg">&nbsp;<div class="mask">&nbsp;</div></div>
</body>
</html>
