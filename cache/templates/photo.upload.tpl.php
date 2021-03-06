<?php include template('header'); ?>

<script src="<?php echo SITE_URL;?>public/js/uploadify/jquery.uploadify.v2.1.4.js" type="text/javascript"></script>

<script src="<?php echo SITE_URL;?>public/js/uploadify/swfobject.js" type="text/javascript"></script>

<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>public/js/uploadify/uploadify.css" />

<script type="text/javascript">
    var loadurl = "<?php echo U('photo','do',array('ik'=>'flash',albumid=>$albumid))?>";
	var objdata = {'userid': '<?php echo $IK_USER['user'][userid];?>','albumid': '<?php echo $albumid;?>'};
	var jumpurl = "<?php echo U('photo','album',array('ik'=>'info',albumid=>$albumid,'addtime'=>$addtime))?>";
$(document).ready(function()
{		
	$("#uploadify").uploadify({
		'uploader': siteUrl + 'public/js/uploadify/uploadify.swf',
		'expressInstall': siteUrl + 'public/js/uploadify/expressInstall.swf',
		'script': loadurl,
		'scriptData':objdata,
		'method':'POST', 
		'cancelImg': siteUrl+'public/js/uploadify/cancel.png',
		'folder': 'UploadFile',
		'queueID': 'fileQueue',
		'auto': false,
		'multi': true,
		'buttonText': '',
		'buttonImg': siteUrl+'public/images/upload-btns.png',		
		'fileDesc':'jpg,gif,png图片格式',
		'fileExt':'*.jpg;*.gif;*.png',
		'onAllComplete' : function(event,data) {
			window.location = jumpurl;
		}

	});

})

</script>

<div class="midder">

<div class="mc">

	<h1>上传照片 - <?php echo $strAlbum['albumname'];?></h1>

    <div class="cleft">
    
    
    
        <div>
            <div id="fileQueue"></div>
            <input type="file" id="uploadify" />
            <p style="padding:10px 0;">上传文件只支持：jpg，gif，png格式；上传最大支持1M的图片</p>
            <p style="padding:10px 0;">
            <a href="javascript:$('#uploadify').uploadifyUpload()" class="submit">开始上传</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
            <a href="javascript:$('#uploadify').uploadifyClearQueue()" >取消上传</a>
            </p>
        </div>
    
    </div>

    <div class="cright">
        所有相册空间的总容量为 1G，现在还剩1023M。
        <br><br>
        <p class="pl2">&gt; <a href="<?php echo U('photo','album',array(ik=>photo,albumid=>$strAlbum['albumid']))?>">回相册"<?php echo $strAlbum['albumname'];?>"</a></p>
    </div>

</div>
</div>

<?php include template('footer'); ?>