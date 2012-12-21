<?php include template('header'); ?>
<div class="midder">
  <div class="mc">
    <aside class="col col3">
      <section class="categories">
        <div class="hd">
          <h3>全部分类</h3>
        </div>
        <ul class="list categories-list">
        <?php foreach((array)$arrCate as $item) {?>
          <li><a href="#"><?php echo $item['name'];?></a></li>
        <?php } ?>  
        </ul>
      </section>
      <section class="personal-publish">
        <div class="hd">
          <h3>作品投稿</h3>
        </div>
        <div class="bd">
          <p> 个人作者可以在爱客上直接发布作品。 内容领域不限，唯一要求是保证质量优秀。 发表后，作者可直接从中获得分成。 </p>
          <p class="entrance"><a href="/submit/" class="btn btn-large">去投稿<i class="arrow-right"></i></a></p>
        </div>
      </section>
    </aside>
    <article class="col11 fr">
      <section>
                <div class="hd tag-heading">
                    <div class="hd-nav">
                    <ul class="filter-tabs filter-type-tabs">
                    <li class="tab on"><a href="#">全部</a></li>
                    </ul>
                    <ul class="filter-tabs">
                    <li class="tab on"><a href="#">热门</a></li>
                    </ul>
                    </div>
                   <h3 class="the-tag-name"><?php echo $title;?></h3>
             
                </div>
                
                <div class="bd">
<ul class="list-lined article-list">
<!-- <?php foreach((array)$arrArticle as $item) {?> -->
<li class="item" id="article-407582">
  <div class="cover">
  <?php if($item['items'][attach]) { ?>
  <a class="pic" href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>">
  	<img src="<?php echo ATT_URL;?><?php echo $item['items'][attach][thumbpath];?>" />
  </a>
  <?php } else { ?>
  <a class="pic" href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>">
  	<img src="<?php echo SITE_URL;?>public/images/defimg.gif" />
  </a>  
  <?php } ?>
  </div>
  <div class="info">
    <div class="title"><a href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>"><?php echo $item['items'][subject];?></a></div>
    <div class="article-desc-brief"><?php echo getsubstrutf8(t($item['message']),0,200);?>...<a href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>">（更多）</a></div>
  </div>
</li>
<?php } ?>

</ul>
                </div>
                
               
      </section>
    </article>
  </div>
</div>
<?php include template('footer'); ?>