<?php include template('header'); ?>

<div class="midder">
	<div class="mc">

	<?php if(intval($IK_USER['user'][userid]) > 0) { ?>
        <h1>发现小组</h1>
        <?php } else { ?>
        <h1>全部小组</h1>
	<?php } ?>

		<div class="cleft">
        
            <?php if($arrGroup != '') { ?>
            <div class="indent">
            
                    <?php foreach((array)$arrGroup as $key=>$item) {?>
                            <div class="sub-item">
                              
                                    <div class="pic">
                                        <a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>">
                                        <img data-defer-src="<?php echo $item['icon_48'];?>" src="<?php echo $item['icon_48'];?>" alt="<?php echo $item['groupname'];?>">
                                        </a>
                                        <?php if(in_array($item['groupid'],$myGroup)) { ?>
                                        <span class="joined">已加入</span>
                                        <?php } else { ?>
                                        <a class="joingroup" href="<?php echo U('group','do',array('ik'=>'join','groupid'=>$item['groupid']))?>">+加入</a>
                                        <?php } ?>
                                        
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
                    
            </div>
            <?php } ?>
        
                <div class="clear"></div>
                <div class="page"><?php echo $pageUrl;?></div>
                
		</div>

        <div class="cright">
        
                <?php if($IK_APP['options'][iscreate]==0 || $IK_USER['user'][isadmin]==1) { ?>
                <p class="pl2">&gt; <a href="<?php echo U('group','create')?>">创建小组</a></p>
                <?php } ?>
                <h2>热门帖子</h2>
                <div class="line23">
                <?php foreach((array)$arrTopic as $key=>$item) {?>
                <a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a> (<?php echo $item['count_comment'];?>)
                <br />
                <?php }?>
                </div>
        
                <div class="clear"></div>
                <h2>新成立小组</h2>
                <div class="line23">
                <?php if($arrNewGroup) { ?>
                <?php foreach((array)$arrNewGroup as $key=>$item) {?>
                <a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> (<?php echo $item['count_user'];?><?php if($item['uptime']>strtotime(date('Y-m-d 00:00:00'))) { ?>/<font color="orange"><?php echo $item['count_topic_today'];?></font><?php } else { ?><?php } ?>)<br>
                <?php }?>
                <?php } ?>
                </div>
        
        </div>
        
	</div><!--//mc>
</div>

<?php include template('footer'); ?>