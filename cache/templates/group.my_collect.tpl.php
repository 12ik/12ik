<?php include template('header'); ?>

<div class="midder">

<div class="mc">
	
    <h1>我收藏的话题</h1>
    
<div class="cleft">

<?php include template('my_menu'); ?>


           <div class="indent">
                <table class="olt">
                    <tbody>
                        <tr>
                            <td>话题</td>
                            <td>小组</td>
                            <td>作者</td>
                            <td nowrap="nowrap" align="right">&nbsp;&nbsp;&nbsp;&nbsp;回应</td>
                            <td align="right">最后回应</td>
                        </tr>
            <?php if($arrTopic) { ?>
            <?php foreach((array)$arrTopic as $key=>$item) {?>
                            <tr class="pl">
                                <td><a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>
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
                                <td><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['group'][groupname];?></a></td>
                                <td><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a></td>
                                <td align="right"><?php if($item['count_comment']>0) { ?><?php echo $item['count_comment'];?><?php } ?></td>
                                <td nowrap="nowrap" align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo getTime($item['uptime'],time())?></td>
                            </tr>
             <?php }?>
            <?php } ?>         
                </tbody>
              </table>
            </div>

<div class="clear"></div>

</div>

<div class="cright">

<p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group')?>">返回我的小组</a></p>

</div>
</div>
</div>


<?php include template('footer'); ?>