 <!--头部-->
<?php include template('site_header'); ?>
<!--//头部-->
<!--导航-->
<?php include template('site_nav'); ?>
<!--//导航-->
 
<!--内容-->
<div id="content">
    <!--main-->

<style>

</style>  

    <div class="main"> 
        <h1><?php echo $title;?></h1>         
        <div class="mod">
            	

<div class="bd">


<div id="db-photo-view">
  <div id="link-report">
    <div class="photitle">
        <span class="back-lnk">&gt;<a href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'list','photosid'=>$photosid))?>">返回<?php echo $strPhotos['title'];?></a></span>
        <span class="nums">第<?php echo $nowPage;?>张 / 共<?php echo $conutPage;?>张</span>
        <link href="" rel="prev">
        <a id="pre_photo" title="用方向键←可以向前翻页" href="#">上一张</a>
        /
        <link href="#" rel="next">
        <a id="next_photo" title="用方向键→可以向后翻页" href="#">下一张</a>
    </div>

    <div class="phoview">
        <?php if($nowPage < $conutPage) { ?>
        <a title="点击查看下一张" href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'photo','photosid'=>$photosid,'id'=>$next))?>" class="mainphoto">
        <?php } ?>
            <img src="<?php echo SITE_URL;?><?php echo tsXimg($strPhoto['photourl'],'site',600,600,$strPhoto['path'])?>">
        <?php if($nowPage < $conutPage) { ?>
        </a>
        <?php } ?>  
    </div>

    <div class="phodesc">

    </div>
    
  </div><!--//link-report-->
  
</div>  
 

    

</div><!--//bd-->

        </div>

    </div>
    
    <!--//main-->
    
    <!--aside-->      
    <div class="aside">  
    
    </div>
    <!--//aside-->  

    <div class="extra">
         
    </div>
 
</div>
<!--//内容-->

<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->
