<?php include template('header'); ?>

<div class="midder">
<div class="mc">
<h1><?php echo $title;?></h1>
<div class="cleft">
    <div class="infocontent">
    	<h2>最新版本下载：<font color="#CCCCCC">已下载（<?php echo $countdown;?>）</font></h2>
        <p>下载地址1：<a href="<?php echo SITE_URL;?><?php echo tsurl('home','down',array('id'=>'1'))?>#down" target="_blank">在中国站长站下载</a></p>
        <p>下载地址2：<a href="<?php echo SITE_URL;?><?php echo tsurl('home','down',array('id'=>'2'))?>" target="_blank">在本站下载</a></p>
        <p>下载地址3：<a href="<?php echo SITE_URL;?><?php echo tsurl('home','down',array('id'=>'3'))?>" target="_blank">在Github站下载</a></p>
                
        <h2>运行环境：</h2>
        <p>PHP5.2及以上版本，MySQL5.0及以上版本，推荐使用Linux + Apache环境的主机</p>	
        
        <br>
		<br>

        <p>本页持续更新中...</p>
       

    </div>
</div>

<div class="cright"><?php include template('menu'); ?></div>
</div>
</div>

<?php include template('footer'); ?>
