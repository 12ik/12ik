<?php include template('header'); ?>

<div class="midder">
<div class="mc">
<h1 class="group_tit">
<?php echo $strGroup['groupname'];?>发布帖子
</h1>

<?php if($isGroupUser == '0') { ?>
<div style="font-size:14px;padding-top:50px;text-align:center;">不好意思，你不是本组成员不能发表帖子，请加入后再发帖</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lib/ajaxfileupload.js"></script>
<form method="POST" action="<?php echo U('group','add',array('ik'=>'do'))?>" onsubmit="return newTopicFrom(this)"  enctype="multipart/form-data" id="form_tipic">
<table width="100%" cellpadding="0" cellspacing="0" class="table_1">

	<tr>
    	<th>标题：</th>
		<td><input style="width:400px;" type="text" value="" maxlength="100" size="50" name="title" gtbfieldid="2" class="txt"   placeholder="请填写标题"></td></tr>	
    <tr><th>&nbsp;</th><td align="left" style="padding:0px 10px"><a href="javascript:addPhoto();">添加图片</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a class="video-btn" href="javascript:addVideo();">添加视频</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a id="addlink" href="javascript:addLink();">添加链接</a></td></tr>
    <tr>
        <th>内容：</th><td><textarea style="width:99.5%;height:300px;" id="editor_full" cols="55" rows="20" name="content" class="txt"   placeholder="请填写内容"></textarea></td>
    </tr>
    <tr>
        <th>评论：</th>
        <td><input type="radio" checked="select" name="iscomment" value="0" />允许 <input type="radio" name="iscomment" value="1" />不允许</td>
    </tr>	
    <tr>
    	<th>&nbsp;</th><td>
        <input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
        <input type="hidden" name="topic_id" value="<?php echo $topic_id;?>" id="topic_id" />
        <input class="submit" type="submit" value="好啦，发布"> <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>">返回</a>
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
<script language="javascript">

function addLink(){
	
	var templ_link =    '<form class="frm-addlink">'+
				'<div class="item">'+
                '<label>链接文字：</label><input name="linktext" type="text" value="SEL">'+
                '</div>'+
                '<div class="item">'+
                '<label>网址：</label><input name="href" type="text" value="">'+
				'</div>'+
            '</form>';
	var s = $('#editor_full').get_sel();
	var thtml = templ_link.replace('SEL', s);
	pop_win([
	'<div class="rectitle"><span class="m">添加链接</span></div>',
	'<div class="panel">',thtml,
	'</div>',
	'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn">',
	'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
	
	var addlink = function(frm, o){
            var text = $.trim(frm.find('input[name=linktext]').val()),
            url = $.trim(frm.find('input[name=href]').val());
            if(url !== ''){
              url = /^http:\/\//.test(url)? url:"http://"+url;
              $('#editor_full').insert_caret('[url=' + url + ']' + (text===''? url : text) + "[/url]");
              o.close();
            }
        };
	$('.pop_win .confirmbtn').live('click',function(){
		addlink( $('.frm-addlink'), pop_win);	
	});
	//
 	var frmaddlink = $('.frm-addlink');
	$('input', frmaddlink).live('keydown',function(e){
		var keyCode = e.keyCode; 
		if (keyCode === 10 || keyCode === 13 ) {
			addlink( $('.frm-addlink'), pop_win);	
		}
	});	
}
function addPhoto(){
    pop_win([
        '<div class="rectitle"><span class="m">添加图片</span></div>',
        '<div class="panel">',
            '<span class="pl"> 图片的大小不超过3M </span><br><br>',
            '<form>',
                '<span class="pl">选择图片</span> ',
                '<input id="file" type="file" name="file"/>',
                '<br><br><br><input id="startup" type="button"  class="confirmbtn" onclick="ajaxFileUpload(); return false;" value="开始上传">',
                '<input type="button" onclick="pop_win.close();" value="取消" class="cancellinkbtn">',
                '</form>',
        '</div><div class="waiting">正在上传中......</div>'].join('') );
	
}
function ajaxFileUpload(){

       $.ajaxFileUpload(
            {
                url : "<?php echo U('group','add',array('ik'=>'add_photo'))?>",
                fileElementId : 'file',
                dataType : 'json',
                allowType : 'jpg|png|gif|jpeg',
                extra : {'topic_id':'<?php echo $topic_id;?>',
                         //'topic_id_sig':'7d887dc9395a8344c1c774ac7d7c495e10c3cb33',
                         'ck':get_cookie('ck')
                },
                begin : function(){
                    $('.pop_win')
                      .find('.panel').css('visibility', 'hidden')
                      .end()
                      .find('.waiting').show()
                      .end()
                      .find('.pop_win_close').hide();
                },
                complete : function(){
                  pop_win.close();
                },
                success : function(data, status){ 
                    if(data.r == 1){
                        //console.log(data.err_msg);
                        alert(data.html);
                    }else{
                        var html = buildPhotoThumbDetail(data);
                        var oThumbList = $("#thumblst");
                        var oPhotoDiv = $(html);
                        oPhotoDiv.prependTo(oThumbList);
                        oThumbList.show();

                        var oText = $("textarea[name='content']");
                        oText.val(oText.val() + "[图片" + data.seq_id +"]");
                    }
                },
                error : function(data, status, e){
                    // console.log(e);
                }
            }
       ); 
       return false;
}

function buildPhotoThumbDetail(data){
        var html = '<div class="thumblst">';

        html += '<div class="details"><p>图片描述（30字以内）</p> <textarea maxlength="30" name="p_' + data.seq_id + '_title">'+ data.title + '</textarea><input type="hidden" name="p_' + data.seq_id + '_seqid" value="' + data.seq_id + '" ><br/><br/>图片位置<br/>'+ '<a name="rm_p_' + data.seq_id + '"   class="minisubmit rr j a_remove_pic"  onclick="javascript:removePhoto(this, \''+ data.seq_id +'\');return false;">删除</a>';

        if(data.layout == "L"){
            html += '<label><input type="radio" value="' + "L" + '" name="p_' + data.seq_id + '_layout" checked="checked" /> <span class="alignleft">居左</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "L" + '" name="p_' + data.seq_id + '_layout" /> <span class="alignleft">居左</span></label>';
        }

        if(data.layout == "C") {
            html += '<label><input type="radio" value="' + "C" + '" name="p_' + data.seq_id + '_layout" checked="checked" /> <span class="aligncenter">居中</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "C" + '" name="p_' + data.seq_id + '_layout" /> <span class="aligncenter">居中</span></label>';
        }

        if(data.layout == "R") {
            html += '<label><input type="radio" value="' + "R" + '" name="p_' + data.seq_id + '_layout" checked="checked" /> <span class="alignright">居右</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "R" + '" name="p_' + data.seq_id + '_layout" /> <span class="alignright">居右</span></label>';
        }

        
        html += '</div><div class="thumb"><div class="pl">[图片' + data.seq_id + ']</div> <img src="' + data.small_photo_url + '"/> </div><div class="clear"></div> </div>';
        

        return html;
}
function removePhoto(obj, seq_id){
	var ck = get_cookie('ck');
    var data = "seq_id=" + seq_id + "&ck="+ck;
    $.ajax({
        type:       "post",
        url:        "<?php echo U('group','add',array('ik'=>'remove_photo', 'topic_id'=>$topic_id))?>",
        dataType:   "json",
        data:       data,
        success:    function(data, status){
            var oText, o = $(obj);
            if(data.r == 0){
                oText = $("textarea[name='content']");
                oText.val(oText.val().replace('[图片' + seq_id + ']', ''));
                 o.closest(".thumblst").slideUp('fast',function(){$(this).remove()});
            }else{
                // console.log('fail');
            }
        },
        error:  function(data, status){
            // console.log('error');
        }
    });
}
//视频模块
var formNote = $('#form_tipic'),
	control_panel = $('.control-panel', formNote),
	videos = formNote.children('.videos'),
	nid = '<?php echo $topic_id;?>';
function addVideo()
{

	pop_win([
	'<div class="rectitle"><span class="m">添加视频</span></div>',
	'<div class="panel">',
	'<div class="frm-addvideo">',
	'<div class="item tips" id="videotips"></div>',
	'<div class="item" style="text-align:left">',
	'目前爱客网支持抓取视频网站的有：土豆网、优酷网、酷6网、56网、的视频，其他网站视频会陆续推出。',
	'</div>',
	'<div class="item">',
	'<label>输入视频播放页地址：</label><input name="url" type="text" value="">',
	'</div>',
	'<div class="item" style="text-align:left;color:red" id="videerror"></div>',	
	'</div></div>',
	'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn" onclick="addRemoteVideo();">',
	'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
}
function addRemoteVideo(frm, o){
			var frm =  $('.frm-addvideo'), o = pop_win;
			var vurl = $.trim(frm.find('input[name=url]').val());
			//var ck = get_cookie('ck');
            if(vurl!=''){
				$('.pop_win').find('.confirmbtn').attr('disabled','disabled');
	 			$.ajax({
                    type: 'post',
                    url: "<?php echo U('group','add',array('ik'=>'add_video'))?>",
                    data: {
						topic_id: nid,
                        url: encodeURIComponent(vurl)  //编码传送
                    },
                    beforeSend: function() {
                       $('#videotips').css('color','green').html('正在抓取视频中。。');
                    },					
                    success: function(data) { 
                        if (data.r) {
                            // displayError
                            $('#videotips').css('color','red').html(data.html);
                            return;
                        }
						buildVideoDetail(data);
						$('#videotips').html('');
                        $('#editor_full').insert_caret('[视频' + data.seqid + ']');
                        o.close();
						
                    },
                    error: function() {
                        that.showError('网络错误!');
                    }
                });
            }
}
function buildVideoDetail(data){
        var html = '<div class="thumblst">';

        html += '<div class="details"><p>视频标题（30字以内）</p> <textarea maxlength="30" name="video_' + data.seqid + '_title">'+ data.title + '</textarea><input type="hidden" name="video_' + data.seqid + '" value="' + data.seqid + '" ><br/><br/>视频网址：<br/>'+ '<a name="rm_p_' + data.seqid + '"   class="minisubmit rr j a_remove_pic"  onclick="javascript:removeVideo(this, \''+ data.seqid +'\');return false;">删除</a><p>'+ data.url +'</p>';
        
        html += '</div><div class="thumb"><div class="pl">[视频' + data.seqid + ']</div> <img src="' + data.imgurl + '"/> </div><div class="clear"></div> </div>';
		
		$('#videosbar').append(html).show();
}
//删除视频
function removeVideo(obj, seq_id){
	var ck = get_cookie('ck');
    var data = "seq_id=" + seq_id + "&ck="+ck;
    $.ajax({
        type:       "post",
        url:        "<?php echo U('group','add',array('ik'=>'remove_video', 'topic_id'=>$topic_id))?>",
        dataType:   "json",
        data:       data,
        success:    function(data, status){
            var oText, o = $(obj);
            if(data.r == 0){
                oText = $("textarea[name='content']");
                oText.val(oText.val().replace('[视频' + seq_id + ']', ''));
                o.closest(".thumblst").slideUp('fast',function(){$(this).remove()});
            }else{
                // console.log('fail');
            }
        },
        error:  function(data, status){
            // console.log('error');
        }
    });
}
</script>
</form>

<?php } ?>


</div>
</div>


<?php include template('footer'); ?>