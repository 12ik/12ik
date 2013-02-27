<?php include template('header'); ?>
<div class="midder">
<div class="mc">
	<h1>全部小组</h1>
    
<div class="cleft">

                <?php foreach((array)$arrRecommendGroup as $key=>$item) {?>
                <div class="sub-item">
                
                    <div class="pic">
                        <a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>">
                        <img data-defer-src="<?php echo $item['icon_48'];?>" src="<?php echo $item['icon_48'];?>" alt="<?php echo $item['groupname'];?>">
                        </a>
                        <a class="joingroup" href="<?php echo U('group','do',array('ik'=>'join','groupid'=>$item['groupid']))?>" title="加入">+加入</a>
                    </div>
                    <div class="info">
                            <div class="title">
                                <a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>" title="<?php echo $item['groupname'];?>" target="_blank"><?php echo $item['groupname'];?></a>
                                <span class="follow-num"><?php echo $item['count_user'];?>个成员</span>
                            </div>
                                        
                            <p><?php echo $item['groupdesc'];?></p>
                    </div> 
                           
                </div>
                <?php }?>


        <div class="clear"></div>
        
        <div class="page"><?php echo $pageUrl;?></div>

</div>

    <div class="cright">
    
        <h2>热门帖子</h2>
        <div class="line23">
        <?php foreach((array)$arrTopic as $key=>$item) {?>
        <a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a> (<?php echo $item['count_comment'];?>)
        <br />
        <?php }?>
        </div>
    
        <div class="clear"></div>
    
        <h2>最新创建小组</h2>
        
        <div class="line23">
        <?php if($arrNewGroup) { ?>
        <?php foreach((array)$arrNewGroup as $key=>$item) {?>
        <a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> (<?php echo $item['count_user'];?><?php if($item['uptime']>strtotime(date('Y-m-d 00:00:00'))) { ?>/<font color="orange"><?php echo $item['count_topic_today'];?></font><?php } else { ?><?php } ?>)<br>
        <?php }?>
        <?php } ?>
        </div>
    
        <div class="clear"></div>
    
    </div>
    
</div>
</div>
<?php include template('footer'); ?>