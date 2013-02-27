<?php include template('header'); ?>
<div class="midder">

<div class="mc">
<h1 class="group_tit"><?php echo $strGroup['groupname'];?></h1>
<div class="cleft">
<div class="infobox">

<div class="bd">
<img align="left" alt="<?php echo $strGroup['groupname'];?>" src="<?php echo $strGroup['icon_48'];?>" class="pil mr5 groupicon" valign="top" />
<div>创建于<?php echo date('Y-m-d',$strGroup['addtime'])?>&nbsp; &nbsp; <?php echo $strGroup['role_leader'];?>：<a href="<?php echo U('hi','',array('id'=>$strLeader['doname']))?>"><?php echo $strLeader['username'];?></a><br></div>
<?php echo nl2br($strGroup['groupdesc'])?>
<div class="clearfix" style="margin-top: 10px;">

<?php if($isGroupUser > 0 && $IK_USER['user'][userid] != $strGroup['userid']) { ?>
<span class="fleft mr5 color-gray">我是这个小组的<?php echo $strGroup['role_user'];?> <a class="j a_confirm_link" href="<?php echo U('group','do',array('ik'=>'exit','groupid'=>$strGroup['groupid']))?>" style="margin-left: 6px;">&gt;退出小组</a></span>
<?php } elseif ($isGroupUser > 0 && $IK_USER['user'][userid] == $strGroup['userid']) { ?>
<span class="fleft mr5 color-gray">我是这个小组的<?php echo $strGroup['role_leader'];?></span>
<?php } elseif ($strGroup['joinway'] == '0') { ?>
<span class="fright">
<a class="button-join" href="<?php echo U('group','do',array('ik'=>'join','groupid'=>$strGroup['groupid']))?>">申请加入小组</a></span>

<?php } else { ?>
<span class="fright">本小组禁止加入</span>
<?php } ?>


</div>
</div>

</div>

<div class="box">

<div class="box_content">

    <h2 style="margin-top:10px">
                <a class="rr bn-post" href="<?php echo U('group','add',array('groupid'=>$strGroup['groupid']))?>"><span>发布帖子</span></a>
        最近小组话题  · · · · · ·
    </h2>

<div class="clear"></div>

<?php if($arrTopic) { ?>
            <div class="indent">
                <table class="olt">
                    <tbody>
                        <tr>
                            <td>话题</td>
                            <td nowrap="nowrap">作者</td>
                            <td nowrap="nowrap">回应</td>
                            <td align="right" nowrap="nowrap">最后回应</td>
                        </tr>
            <?php if($arrTopic) { ?>
            <?php foreach((array)$arrTopic as $key=>$item) {?>
                            <tr class="pl">
                                <td>
             <a title="<?php echo $item['title'];?>" href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>
            <?php if($item['isvideo'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>public/images/lc_cinema.png" align="absmiddle" title="[视频]" alt="[视频]" />
            <?php } ?>             
            <?php if($item['istop']=='1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/headtopic_1.gif" align="absmiddle" title="[置顶]" alt="[置顶]" />
            <?php } ?>
            <?php if($item['addtime']>strtotime(date('Y-m-d 00:00:00'))) { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/topic_new.gif" align="absmiddle"  title="[新帖]" alt="[新帖]" />
            <?php } ?> 
            <?php if($item['isposts'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>public/images/posts.gif" align="absmiddle" title="[精华]" alt="[精华]" />
            <?php } ?>
            </td>

                                <td nowrap="nowrap"><a href="<?php echo U('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a></td>
                                <td nowrap="nowrap" ><?php if($item['count_comment']>0) { ?><?php echo $item['count_comment'];?><?php } ?></td>
                                <td nowrap="nowrap" class="time" align="right"><?php echo getTime($item['uptime'],time())?></td>
                            </tr>
             <?php }?>
            <?php } ?>         
                </tbody>
              </table>
            </div>
<?php } ?>
	<div class="clear"></div>
	<div class="page"><?php echo $pageUrl;?></div>

</div>
</div>

</div>


<div class="cright">
    <div>
        <h2>最新加入成员</h2>
        <?php foreach((array)$arrGroupUser as $key=>$item) {?>
        <dl class="obu">
            <dt>
            <a href="<?php echo U('hi','',array('id'=>$item['doname']))?>"><img alt="<?php echo $item['username'];?>" class="m_sub_img" src="<?php echo $item['face'];?>" /></a>
            </dt>
            <dd><?php echo $item['username'];?><br>
                <span class="pl">(<a href="<?php echo U('location','area',array(areaid=>$item['area'][areaid]))?>"><?php echo $item['area'][areaname];?></a>)</span>
            </dd>
     	 </dl>
        <?php }?>
    
        <br clear="all">
    
        <?php if($IK_USER['user'][userid] == $strGroup['userid']) { ?>
        <p class="pl2">&gt; <a href="<?php echo U('group','group_user',array(groupid=>$strGroup['groupid']))?>">成员管理 (<?php echo $strGroup['count_user'];?>)</a></p>
        
        <p class="pl2">&gt; <a href="<?php echo U('group','edit',array(ik=>base,groupid=>$strGroup['groupid']))?>">修改小组设置 </a></p>
        <p class="pl2">&gt; <a href="<?php echo U('group','recovery',array(groupid=>$strGroup['groupid']))?>">回收站 (<?php echo $strGroup['recoverynum'];?>)</a></p>
        
        <?php } else { ?>
        <p class="pl2"><a href="<?php echo U('group','group_user',array(groupid=>$strGroup['groupid']))?>">浏览所有成员 (<?php echo $strGroup['count_user'];?>)</a></p>
        <?php } ?>
        
       <div class="clear"></div>

        
    </div>
    
	<p class="pl">本页永久链接: <a href="<?php echo U('group','show',array(id=>$strGroup['groupid']))?>"><?php echo U('group','show',array(id=>$strGroup['groupid']))?></a></p>
    
    <p class="pl"><span class="feed"><a href="<?php echo U('group','rss',array(groupid=>$strGroup['groupid']))?>">feed: rss 2.0</a></span></p>
    
    <div class="clear"></div>
	<?php doAction('group_group_right_footer',$strTopic)?>

</div>
</div>
</div>

<?php include template('footer'); ?>