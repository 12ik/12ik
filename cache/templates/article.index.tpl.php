<?php include template('header'); ?>
<div class="midder">
<div class="mc">
	<h1><?php echo $title;?></h1>
    
<div class="cleft">
	
    
   <div class="note_list">

       <?php foreach((array)$arrArticle as $key=>$item) {?>
        <dl>
            <dt><a href="<?php echo SITE_URL;?><?php echo tsurl('article','show',array('id'=>$item['itemid']))?>" title="<?php echo $item['subject'];?>"><?php echo $item['subject'];?></a></dt>
            <dd class="addtime">发表于 <?php echo date('Y-m-d H:i:s',$item['dateline'])?></dd>
        </dl>
	  <?php }?>
	 
   </div>
   <div class="page"><?php echo $pageUrl;?></div>   
     
</div>

    <div class="cright">
  
            
            <h2>文章栏目</h2>

            
            <div class="cate">
                <ul>
              
                </ul>
            </div>
            
    </div>
    
</div>
</div>
<?php include template('footer'); ?>