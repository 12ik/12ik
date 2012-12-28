<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1>编辑：<?php echo $strTopic['title'];?></h1>
<div class="cleft">
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lib/ajaxfileupload.js"></script>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=topic_edit&ik=do">
<table cellpadding="0" cellspacing="0" class="table_1">
	<tr>
    <th width="50">标题：</tg>
    <td><input style="width:400px;" type="text" value="<?php echo $strTopic['title'];?>" maxlength="100" size="50" name="title" gtbfieldid="2" class="txt"    placeholder="请填写标题"></td>
    </tr>
    <tr><th>&nbsp;</th><td align="left" style="padding:0px 10px"><a href="javascript:addPhoto();">添加图片</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a id="addlink" href="javascript:addLink();">添加链接</a></td></tr>
    <tr>
	<th>内容：</th>
    <td><textarea id="editor_full" style="width:100%;height:300px;" name="content" class="txt"   placeholder="请填写内容"><?php echo $strTopic['content'];?></textarea></td>
    </tr>
	
	<tr>
    <th>评论：</th>
    <td><input type="radio"  <?php if($strTopic['iscomment']=='0') { ?> checked="select" <?php } ?>    name="iscomment" value="0" />允许 
    <input type="radio"  <?php if($strTopic['iscomment']=='1') { ?> checked="select" <?php } ?>   name="iscomment" value="1" />不允许
    </td>
    </tr>
	
    <tr>
    <th>&nbsp;</th>
    <td>
	<input type="hidden" name="topicid" value="<?php echo $strTopic['topicid'];?>" />
    <input type="submit" class="submit" value="保存">&nbsp;&nbsp;<a href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$strTopic['topicid']))?>">返回</a>
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
                '<br><br><br><input id="startup" type="button" onclick="ajaxFileUpload(); return false;" value="开始上传">',
                '<input type="button" onclick="pop_win.close();" value="取消">',
                '</form>',
        '</div><div class="waiting">正在上传中......</div>'].join('') );
}
function ajaxFileUpload(){

       $.ajaxFileUpload(
            {
                url : "<?php echo SITE_URL;?><?php echo ikurl('group','add',array('ik'=>'add_photo'))?>",
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
        url:        "<?php echo SITE_URL;?><?php echo ikurl('group','add',array('ik'=>'remove_photo', 'topic_id'=>$topic_id))?>",
        dataType:   "json",
        data:       data,
        success:    function(data, status){
            var oText, o = $(obj);
            if(data.r == 0){
                oText = $("textarea[name='content']");
                oText.val(oText.val().replace('[图片' + seq_id + ']', ''));
                o.closest(".thumblst").remove();
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
</div>

    <div class="cright">
        <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?>">返回<?php echo $strGroup['groupname'];?></a></p>
    </div>


</div>
</div>

<?php include template('footer'); ?>