<?php include template('header'); ?>
<div class="midder">
    <div class="mc">
        <h1>
        <?php echo $title;?>
        </h1>    
<form method="POST" action="<?php echo U('article','do',array('ik'=>'update'))?>"  onsubmit="return checkForm(this);"  enctype="multipart/form-data" id="form_tipic">
<table width="100%" cellpadding="0" cellspacing="0" class="table_1">

	<tr>
    	<th>标题：</th>
		<td><input style="width:400px;" type="text" value="" maxlength="100" size="50" name="title" tabindex="1" class="txt"   placeholder="请填写标题"></td>
    </tr>	
    <tr>
        <th>发表到：</th>
        <td>
            <select name="import" class="txt" id="cate_select" style="float:left;" tabindex="2" >
                <option  value="0">默认分类</option>
                <?php echo $arrSelect;?>
            </select>            
        </td>
    </tr>
    <tr><th>&nbsp;</th><td align="left" style="padding:0px 10px"><a href="javascript:;" id="addImg">添加图片</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a class="video-btn" href="javascript:addVideo();">添加视频</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a id="addlink" href="javascript:addLink();">添加链接</a></td></tr>
    <tr>
        <th>内容：</th>
        <td>
        <textarea tabindex="3"  style="width:99.5%;height:300px;" maxlength="10000" id="editor_full" cols="55" rows="20" name="content" class="txt"   placeholder="请填写内容"></textarea>
        <div class="ik_toolbar" id="ik_toolbar"><span class="textnum" id="textnum"><em>0</em> / <em>10000</em> 受欢迎的字数 </span></div>
        </td>
    </tr> 
    <tr>
    	<th>&nbsp;</th><td>
        <input type="hidden" name="itemid" value="<?php echo $itemid;?>" id="itemid"  />
        <input class="submit" type="submit" value="好啦，发表" tabindex="4" > <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>">返回</a>
        </td>
    </tr>
</table>
<div id="thumblst" class="item item-thumb-list">
	<?php foreach((array)$arrPhotos as $item) {?>
    <div class="thumblst">
      <div class="details">
        <p>图片描述（30字以内）</p>
        <textarea name="p_<?php echo $item['seqid'];?>_title" maxlength="30"><?php echo $item['photodesc'];?></textarea>
        <input type="hidden" name="p_<?php echo $item['seqid'];?>_seqid" value="<?php echo $item['seqid'];?>" >
        <br>
        <br>
        图片位置<br>
        <a onclick="javascript:removePhoto(this, '<?php echo $item['seqid'];?>');return false;" class="minisubmit rr j a_remove_pic" name="rm_p_<?php echo $item['seqid'];?>">删除</a>
        <label>
          <input type="radio" name="p_<?php echo $item['seqid'];?>_layout" <?php if($item['align']==L) { ?> checked <?php } ?> value="L" >
          <span class="alignleft">居左</span></label>
        <label>
          <input type="radio" name="p_<?php echo $item['seqid'];?>_layout" <?php if($item['align']==C) { ?> checked <?php } ?> value="C" >
          <span class="aligncenter">居中</span></label>
        <label>
          <input type="radio" name="p_<?php echo $item['seqid'];?>_layout" <?php if($item['align']==R) { ?> checked <?php } ?> value="R" >
          <span class="alignright">居右</span></label>
      </div>
      <div class="thumb">
        <div class="pl">[图片<?php echo $item['seqid'];?>]</div>
        <img src="<?php echo $item['photo_140'];?>">
      </div>
      	<div class="clear"></div>
    </div>
    <?php } ?>

</div>
<div id="videosbar"  class="item item-thumb-list">
	<?php foreach((array)$arrVideos as $item) {?>
   <div class="thumblst">
  <div class="details">
    <p>视频标题（30字以内）</p>
    <textarea name="video_<?php echo $item['seqid'];?>_title" maxlength="30">人在囧途</textarea>
    <input type="hidden" value="<?php echo $item['seqid'];?>" name="video_<?php echo $item['seqid'];?>">
    <br>
    <br>
    视频网址：<br>
    <a onclick="javascript:removeVideo(this, '<?php echo $item['seqid'];?>');return false;" class="minisubmit rr j a_remove_pic" name="rm_p_1">删除</a>
    <p><?php echo $item['url'];?></p>
  </div>
  <div class="thumb">
    <div class="pl">[视频<?php echo $item['seqid'];?>]</div>
    <img src="<?php echo $item['imgurl'];?>"> </div>
  <div class="clear"></div>
</div>

    <?php } ?>
</div>
<!--加载编辑器-->
<script language="javascript">
$(function(){
	$('#addImg').bind('click',function(){
		var ajaxurl = "<?php echo U('article','do',array('ik'=>'add_photo'))?>";
		var data = "{'type':'article','typeid':'<?php echo $itemid;?>'}";		
		addPhoto(ajaxurl, data);
	})
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lib/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lib/IKEditor.js"></script>

</form>

    
    </div>
</div>



<?php include template('footer'); ?>