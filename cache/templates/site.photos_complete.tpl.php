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
        <a href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'list','photosid'=>$photosid))?>">&gt; 返回<?php echo $strPhotos['title'];?></a>
        </div>
        
        <h1><?php echo $title;?></h1>
        
        <div class="mod">
            	

<div class="bd">
	<form method="post" name="album_info" action="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'addinfo','photosid'=>$photosid))?>">
	<div class="photo-complete">
     	<?php foreach((array)$arrPhotos as $item) {?>
        <div class="photo-item">
            <div class="cover">
                <a href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'photo','photosid'=>$photosid,'pid'=>$item['photoid']))?>"><img src="<?php echo SITE_URL;?><?php echo tsXimg($item['photourl'],'site',100,100,$item['path'])?>"/></a>
            </div>
            <div class="intro">
                <textarea maxlength="128" name="desc_<?php echo $item['photoid'];?>"><?php echo $item['photodesc'];?></textarea>
                <p><a  title="删除这张照片" rel="nofollow" href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'deletepic','photosid'=>$photosid,'id'=>$item['photoid']))?>">删除照片</a></p>
            </div>
        </div>
        <?php } ?>
    </div>
   
    <div class="submit-area">
    	<span class="bn-flat-hot"><input type="submit" value="保存" name="submit" onclick="this.style.display='none';"></span>
    </div>
    
    </form>
    
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
