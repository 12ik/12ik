<?php include template('header'); ?>

<div class="midder">

  <div class="mc">
    <h1><?php echo $title;?></h1>
	<div class="cleft">
       
        <form method="POST" action="<?php echo SITE_URL;?>index.php?app=photo&a=album&ik=create_do">
  <table width="100%" cellpadding="0" cellspacing="0" class="table_1">
            <tr>
                <th>相册名称：</th>
                <td><input name="albumname" maxlength="20" size="47" class="txt"  placeholder="相册名称必填"/></td>
           </tr>
            <tr>
                <th>相册介绍：</th>
                <td><textarea name="albumdesc" maxlength="130"  style=" width:500px;height:200px;" class="txt" placeholder="写点儿相册介绍吧"></textarea></td>
           </tr>
           <tr>
           		<th></th>
                <td>
                <input class="submit" type="submit" value="创建相册" />  <a href="<?php echo U('photo','album',array(ik=>user,userid=>$userid))?>">返回我的相册</a></td>
           </tr> 
     </table>
        </form>
	</div>
    
    <div class="cright">
    
    </div>

  </div>
</div>

<?php include template('footer'); ?>