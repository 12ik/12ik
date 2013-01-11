<?php include template('header'); ?>
<div class="midder">
<div class="mc">
	<h1><?php echo $title;?></h1>
    <div class="cleft">


<div id="miniblog">
    <ul class="mbt">
  <?php foreach((array)$strMylikeSite as $item) {?>
    <li class="tl-item">

        <div class="item-title site-title">
            
            <a target="_blank" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>" class="icon">
                <img width="32" height="32" src="<?php echo $item['icon_48'];?>">
            </a>
            <div class="info">
                <a target="_blank" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>"><?php echo $item['sitename'];?></a>
            </div>
        </div>
   		<?php foreach((array)$item['notes'] as $itemnotes) {?>
        <div class="site-item first">
            <div class="title">
            	<span style="float:right;color:#B9B9B9"><?php echo date('m-d H:i:s',$itemnotes['addtime'])?></span>
                <span class="item-type">[日记]</span>
                <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$itemnotes['notesid'],'noteid'=>$itemnotes['contentid']))?>" target="_blank"><?php echo $itemnotes['title'];?></a>
            </div>
            <div class="content">
            	<?php if($itemnotes['photo']) { ?>
                    <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$itemnotes['notesid'],'noteid'=>$itemnotes['contentid']))?>" class="note-image" target="_blank">
                        <img width="70" src="<?php echo $itemnotes['photo'][photo_140];?>">
                    </a>
                 <?php } ?>   
              <p><?php echo getsubstrutf8($itemnotes['content'],0,200)?> </p>
            </div>
        </div> 
        <?php } ?>


    </li>
	
    <?php } ?>
	
    </ul>
</div>
        
        
        <div class="footer">
            <span>这里看上去很冷清？尝试喜欢更多小站来发现感兴趣的内容吧</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo SITE_URL;?><?php echo ikurl('site','explore',array('ik'=>'site'))?>">发现更多小站</a>
        </div>
   
    </div>

    <div class="cright">


<div class="component groups-sites">
    <h2>
        我喜欢的小站
            &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
            <span class="pl">&nbsp;(
                     <a href="<?php echo SITE_URL;?><?php echo ikurl('site','people',array('ik'=>'minisite'))?>">全部</a>
                ) </span>
    </h2>

    <div class="content">
            <?php foreach((array)$strMylikeSite as $item) {?>
            <a class="show-title" title="<?php echo $item['sitename'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>"><img width="38" height="38" alt="<?php echo $item['sitename'];?>" src="<?php echo $item['icon_48'];?>"></a>
            <?php } ?>
               
    </div>
</div>

<div class="component groups-sites">
    <h2>
        我管理的小站
            &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
    </h2>

    <div class="content">
              
            <?php foreach((array)$strMysite as $item) {?>
            <a class="show-title" title="<?php echo $item['sitename'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$item['siteid']))?>"><img width="38" height="38" alt="<?php echo $item['sitename'];?>" src="<?php echo $item['icon_48'];?>"></a>
            <?php } ?>              
               
    </div>
</div>

            
            
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('site','explore',array('ik'=>'site'))?>">发现更多小站</a></p>
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('site','new_site')?>">申请创建小站</a></p>
           
    </div>
    
</div>
</div>
<script>
  IK(function(){
    $(function(){var a;$(".show-title").hover(function(c){var b=$(c.currentTarget),f=b.offset(),d=b.data("title");if(!a){a=$('<div class="popup-tip"><div class="bd" style="max-width:200px;word-wrap:break-word;"></div><div class="x1"></div></div>').appendTo("body")}if(!d){d=b.attr("title");b.data("title",d);b.attr("title","")}a.show().find(".bd").html(d);a.css({top:f.top-a.height()-10,left:f.left+b.width()/2-a.width()/2})},function(b){a&&a.hide()})});
  });
</script>
<?php include template('footer'); ?>