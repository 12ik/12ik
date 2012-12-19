<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<div class="cleft">
    <div class="art-body">
    	<h1 class="title"><?php echo $strArticleinfo['subject'];?></h1>
        <div style="text-align:center;color:#999999;padding-bottom: 10px;border-bottom: 1px solid #DDDDDD; margin-bottom:10px">
        发表于 <?php echo date('Y-m-d H:i:s',$strArticleinfo['dateline'])?>  浏览<?php echo $strArticleinfo['viewnum'];?>次 <a href="#formMini">我要回复</a> 
        </div>
    
        <div class="art-text">
            <?php echo $strArticle['message'];?>
        </div>
    
  
    
    <div class="clear"></div>

  </div>


</div>


<div class="cright">
	<p class="pl2"><a href="<?php echo SITE_URL;?><?php echo tsurl('article')?>">&gt; 返回</a></p>
    
</div>

</div>
</div>

<?php include template('footer'); ?>