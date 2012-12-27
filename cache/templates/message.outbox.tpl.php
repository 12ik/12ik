<?php include template('header'); ?>
<!--main-->
<div class="midder">
	<div class="mc">
    	<h1>我的发件箱</h1>
    	<div class="cleft">
        	<?php include template('menu'); ?>
            <div class="clear"></div>
		 <form  method="post" onSubmit="return isConfirmed" action="<?php echo SITE_URL;?><?php echo ikurl('message','do',array('ik'=>'all'))?>">               <table class="olt">
              <tbody>
                <tr>
                  <td class="pl" style="width:112px;"><span class="doumail_from">送往</span></td>
                  <td width="20"></td>
                  <td class="pl">话题</td>
                  <td class="pl" style="width:110px;">时间</td>
                  <td class="pl" style="width:40px;" align="center">选择</td>
                  <td class="pl" style="width:120px;visibility:hidden;border-bottom:none" align="center">mail_options</td>
                </tr>
                <?php foreach((array)$arrMessage as $key=>$item) {?>                
                <tr>
                  <td><span class="doumail_from"><?php echo $item['touser'][username];?></span></td>
                  <td class="m" align="center">&gt;</td>
                  <td><a href="<?php echo SITE_URL;?><?php echo ikurl('message','show',array('messageid'=>$item['messageid']))?>"><?php echo $item['title'];?></a></td>
                  <td><?php echo $item['addtime'];?></td>
                  <td align="center"><input name="messageid[]" value="<?php echo $item['messageid'];?>" type="checkbox"></td>
                  <td style="display: none;" class="mail_options">
                  <a onClick="return confirm('真的要删除消息吗？')" class="post_link" href="<?php echo SITE_URL;?><?php echo ikurl('message','do',array('ik'=>'del','type'=>'outbox','messageid'=>$item['messageid']))?>">删除</a>
                  </td>
                </tr>
                <?php }?>
                <tr>
                  <td colspan="4" align="right">
                    <input name="type" value="outbox" type="hidden">
                    <input name="mc_submit" value="删除" data-confirm="真的要删除短消息吗?" type="submit">

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