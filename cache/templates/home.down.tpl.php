<?php include template('header'); ?>

<div class="midder">
<div class="mc">
<h1><?php echo $title;?></h1>
<div class="cleft">
    <div class="infocontent">
    	<h2>最新版本下载：<font color="#CCCCCC">已被下载（<?php echo $countdown;?>）次</font></h2>
        <p>下载地址1：<a href="<?php echo SITE_URL;?><?php echo ikurl('home','down',array('id'=>'4'))?>" target="_blank">Admin5源码下载</a></p>
        <!--<p>下载地址2：<a href="<?php echo SITE_URL;?><?php echo ikurl('home','down',array('id'=>'1'))?>" target="_blank">中国站长站</a></p>-->
        <p>下载地址3：<a href="<?php echo SITE_URL;?><?php echo ikurl('home','down',array('id'=>'2'))?>" target="_blank">在本站下载</a></p>
        <p>下载地址4：<a href="<?php echo SITE_URL;?><?php echo ikurl('home','down',array('id'=>'3'))?>" target="_blank">在Github站下载</a></p>
                
        <h2>运行环境：</h2>
        <p>PHP5.2及以上版本，MySQL5.0及以上版本，推荐使用Linux + Apache环境的主机</p>	
        
        <h2>往期版本下载：</h2>
        <p>12ik-v1.0.zip <a href="http://www.12ik.com/uploadfile/12ik/12ik-v1.0.zip" target="_blank">在本站下载</a></p> 
        <br>
		<br>

        <p>本页持续更新中...</p>
       

    </div>
</div>

<div class="cright"><?php include template('menu'); ?></div>
</div>
</div>

<?php include template('footer'); ?>
