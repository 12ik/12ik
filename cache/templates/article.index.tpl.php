<?php include template('header'); ?>
<div class="midder">
	<div class="mc">
		<aside class="w190 fl">
			<section class="categories">
				<div class="hd">
					<h3>全部分类</h3>
				</div>
				<ul class="list categories-list">
					<!--         <?php foreach((array)$arrCate as $item) {?> -->
					<li><a href="<?php echo SITE_URL;?><?php echo ikurl('article','list',array('cateid'=>$item['catid']))?>"><?php echo $item['name'];?></a></li>
					<!--         <?php } ?>   -->
				</ul>
			</section>
			<section class="personal-publish">
				<div class="hd">
					<h3>作品投稿</h3>
				</div>
				<div class="bd">
					<p>个人作者可以在爱客上直接发布作品。 内容领域不限，唯一要求是保证质量优秀。 发表后，作者可直接从中获得分成。</p>
					<p class="entrance">
						<a href="<?php echo SITE_URL;?><?php echo ikurl('article','do',array('ik'=>'post'))?>" class="btn btn-large">去投稿<i class="arrow-right"></i></a>
					</p>
				</div>
			</section>
		</aside>
		<article class="w770 fr">
			<section>
				<div class="hd tag-heading">
					<h3 class="the-tag-name"><?php echo $title;?></h3>
				</div>

				<div class="bd">
					<ul class="list-lined article-list">
						<!-- <?php foreach((array)$arrArticle as $item) {?> -->
						<li class="item" id="article-407582">
							<div class="title">
								<a href="<?php echo SITE_URL;?><?php echo ikurl('article','show',array('id'=>$item['news'][nid]))?>"><?php echo $item['subject'];?> 
                                <?php if($item['attach']) { ?>
                                [图文]
                                <?php } ?>
                                </a>
							</div>
                            <?php if($item['attach']) { ?> 
							<div class="cover">
                                <a class="pic" href="<?php echo SITE_URL;?><?php echo ikurl('article','show',array('id'=>$item['news'][nid]))?>">
									<img src="<?php echo $item['attach'];?>" />
								</a> 
							</div>
                            <?php } ?>                            
							<div class="info">
								<div class="article-desc-brief">
									<?php echo getsubstrutf8(t($item['news'][message]),0,150);?>...<a
										href="<?php echo SITE_URL;?><?php echo ikurl('article','show',array('id'=>$item['news'][nid]))?>">（更多）</a>
								</div>
							</div>
							<span class="time"> <?php echo date('Y-m-d H:i:s',$item['dateline'])?></span> 
						</li>
						<!-- <?php } ?> -->

					</ul>
				</div>


			</section>
            
             <div class="page"><?php echo $pageUrl;?></div>   
             
		</article>
	</div>
</div>
<?php include template('footer'); ?>
