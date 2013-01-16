<?php include template('header'); ?>

<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>

<?php if($IK_USER['user'][face] == '') { ?>
<div style="font-size:14px; line-height:30px">请上传头像后才可以正常使用浏览网站^_^</div>
<?php } ?>
<div class="face_form">
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ik=setface" enctype="multipart/form-data" >

    <img alt="<?php echo $IK_USER['uname'];?>" valign="middle" src="<?php echo $strUser['face'];?>?v=<?php echo rand();?>" class="pil" />
    
    
    <div class="file_info">
    	<p>从你的电脑上选择图像文件：(仅支持jpg，gif，png格式的图片)</p>
    	<p><input type="file" name="picfile" style="height:25px; "/>&nbsp;&nbsp;<input class="submit" type="submit" value="上传照片" /></p>
    </div>

</form>

</div>



</div>
</div>

<?php include template('footer'); ?>