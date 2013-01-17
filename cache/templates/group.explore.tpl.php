<?php include template('header'); ?>
<div class="midder">
<div class="mc">
    <h1><?php echo $title;?></h1>
    <div class="cleft">
		
        <div class="group-list">
        	<?php foreach((array)$exploreGroup as $item) {?>
            <div class="result">
                <div class="pic">
                <a title="<?php echo $item['groupname'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>" class="nbg">
                	<img src="<?php echo $item['icon_48'];?>" alt="<?php echo $item['groupname'];?>" width="48" height="48">
                </a>
                </div>
                <div class="content">
                    <div class="title">
                        <h3><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a></h3>
                    </div>
                    <div class="info"><?php echo $item['count_user'];?> 个成员 在此聚集 </div>
                    <div><p><?php echo $item['groupdesc'];?></p></div>
                </div>
            </div>
            <?php } ?>
                        
        </div>

    </div>



    <div class="cright">
    	
    </div>
    
</div>
</div>
<?php include template('footer'); ?>