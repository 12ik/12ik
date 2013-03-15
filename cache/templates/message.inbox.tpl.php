<?php include template('header'); ?>
<!--main-->
<div class="midder">
	<div class="mc">
    	<h1>我的收件箱(<?php echo $unreadnum;?>封未拆)</h1>
    	<div class="cleft">
        	<?php include template('menu'); ?>
            <div class="clear"></div>
            <div id="db-timeline-hd">
                <ul class="menu-list">
                    <li <?php if($ik=="inbox") { ?> class="on" <?php } ?>>
                        <a href="<?php echo U('message','ikmail',array('ik'=>'inbox'))?>">
                            所有消息
                        </a>
                    </li>
                    <li <?php if($ik=="unread") { ?> class="on" <?php } ?> >
                        <a href="<?php echo U('message','ikmail',array('ik'=>'unread'))?>">
                            未读消息(<?php echo $unreadnum;?>)
                        </a>
                    </li>
                    <li <?php if($ik=="spam") { ?> class="on" <?php } ?> >
                        <a href="<?php echo U('message','ikmail',array('ik'=>'spam'))?>">
                            垃圾消息(<?php echo $spamnum;?>)
                        </a>
                    </li>
                </ul>
            </div>  
		 <form  method="post" onSubmit="return isConfirmed" action="<?php echo U('message','do',array('ik'=>'all'))?>">            
            <table class="olt">
              <tbody>
                <tr>
                  <td class="pl" style="width:112px;"><span class="doumail_from">来自</span></td>
                  <td width="20"></td>
                  <td class="pl">话题</td>
                  <td class="pl" style="width:110px;">时间</td>
                  <td class="pl" style="width:40px;" align="center">选择</td>
                  <td class="pl" style="width:120px;visibility:hidden;border-bottom:none" align="center">mail_options</td>
                </tr>
                 <?php foreach((array)$arrMessage as $key=>$item) {?>    
                <tr>
                  <td><?php if($item['userid']==0) { ?><span class="sys_doumail">系统邮件</span><?php } else { ?> <span class="doumail_from"><?php echo $item['user'][username];?></span> <?php } ?></td>
                  <td class="m" align="center">&gt;</td>
                  <td><a href="<?php echo U('message','show',array('messageid'=>$item['messageid']))?>"><?php echo $item['title'];?></a></td>
                  <td><?php echo $item['addtime'];?></td>
                  <td align="center"><input name="messageid[]" value="<?php echo $item['messageid'];?>" type="checkbox"></td>
                  <td style="display: none;" class="mail_options">
                  <?php if($ik!="spam") { ?><a rel="direct" class="post_link" href="<?php echo U('message','do',array('ik'=>'spam','messageid'=>$item['messageid']))?>">垃圾消息</a><?php } ?>
                  <a onClick="return confirm('真的要删除消息吗？')" class="post_link" href="<?php echo U('message','do',array('ik'=>'del','type'=>'inbox','messageid'=>$item['messageid']))?>">删除</a>
                  </td>
                </tr>
                <?php }?>
                <tr>
                  <td colspan="4" align="right">
                    <input name="type" value="inbox" type="hidden">
                   <?php if($ik=="spam") { ?>
                    <input name="mc_submit" value="删除" data-confirm="真的要删除短消息吗?" type="submit">
				   <?php } ?> 
                   <?php if($ik=="inbox" || $ik=="unread") { ?>
                    <input name="mc_submit" value="删除" data-confirm="真的要删除短消息吗?" type="submit">
                    <input name="mc_submit" value="垃圾消息" 	type="submit">
                    <input name="mc_submit" value="标记为已读"  type="submit">
				   <?php } ?>                                                         
                  </td>
                  <td align="center"><input name="checkAll" value="checkAll" onclick="ToggleCheck(this);" type="checkbox"></td>
                </tr>
              </tbody>
            </table>
        </form>    
        </div>
        <div class="cright">
			<?php include template('rightmenu'); ?>     
        </div>
    </div>
</div>

<?php include template('footer'); ?>