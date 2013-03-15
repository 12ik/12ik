<?php include template('header'); ?>
<!--main-->
<div class="midder">
	<div class="mc">
    	<h1><?php echo $title;?></h1>
    	<div class="cleft">
        	

  <table width="100%" cellpadding="0" cellspacing="0" class="showtable">
      <tr>
        <td width="75" valign="top">
        <?php if($touser['userid']) { ?>
        <a href="<?php echo U('hi','',array('id'=>$touser['doname']))?>" class="nbg">
       	 <img alt="<?php echo $touser['username'];?>" style="padding:5px;" src="<?php echo $touser['face'];?>">
        </a>
        <?php } else { ?>
         <img alt="<?php echo $touser['username'];?>" style="padding:5px;" src="<?php echo $touser['face'];?>">
        <?php } ?>
        </td>
        <td valign="top">
   
          <div class="pl2"><?php echo $strUserinfo;?></div>
          <div class="pl2">时间: <?php echo $arrMessages['addtime'];?></div>
          <div class="ul"><span class="pl2">话题: </span><span class="m"><?php echo $arrMessages['title'];?></span></div>
          <div class="messagebox">
          <?php echo nl2br(stripslashes($arrMessages['content']))?>
          </div>
          <?php if($type == 'inbox') { ?>
          	<?php if($arrMessages['userid']!=0) { ?>
          <a class="submit"  title="回信" href="<?php echo U('user','message',array('ik'=>'message_add','touserid'=>$touser['userid']))?>">回信</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
          <a class="gray-submit" onclick="return confirm('真的要删除消息吗?')" title="删除" href="<?php echo U('message','do',array('ik'=>'del','type'=>'inbox','messageid'=>$messageid))?>">删除</a>           
          <?php } ?>
          <?php if($type == 'outbox') { ?>
          <a class="gray-submit" onclick="return confirm('真的要删除消息吗?')" title="删除" href="<?php echo U('message','do',array('ik'=>'del','type'=>'outbox','messageid'=>$messageid))?>">删除</a>           
          <?php } ?>
          </td>
      </tr>
  </table>

             
        </div>
        <div class="cright">
            <?php if($type == 'inbox') { ?>
			<p class="pl2">&gt; <a href="<?php echo U('message','ikmail',array('ik'=>'inbox'))?>">返回到我的收件箱</a></p>
			<p class="pl2">&gt; <a href="<?php echo U('hi','',array('id'=>$touser['doname']))?>">去<?php echo $touser['username'];?>的主页看看</a></p>
            <?php } ?>
            <?php if($type == 'outbox') { ?>
			<p class="pl2">&gt; <a href="<?php echo U('message','ikmail',array('ik'=>'outbox'))?>">回我的发件箱</a></p>
            <p class="pl2">&gt; <a href="<?php echo U('message','ikmail',array('ik'=>'inbox'))?>">去我的收件箱</a></p><br/>
			<p class="pl2">&gt; <a href="<?php echo U('hi','',array('id'=>$touser['doname']))?>">去<?php echo $touser['username'];?>的主页看看</a></p>
            <?php } ?>            
        </div>
    </div>
</div>

<?php include template('footer'); ?>