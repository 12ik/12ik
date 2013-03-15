<?php include template('header'); ?> 

<!--main-->
<div class="midder">
  <div class="mc">
    <h1>发送短消息</h1>
    <form method="POST" action="<?php echo U('user','message',array('ik'=>'message_add_do'))?>">
      <table class="table_1" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <th>收件人：</th>
          <td><img alt="<?php echo $strTouser['username'];?>" class="m_sub_img" src="<?php echo $strTouser['face'];?>" /><br /><?php echo $strTouser['username'];?></td>
        </tr>
        <tr>
          <th>标题：</th>
          <td><input type="text" placeholder="请填写标题" class="txt"  name="title" size="50" maxlength="64" value="" style="width:400px;"></td>
        </tr>        
        <tr>
          <th>内容：</th>
          <td><textarea class="utext" name="content" style="width:570px; height:170px"></textarea></td>
        </tr>
        <tr>
          <th></th>
          <td>
            <input type="hidden" name="userid" value="<?php echo $strUser['userid'];?>" />
            <input type="hidden" name="touserid" value="<?php echo $strTouser['userid'];?>" />
            <input type="submit" value="好了，发送" class="submit" />&nbsp;&nbsp;<a href="<?php echo U('message','ikmail',array('ik'=>'inbox'))?>">取消</a>
            </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include template('footer'); ?> 