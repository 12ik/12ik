 <!--头部-->
<?php include template('site_header'); ?>
<!--//头部-->
<!--导航-->
<?php include template('site_nav'); ?>
<!--//导航-->
 
<!--内容-->
<div id="content">
    <!--main-->

<style>
#type_tip { float:left;width:150px;color:#666; }
.thumblst { min-height: 140px; border: 1px solid #d3d3d3; background:#f0f0f0; padding: 10px 12px; margin: 3px 0 7px }
.thumblst .thumb { float: left; width: 145px }
.thumblst .thumb img { max-width: 130px; _width: 130px }
.thumblst .thumb .pl { padding:2px; border:1px solid #ddd;margin-bottom:6px;background:#fff;}
.thumblst .details { float: right; width: 419px }
.thumblst .details textarea{ width: 410px; height:66px;border:1px solid #ccc;}
.rr { float:right; }
.attn { color:#f30; }
#album_up { float:left;margin-left:20px;width:300px; }
#rulediv { clear:both; }
#rulediv label { width:auto; }
.btn-green { border: none; cursor: pointer; color: #fff; font-size: 14px; width: 115px; height: 29px; background: url(/app/site/pics/upload-btns-bg.png) no-repeat }
.btn-green:hover { background-position: 0 -29px }
.btn-green:active { background-position: 0 -58px }
</style>  
<script>
IK.add('uploadify-css', {path: '<?php echo SITE_URL;?>public/js/uploadify/uploadify.css', type: 'css'});
IK.add('uploadify', {path: '<?php echo SITE_URL;?>public/js/lib/jquery.uploadify.min.js', type:'js', requires: ['<?php echo SITE_URL;?>public/js/uploadify/swfobject.js','uploadify-css']});
</script>  
    <div class="main"> 
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'list','photosid'=>$photosid))?>">&gt; 返回<?php echo $strPhotos['title'];?></a>
        </div>
        
        <h1><?php echo $title;?></h1>
        
        <div class="mod">
            	

<div class="bd">
    

<div id="photos-upload">
   
        <div>
            <div id="fileQueue" style="margin:10px 0px"></div>
            <input type="file" id="uploadify" />
            <p style="padding:10px 0;">提示：每次最多可以批量上传二十张照片，按着 "ctrl" 键可以一次选<br>
				择多张照片;上传文件只支持：jpg，gif，png格式；上传最大支持1M的图片</p>
            <p style="padding:10px 0;">
            <input type="button" class="btn-green" value="开始上传" id="upload-start" >&nbsp;&nbsp;|&nbsp;&nbsp; 
            <a href="javascript:;" id="btnCancel">取消上传</a>
            </p>
        </div>
   
</div>
<div>
    无法上传？<a href="<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'baseupload','photosid'=>$photosid))?>">使用普通方式上传照片 &gt;</a>
</div>

<script type="text/javascript">
    var loadurl = "<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'addphoto',photosid=>$photosid))?>";
	var objdata = {'userid': '<?php echo $IK_USER['user'][userid];?>','photosid': '<?php echo $photosid;?>'};
	var jumpurl = "<?php echo SITE_URL;?><?php echo tsurl('site','photos',array('ts'=>'complete',photosid=>$photosid,'addtime'=>$addtime))?>";
IK('uploadify', function() {

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
	
	$('#upload-start').click(function(){
		$('#uploadify').uploadifyUpload(); 
	});
	
	$('#btnCancel').click(function(){
		$('#uploadify').uploadifyClearQueue(); 
	});	
	

});

</script>

</div><!--//bd-->

        </div>

    </div>
    
    <!--//main-->
    
    <!--aside-->      
    <div class="aside">  
    
    </div>
    <!--//aside-->  

    <div class="extra">
         
    </div>
 
</div>
<!--//内容-->

<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->
