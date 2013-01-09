<?php include template("ajax/header");?>
<script src="<?php echo SITE_URL;?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/uploadify/jquery.uploadify.v2.1.4.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/uploadify/swfobject.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>public/js/uploadify/uploadify.css" />
<script type="text/javascript">

$(document).ready(function()
{
	
	$("#uploadify").uploadify({
		'uploader': '<?php echo SITE_URL;?>public/js/uploadify/uploadify.swf',
		'script': '<?php echo SITE_URL;?>index.php',
		'scriptData':{'app':'photo','ac':'do','ik':'flash','userid':'<?php echo $IK_USER['user'][userid];?>','albumid':'<?php echo $albumid;?>'},
		'method':'GET', 
		'cancelImg': '<?php echo SITE_URL;?>public/js/uploadify/cancel.png',
		'folder': 'UploadFile',
		'queueID': 'fileQueue',
		'auto': false,
		'multi': true,
		'fileDesc':'jpg,gif,png图片格式',
		'fileExt':'*.jpg;*.gif;*.png;*bmp;',
		'onAllComplete' : function(event,data) {
			window.location = "<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ik=info&albumid=<?php echo $albumid;?>&addtime=<?php echo $addtime;?>";
		}

	});

})

</script>


<p>上传文件只支持：jpg，gif，png格式；上传最大支持1M的图片</p>

<div id="fileQueue"></div>
    <input type="file" id="uploadify" />
    <p>
      <a href="javascript:$('#uploadify').uploadifyUpload()">上传</a>| 
      <a href="javascript:$('#uploadify').uploadifyClearQueue()">取消上传</a>
	  | <a href="<?php echo SITE_URL;?>index.php?app=photo&ac=ajax&ik=album">返回我的相册</a>
    </p>


</body>
</html>