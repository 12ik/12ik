<?php include template('header'); ?>
<div class="midder">
<div class="mc">
    <h1><?php echo $title;?></h1>
    <div class="cleft w700">
		
        <div class="group-list">
        	<?php foreach((array)$exploreGroup as $item) {?>
            <div class="result">
                <div class="pic">
                <a title="<?php echo $item['groupname'];?>" href="<?php echo U('group','show',array('id'=>$item['groupid']))?>" class="nbg">
                	<img src="<?php echo $item['icon_48'];?>" alt="<?php echo $item['groupname'];?>" width="48" height="48">
                </a>
                </div>
                <div class="content">
                    <div class="title">
                        <h3><a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><?php echo getsubstrutf8(t($item['groupname']),0,14)?></a></h3>
                    </div>
                    <div class="info"><?php echo $item['count_user'];?> 个成员 在此聚集 </div>
                    <div><p><?php echo $item['groupdesc'];?></p></div>
                </div>
            </div>
            <?php } ?>
                        
        </div>

    </div>



    <div class="cright w250">
		 <?php include template('group_cate'); ?>   	
    </div>
    
</div>
</div>
<?php include template('footer'); ?>