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
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','room',array('siteid'=>$siteid,'roomid'=>$roomid))?>">&gt; 回<?php echo $strSite['sitename'];?></a>
        </div>  
        <h1><?php echo $title;?></h1>         
        <div class="mod">
            	

<div class="bd">
    <div class="photitle">
            &nbsp;&gt;<a href="<?php echo SITE_URL;?><?php echo ikurl('site','photos',array('ik'=>'upload','photosid'=>$photosid))?>">添加照片</a>
            &nbsp;&gt;<a href="<?php echo SITE_URL;?><?php echo ikurl('site','photos',array('ik'=>'info','photosid'=>$photosid))?>">批量修改</a>
    </div>
    
 
    <div class="event-photo-list">
     <ul class="list-s">
     	<?php foreach((array)$photosList as $item) {?>
        <li>
            <div class="photo-item">
                <a id="p<?php echo $item['photoid'];?>" class="album_photo" title="<?php echo $item['photodesc'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('site','photos',array('ik'=>'photo','photosid'=>$photosid,'pid'=>$item['photoid']))?>"><img src="<?php echo SITE_URL;?><?php echo ikXimg($item['photourl'],'site',170,170,$item['path'])?>" alt="<?php echo $item['photodesc'];?>" /></a>
                <div class="desc"><?php echo $item['photodesc'];?></div>
            </div>
        </li>
        <?php } ?>
     </ul>
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
