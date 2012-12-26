<?php include template('header'); ?>
<script language="javascript">
$(function(){
	$('.tags > li').bind('click',function(){
		$('.tags > li a').removeClass('active');
		$(this).find('a').addClass('active');
		loadSite($(this).text(),1);
	});
});

</script>
<div class="midder">
<div class="mc">
	<h1><?php echo $title;?></h1>
    <div class="cleft">
		<div class="tags-nav">
            <ul class="tags">

              <li><a class="active" href="javascript:;">爱客猜</a></li>
              <li><a href="javascript:;">生活</a></li>
              <li><a href="javascript:;">同城</a></li>
              <li><a href="javascript:;">影视</a></li>
              <li><a href="javascript:;">工作室</a></li>
              <li><a href="javascript:;">艺术</a></li>
              <li><a href="javascript:;">音乐</a></li>
              <li><a href="javascript:;">品牌</a></li>
              <li><a href="javascript:;">手工</a></li>
              <li><a href="javascript:;">闲聊</a></li>
              <li><a href="javascript:;">设计</a></li>
              <li><a href="javascript:;">服饰</a></li>
              <li><a href="javascript:;">摄影</a></li>
              <li><a href="javascript:;">媒体</a></li>
              <li><a href="javascript:;">美食</a></li>
              <li><a href="javascript:;">读书</a></li>
              <li><a href="javascript:;">公益</a></li>
              <li><a href="javascript:;">互联网</a></li>
              <li><a href="javascript:;">动漫</a></li>
              <li><a href="javascript:;">旅行</a></li>
              <li><a href="javascript:;">绘画</a></li>
              <li><a href="javascript:;">美容</a></li>
              <li><a href="javascript:;">购物</a></li>
              <li><a href="javascript:;">电影</a></li>
              <li><a href="javascript:;">教育公益</a></li>
              <li><a href="javascript:;">游戏</a></li>
         
             </ul>
    	</div><!--//tag 结束-->
        
        <div class="site-list-wrap">
        
        <div class="site-loading" style="display: none;"><span class="state">加载中</span></div>
            
            <ul class="site-list" style="display: block;">
    			<?php foreach((array)$arrSite as $item) {?>
                <li class="site-item">
                <div class="pic">
                    <a target="_blank" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>" title="<?php echo $item['sitename'];?>">
                        <img width="75" height="75" alt="<?php echo $item['sitename'];?>" src="<?php echo $item['icon_75'];?>">
                    </a>
                </div>
                <div class="info">
                  <div class="title">
                    <a target="_blank" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>" title="<?php echo $item['sitename'];?>"><?php echo $item['sitename'];?></a>
                  </div>
                  <p><?php echo getsubstrutf8(t($item['sitedesc']),0,30);?></p>
                </div>
                </li>
                <?php } ?>
             
            </ul>
        
            <div class="site-more" style="display:none">
                 <span class="stat">加载更多</span>
            </div>
    </div>

         
    </div>

    <div class="cright">
 		<h2>最新推荐小站</h2>
        <div class="site-rec">
        <ul class="list-items">
        	<?php foreach((array)$recommendSites as $item) {?>
                <li class="list-item">
                    <div class="pic">
                        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>" target="_blank" title="<?php echo $item['sitename'];?>">
                            <img width="50" height="50" alt="<?php echo $item['sitename'];?>" src="<?php echo $item['icon_75'];?>">
                        </a>
                    </div>
                    <div class="info">
                        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>" target="_blank" title="<?php echo $item['sitename'];?>"><?php echo $item['sitename'];?></a>
                        <p class="like-num"><?php echo $item['likenum'];?>人喜欢</p>
                    </div>
                </li> 
            <?php } ?>    
                
                
         </ul>
        </div>
        
         	<?php if($IK_USER['user'][userid] !='' ) { ?>
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('site','new_site')?>">申请创建小站</a></p>
            <?php } ?>
        
    </div><!--//end right-->
    
</div>
</div>
<?php include template('footer'); ?>