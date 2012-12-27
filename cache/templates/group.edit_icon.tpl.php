<?php include template('header'); ?>

<!--main-->
<div class="midder">

<div class="mc">
<?php include template('edit_xbar'); ?>
<div class="cleft">
	<div class="face_form">
    
        <form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=do&ik=groupicon" enctype="multipart/form-data" >
          <img align="left" alt="<?php echo $strGroup['groupname'];?>" title="<?php echo $strGroup['groupname'];?>" valign="middle" src="<?php echo $strGroup['icon_48'];?>" class="pil">
          <div class="file_info">
    		<p>从你的电脑上选择图像文件：(仅支持jpg，gif，png格式的图片)</p>
    		<p><input type="file" style="height:25px; " name="picfile">&nbsp;&nbsp;<input type="submit" value="上传照片" class="submit">
               <input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" /></p>
    	  </div>
        </form>
        
	</div>

</div>

<div class="cright">

<p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?>">返回<?php echo $strGroup['groupname'];?></a></p>

</div>

</div>

</div>
<?php include template('footer'); ?>