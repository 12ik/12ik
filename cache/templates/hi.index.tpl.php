<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<div class="cleft">

<?php include pubTemplate("user_header");?>

<div class="clear"></div>

<div id="recs" class="">
    <h2>
        <?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
          我的发布的帖子
        <?php } else { ?>
          <?php echo $strUser['username'];?>发布的帖子
        <?php } ?>
         &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
            <!-- <span class="pl">&nbsp;(
                <a href="#">全部</a>
            ) </span> -->
    </h2>

<div class="spacetopic">
<?php if($arrMyTopic) { ?>
<table width="100%">
<?php foreach((array)$arrMyTopic as $key=>$item) {?>
<tr>
<td><img src="<?php echo SITE_URL;?>public/images/topic.gif" align="absmiddle"  title="[帖子]" alt="[帖子]" />
<a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>&nbsp;&nbsp;</td>
<td><?php echo $item['count_comment'];?></td>
<td style="width:120px;text-align:right;color:#999999;"><?php echo date('Y-m-d H:i',$item['addtime'])?></td>
</tr>
<?php }?>
</table>
<?php } else { ?>
<div style="padding:50 0;color:#999999;">这个人很懒，什么也不愿意留下！</div>
<?php } ?>
</div>

<div class="clear"></div>
</div>

<div id="recs" class="">
    <h2> 
        <?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
        我回复的帖子
        <?php } else { ?>
        <?php echo $strUser['username'];?>回复的帖子
        <?php } ?>
         &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
           <!--  <span class="pl">&nbsp;(
                <a href="#">全部</a>
            ) </span> -->
    </h2>

<div class="spacetopic">
<?php if($arrMyComment) { ?>
<table width="100%">
<?php foreach((array)$arrMyComment as $key=>$item) {?>
<tr>
<td><img src="<?php echo SITE_URL;?>public/images/topic.gif" align="absmiddle"  title="[帖子]" alt="[帖子]" />
<a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>&nbsp;&nbsp;</td>
<td><?php echo $item['count_comment'];?></td>
<td style="width:120px;text-align:right;color:#999999;"><?php echo date('Y-m-d H:i',$item['addtime'])?></td>
</tr>
<?php }?>
</table>
<?php } else { ?>
<div style="padding:50 0;color:#999999;">这个人很懒，什么也不愿意留下！</div>
<?php } ?>
</div>

<div class="clear"></div>
</div>

<div id="recs" class="">
    <h2>
        <?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
        我收藏的帖子
        <?php } else { ?>
        <?php echo $strUser['username'];?>收藏的帖子
        <?php } ?>
         &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
            <!-- <span class="pl">&nbsp;(
                <a href="#">全部</a>
            ) </span> -->
    </h2>

<div class="spacetopic">
<?php if($arrMyCollect) { ?>
<table width="100%">
<?php foreach((array)$arrMyCollect as $key=>$item) {?>
<tr>
<td><img src="<?php echo SITE_URL;?>public/images/topic.gif" align="absmiddle"  title="[帖子]" alt="[帖子]" />
<a href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>&nbsp;&nbsp;</td>
<td ><?php echo $item['count_comment'];?></td>
<td style="width:120px;text-align:right;color:#999999;"><?php echo date('Y-m-d H:i',$item['addtime'])?></td>
</tr>
<?php }?>
</table>
<?php } else { ?>
<div style="padding:50 0;color:#999999;">这个人很懒，什么也不愿意留下！</div>
<?php } ?>
</div>

<div class="clear"></div>
</div>



<div class="clear"></div>

</div>

<div class="cright">

<div id="profile">

<div class="infobox">
<div class="ex1"><span></span></div>
<div class="bd">
<img alt="" class="userface" src="<?php echo $strUser['face_120'];?>">

<div class="user-info">
常居：&nbsp;<?php if($arrArea['two']) { ?><a href="<?php echo U('location','area',array(areaid=>$arrArea['two'][areaid]))?>"><?php echo $arrArea['two'][areaname];?></a><?php } ?>
<br />
<div class="pl">UID:<?php echo $strUser['userid'];?> <br> <?php echo date('Y-m-d',$strUser['addtime'])?> 加入</div>
<div class="pl">级别:<?php echo $strUser['rolename'];?></div>
<div class="pl">积分:<?php echo $strUser['count_score'];?></div>
<?php if($strUser['userid'] != $IK_USER['user'][userid]) { ?>
<div class="user-opt">

<?php if($strUser['isfollow']) { ?>
<div class="user-group" style="display: block;">
<span class="user-cs">已关注</span>
<span class="user-rs">

<a href="<?php echo SITE_URL;?>index.php?app=user&a=do&ik=user_nofollow&userid_follow=<?php echo $strUser['userid'];?>">取消关注</a></span>

</div>
<?php } else { ?>
<a class="a-btn-add mr10 add_contact" href="<?php echo SITE_URL;?>index.php?app=user&a=do&ik=user_follow&userid_follow=<?php echo $strUser['userid'];?>">关注此人</a>
<?php } ?>
<a href="<?php echo U('user','message',array(ik=>message_add,touserid=>$strUser['userid']))?>" rel="nofollow" class="a-btn mr5">发消息</a>
<div id="divac"></div>
</div>
<?php } ?>
</div>

<div class="sep-line"></div>
<div class="user-intro">

<div class="j edtext pl" id="edit_intro">
<span id="intro_display">
性别：<?php if($strUser['sex']=='0') { ?>保密<?php } elseif ($strUser['sex']=='1') { ?>男<?php } else { ?>女<?php } ?><br />
<?php if($strUser['blog']) { ?>博客：<?php echo $strUser['blog'];?><br /><?php } ?>
<?php if($strUser['about']) { ?>关于：<?php echo $strUser['about'];?><br /><?php } ?>
<?php if($strUser['signed']) { ?>签名：<?php echo $strUser['signed'];?><br /><?php } ?>

<?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>[<a href="<?php echo U('user','set',array(ik=>base))?>">修改基本信息</a>]<?php } ?>
</span>
</div>

</div>

</div>
<div class="ex2"><span></span></div>
</div>


</div>
<div class="clear"></div>

<div id="friend">

<h2>
<?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
我关注的人
<?php } else { ?>
<?php echo $strUser['username'];?>关注的人
<?php } ?>
&nbsp;·&nbsp;·&nbsp;·
<span class="pl">&nbsp;(
<a href="<?php echo U('user','follow',array(userid=>$strUser['userid']))?>">全部<?php echo $strUser['count_follow'];?></a>
) </span>
</h2>

<?php foreach((array)$arrFollowUser as $key=>$item) {?>
<dl class="obu"><dt><a class="nbg" href="<?php echo U('hi','',array('id'=>$item['doname']))?>"><img alt="<?php echo $item['username'];?>" class="m_sub_img" src="<?php echo $item['face'];?>"></a></dt>
<dd><a href="<?php echo U('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a></dd>
</dl>
<?php }?>

<br clear="all">

<a href="<?php echo U('user','followed',array(userid=>$strUser['userid']))?>">&gt; 被<?php echo $strUser['count_followed'];?>人关注</a>

</div>

<div id="group" class="">

<h2>
<?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
我参加的小组
<?php } else { ?>
<?php echo $strUser['username'];?>参加的小组
<?php } ?>
&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
<span class="pl">&nbsp;(
<a href="<?php echo U('group','groups',array('userid'=>$strUser['userid']))?>">全部</a>
) </span>
</h2>

<?php foreach((array)$arrGroup as $key=>$item) {?>
<dl class="ob"><dt><a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><img alt="<?php echo $item['groupname'];?>" class="m_sub_img" src="<?php echo $item['icon_48'];?>"></a></dt>
<dd><a href="<?php echo U('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> <span>(<?php echo $item['count_user'];?>)</span>
</dd></dl>
<?php }?>

<div class="clear"></div>

</div>
<br/>
<p class="pl">本页永久链接: <a href="<?php echo U('hi','',array('id'=>$strUser['doname']))?>"><?php echo U('hi','',array('id'=>$strUser['doname']))?></a></p>
<br>
<p class="pl">订阅<?php echo $strUser['username'];?>的收藏 <br>
<span class="feed"><a href="#"> feed: rss 2.0</a></span>
</p>
</div>


</div>
</div>
<?php include template('footer'); ?>