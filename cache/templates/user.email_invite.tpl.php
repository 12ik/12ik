<?php include template('header'); ?>
<!--main-->
<div class="midder">
<div class="mc">
<h1><?php echo $IK_SITE['base'][site_title];?>邀请</h1>
	<div class="cleft">
        <h2 style="letter-spacing:normal; margin-top:0px; margin-bottom:12px"> 邀请你的朋友来爱客&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;· </h2>
        
        <?php if($msg) { ?><?php echo $msg;?><?php } ?>
        <p>你的朋友注册后将自动出现在"我的朋友"里</p>
        <h2 style="letter-spacing:normal; margin-top:0px"><?php echo $strUser['username'];?>朋友们的email：</h2>
        <p>多个email用逗号隔开</p>
        
        <form name="lzform" method="post" action="<?php echo SITE_URL;?><?php echo ikurl('user','contacts',array('ik'=>'sendmail'))?>">
          <div style="display:none;">
            <input  name="ck" value="" type="hidden">
          </div>
          <textarea name="emails" cols="70" rows="3" class="utext" style="width:550px; height:110px"></textarea>
          <br>
          <h2 style="letter-spacing:normal">想在爱客网发出的邀请信中加几句话吗？</h2>
          <textarea name="message" cols="70" rows="8" class="utext" style="width:550px; height:110px"></textarea>
          <br>
          <input name="submit" value="邀请" type="submit" class="submit">
        </form>
    </div>
    <div class="cright">
    	
    </div>
</div>

</div>

<?php include template('footer'); ?>