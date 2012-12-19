<?php include template('header'); ?>
<div class="midder">
  <div class="mc">
    <aside class="col col3">
      <section class="categories">
        <div class="hd">
          <h3>分类</h3>
        </div>
        <ul class="list categories-list">
        
          <li><a href="/tag/%E5%B0%8F%E8%AF%B4/">小说</a></li>
          
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
                  <h3 class="the-tag-name">最新发表</h3>
                  <div class="hd-nav">
                    <ul class="filter-tabs filter-type-tabs">
                      <li class="tab on"><a href="?sort=top&amp;cat=all">全部</a></li>
                    </ul>
                    <ul class="filter-tabs">
                      <li class="tab on"><a href="?sort=top&amp;cat=all">热门</a></li>
                    </ul>
                  </div>
                </div>
                
                <div class="bd">
                	<ul class="list-lined article-list">
<?php foreach((array)$arrArticle as $item) {?>
<li class="item" id="article-407582">
  <div class="cover"><a  target="_self" class="pic" href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>"></a></div>
  <div class="info">
    <div class="title"><a href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['nid']))?>"><?php echo $item['items'][subject];?></a></div>
    <div class="article-desc-brief"><?php echo getsubstrutf8(t($item['message']),0,200);?>...<a onclick="moreurl(this, {'aid': '407582', 'src': 'tag'}, true, 'read.douban.com')" href="/ebook/407582/">（更多）</a></div>

  </div>
</li>
<?php } ?>
                    </ul>
                </div>
                
                <div class="ft">
                
                </div>
      </section>
    </article>
  </div>
</div>
<?php include template('footer'); ?>