<?php include template('header'); ?>

<div class="midder">

    <div class="mc">
    
   	    <h1><?php echo $title;?></h1>
       
        <div class="cleft w700">


            <div class="group_topics">
                <table class="olt">
                    <tbody>
            <?php if($arrTopic) { ?>
            <?php foreach((array)$arrTopic as $key=>$item) {?>
                            <tr class="pl">
           <td class="td-subject"><a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo getsubstrutf8(t($item['title']),0,25)?></a>
            <?php if($item['isvideo'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>public/images/lc_cinema.png" align="absmiddle" title="[视频]" alt="[视频]" />
            <?php } ?>                
            <?php if($item['istop']=='1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/headtopic_1.gif" title="[置顶]" alt="[置顶]" />
            <?php } ?>
            <?php if($item['addtime']>strtotime(date('Y-m-d 00:00:00'))) { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/topic_new.gif" align="absmiddle"  title="[新帖]" alt="[新帖]" />
            <?php } ?> 
            <?php if($item['isphoto']=='1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/image_s.gif" title="[图片]" alt="[图片]" align="absmiddle" />
            <?php } ?> 
            <?php if($item['isattach'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/attach.gif" title="[附件]" alt="[附件]" />
            <?php } ?>
            <?php if($item['isposts'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
            <?php } ?></td>
                                <td class="td-reply" nowrap="nowrap"><?php if($item['count_comment']>0) { ?><?php echo $item['count_comment'];?> 回应<?php } ?></td>
                                <td class="td-time" nowrap="nowrap"><?php echo getTime($item['uptime'],time())?></td>
                                <td align="right"><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo getsubstrutf8(t($item['group'][groupname]),0,10)?></a></td>
                            </tr>
             <?php }?>
            <?php } ?>         
                </tbody>
              </table>
            </div>
            
             
            
            <div class="clear"></div>
    
    
    	</div>
    
        <div class="cright w250" id="cright">   
              
			<?php include template('my_menu'); ?>                     
        
        </div>
    
    </div><!--//mc-->

</div>


<?php include template('footer'); ?>