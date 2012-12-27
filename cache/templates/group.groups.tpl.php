<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1>某某某管理的小组</h1>
    <div class="cleft">
    
    <h2>我管理的小组 &nbsp; ·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;</h2>
    
        <div class="obss"><dl class="obu"><dt><a class="nbg" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$strLeader['doname']))?>"><img alt="mido" class="m_sub_img" src="<?php echo $strLeader['face'];?>"></a></dt>
        <dd><?php echo $strLeader['username'];?><br><span class="pl">(<a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$strLeader['area'][areaid]))?>"><?php echo $strLeader['area'][areaname];?></a>)</span></dd></dl><br clear="all">
        </div>
    
    <h2>我参加的小组 &nbsp; ·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;</h2>
    
        <div class="obss">
        
        <?php foreach((array)$arrAdmin as $key=>$item) {?>
        <dl class="obu"><dt><a class="nbg" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>"><img alt="<?php echo $item['username'];?>" class="imgg" src="<?php echo $item['face'];?>"></a>
        <?php if($IK_USER['user'][userid] == $strLeader['userid']) { ?>
        <span title="取消管理员" class="gact"><a title="取消<?php echo $item['username'];?>的管理员" class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=group&ac=group_user_set&ik=isadmin&userid=<?php echo $item['userid'];?>&groupid=<?php echo $strGroup['groupid'];?>&isadmin=0" rel="nofollow">^</a></span>
        <?php } ?>
        </dt><dd><?php echo $item['username'];?><br><span class="pl">(<a href="<?php echo SITE_URL;?><?php echo ikurl('location','area',array(areaid=>$item['area'][areaid]))?>"><?php echo $item['area'][areaname];?></a>)</span></dd></dl>
        <?php }?>
        
        
        <br clear="all">
        </div>
    
    
    </div>


    <div class="cright">
    
    </div>
</div>
</div>

<?php include template('footer'); ?>