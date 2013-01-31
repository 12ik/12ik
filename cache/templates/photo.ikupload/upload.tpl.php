<?php include template("ikupload/header");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lib/ajaxfileupload.js"></script>
<div class="pop_win">
    <div class="panel"><span class="pl">图片的大小不超过1M </span><br>
      <br>
      <form>
        <span class="pl">选择图片</span>
        <input type="file" name="file" id="file">
        <br>
        <br>
        <div class="fd">
   		<input type="button" value="开始上传" onclick="ajaxFileUpload(); return false;" class="confirmbtn" id="startup">
        <input type="button" class="cancellinkbtn" value="取消" id="xheCancel" onClick="callback()">
        </div>
      </form>
    </div>
    <div class="waiting">正在上传中......</div>
    <div class="error"></div>
</div>
<script language="javascript">
function ajaxFileUpload(){
	   if($('#file').val() !='')
	   {
		   $.ajaxFileUpload(
				{
					url : "<?php echo SITE_URL;?><?php echo ikurl('photo','ikupload',array('ik'=>'addimage'))?>",
					fileElementId : 'file',
					dataType : 'json',
					allowType : 'jpg|png|gif|jpeg',
					extra : {'type':'<?php echo $type;?>','typeid':'<?php echo $typeid;?>'},
					begin : function(){
						$('.pop_win').find('#startup').attr('disabled','disabled')
						  .find('.waiting').show()
						  .end();
					},
					complete : function(){
					  
					},
					success : function(data, status){ 
						if(data.r==1)
						{
							$('.pop_win').find('.error').html(data.html).show();
							$('.pop_win').find('#startup').removeAttr('disabled')
						}else{
							var photo_url = '<img src="'+data.photo_500+'"/>';
							callback(photo_url);
						}
						
					},
					error : function(data, status, e){
						// console.log(e);
					}
				}
		   ); 		  
	   }
       return false;
}
</script>
</body>
</html>
