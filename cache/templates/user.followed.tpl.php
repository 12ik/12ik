<?php include template('header'); ?>

<div class="midder">

<div class="mc">
	<h1><?php echo $title;?>(<?php echo $strUser['count_followed'];?>)</h1>
	<div class="cleft">

<ul class="user-list">
<?php foreach((array)$arrFollowedUser as $key=>$item) {?>
    <li class="clearfix" id="u<?php echo $item['userid'];?>">
        <a title="<?php echo $item['username'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>">
        <img alt="<?php echo $item['username'];?>" src="<?php echo $item['face'];?>" class="face">
        </a>
        <div class="info">
          <h3>
              <a title="<?php echo $item['username'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a>
              <?php if($item['isfollow'] ) { ?><span class="user-cs">已关注</span><?php } ?>
          </h3>
          <!-- 签名档 -->
          <p><?php echo $item['area']['areaname'];?><br>
             被<b><?php echo $item['count_followed'];?></b>人关注&nbsp;&nbsp;关注<b><?php echo $item['count_follow'];?></b>人          
          </p>
        </div>
        <!--<span class="ban">加入黑名单</span>-->
    </li>
<?php }?>          
</ul>

    </div>

    <div class="cright">

<?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo ikurl('user','follow',array('userid'=>$userid))?>">我关注的人(<?php echo $strUser['count_follow'];?>)</a>
        </p> 
<?php } else { ?>
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo ikurl('user','follow',array('userid'=>$userid))?>"><?php echo $strUser['username'];?>关注的人(<?php echo $strUser['count_follow'];?>)</a>
        </p> 
<?php } ?>               
<!---
        <p class="pl2">
            &gt;&nbsp;<a href="/contacts/find">寻找&nbsp;MSN/Gtalk&nbsp;朋友</a>
        </p>
-->        
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo SITE_URL;?><?php echo ikurl('user','contacts',array('ik'=>'invite'))?>">邀请我的朋友加入爱客网</a>
        </p>


    </div>

</div>
</div>
<?php include template('footer'); ?>