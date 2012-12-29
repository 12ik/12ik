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
#note_text, #note_title { width:572px; }
form label { float:none; width:initial; }
.note { word-wrap:break-word; width:100%; overflow:hidden; margin-top:10px; }
input { font-size:12px; vertical-align:middle; }
.rr { float:right; padding:0 0 16px 16px; }
.ll { float:left; padding:0 16px 16px 0; }
.cc { clear:both; display:block; text-align:center; }

#preview .note-hd h3 { margin:0 0 10px 0; line-height:1.2; font-size:22px; color:#333; }
#preview .note-bd .note { font-size:14px; }
@import url(<?php echo SITE_URL;?>app/<?php echo $app;?>/css/site/create_note.css);
</style>  
<script>
// plugins, modules
IK.add('template', {path: '<?php echo SITE_URL;?>public/js/lib/jquery.tmpl.js', type: 'js'});
IK.add('dialog-css', {path: '<?php echo SITE_URL;?>public/css/ui/dialog.css', type: 'css'});
IK.add('dialog', {path: '<?php echo SITE_URL;?>public/js/ui/dialog.js', type: 'js', requires: ['dialog-css']});
IK.add('modernizr.dnd', { path: '<?php echo SITE_URL;?>public/js/lib/modernizr.dnd.js', type: 'js'})
IK.add('iframe-post-form-css', {path: '<?php echo SITE_URL;?>public/css/lib/iframe-post-form.css', type: 'css'});
IK.add('iframe-post-form', {path: '<?php echo SITE_URL;?>public/js/lib/iframe-post-form.min.js', type: 'js', requires: ['iframe-post-form-css']});
IK.add('uploadify', {path: '<?php echo SITE_URL;?>public/js/lib/jquery.uploadify.min.js', type:'js', requires: ['<?php echo SITE_URL;?>public/js/uploadify/swfobject.js']});
</script>  
    <div class="main"> 
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'list','notesid'=>$notesid))?>">&gt; <?php echo $strNotes['title'];?></a>
        </div>
        
        <h1><?php echo $title;?></h1>
        
<div class="mod">
    <div class="bd">
    <form id="form_note" method="post">
    <div style="display:none;">
    <input name="ck" value="" type="hidden">
    <input name="userid" id ="userid" value="<?php echo $IK_USER['user'][userid];?>" type="hidden">
    <input type="hidden" id="note_id" name="note_id" value="<?php echo $noteid;?>" />
    </div>
    <div class="row note-title">
        <label for="note_title" class="field">题目:</label>
        <div><input type="text" autofocus="" name="note_title" id="note_title" tabindex="1"></div>
    </div>
    <div class="row note-text">
        <ul class="control-panel">
            <li class="image-btn">
                <a title="插入图片" href="#image" class="lnk-flat">图片</a>
            </li>
            <li class="video-btn">
                <a title="插入视频" href="#video" class="lnk-flat">视频</a>
            </li>            
            <li class="link-btn">
                <a title="插入链接" href="#link" class="lnk-flat">链接</a>
            </li>
        </ul>
        <label for="note_text" class="field">正文:</label>
        <textarea name="note_content" id="note_text" tabindex="2"></textarea>
    </div>
    <div class="images"></div>            
    <div class="row note-reply">
        <label for="isreply" class="field">权限设置: </label>
        <label>
            <input type="checkbox" name="isreply" id="isreply" tabindex="6" value="1"><span>不允许回应</span>
        </label>
    </div>  
    <div class="row footer">
        <div class="error-msg board"></div>
        <span class="bn-flat cancel-note">
            <input type="submit" name="cancel_note" class="bn-flat" value="取消" id="cancel_note" tabindex="9">
        </span>
        <span class="bn-flat">
            <input type="button" class="bn-flat" value="预览" id="preview_note" tabindex="7">
        </span>
        &nbsp;
        <input type="submit" name="note_submit" class="btn" value="发表" id="publish_note" tabindex="8">
    </div>                                  

    </form>
    <div id="preview"></div>
    <!--script-->
<script type="text/javascript">
	var postParams = {
		siteCookie: {
			name: 'upload_auth_token',
			value: '38672004:17fb1650e2c07ed759051d454054b2a43ec58b07'
		}
	};
	var UPLOAD_PHOTO_URL = "<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'add_photo','notesid'=>$notesid))?>";
	var AUTOSAVE_URL = '/j/note/autosave';
	var PREVIEW_URL = '/j/note/preview';
</script>

<script id="image_item_tmpl" type="text/template">
	<div class="image-item" data-seq="{{#= seq}}">
		<a class="delete-image" href="#" title="删除该图片">X</a>
		<div class="thumbnail">
			<label class="image-name">[图片{{#= seq}}]</label>
			<div class="image-thumb">
				<img src="{{#= thumb}}" alt="图片{{#= seq}}" />
			</div>
		</div>
		<div class="image-desc">
			<label class="field" for="p{{#= seq}}_title">图片描述(30字以内)</label>
			<input type="hidden" name="p{{#= seq}}_seqid" value="{{#= seq}}"/>
			<textarea id="p{{#= seq}}_title" name="p{{#= seq}}_title" maxlength="30"></textarea>
		</div>
		<div class="image-layout">
			<label class="field">图片位置:</label>
			<label>
				<input name="p{{#= seq}}_align" type="radio" value="left"/><span class="alignleft">左</span>
			</label>
			<label>
				<input name="p{{#= seq}}_align" type="radio" value="center" checked/><span class="aligncenter">中</span>
			</label>
			<label>
				<input name="p{{#= seq}}_align" type="radio" value="right"/><span class="alignright">右</span>
			</label>
		</div>
	</div>
</script>
<script id="image_dlg_tmpl" type="text/template">
	<div id="image_upload">
		<form id="upload-area" action="{{#= UPLOAD_URL}}" method="post" enctype="multipart/form-data"><div style="display:none;"><input type="hidden" name="ck" value="CMiz"/></div>
		<input type="hidden" name="note_id" value="{{#= nid}}" />
		{{#if dnd}}
			<div class="drag-drop">
				<span class="text">
					将图片文件拖到这里<br/>
					或<br/>
					{{#if flash}}
					<input id="image_file" name="image_file" type="file" multiple/>
					{{#else}}
					<div id="noflash">
						安装Flash Player，使用批量上传
						<br/>
						(官方下载 <a target="_blank" href="http://fpdownload.macromedia.com/get/flashplayer/current/licensing/win/install_flash_player_11.exe" rel="nofollow">IE用户</a> /
						<a target="_blank" href="http://fpdownload.macromedia.com/get/flashplayer/current/install_flash_player.exe" rel="nofollow">非IE用户</a> /
						<a target="_blank" href="http://get.adobe.com/cn/flashplayer/" rel="nofollow">非Windows用户</a>)
					</div>
					{{#/if}}
				</span>
			</div>
		{{#else flash}}
			<input id="image_file" name="image_file" type="file" multiple/>
		{{#else (!flash && !basic)}}
			<div id="noflash">
				安装Flash Player，使用批量上传
				<br/>
				(官方下载 <a target="_blank" href="http://fpdownload.macromedia.com/get/flashplayer/current/licensing/win/install_flash_player_11.exe" rel="nofollow">IE用户</a> /
				<a target="_blank" href="http://fpdownload.macromedia.com/get/flashplayer/current/install_flash_player.exe" rel="nofollow">非IE用户</a> /
				<a target="_blank" href="http://get.adobe.com/cn/flashplayer/" rel="nofollow">非Windows用户</a>)
			</div>
		{{#else (!flash && basic)}}
			<input name="userid" id ="userid" value="<?php echo $IK_USER['user'][userid];?>" type="hidden">
			<input type="hidden" name="ct" value="text" />
			<label for="image_file" class="field">选择图片: </label><input id="image_file" name="image_file" type="file" />
		{{#/if}}
		</form>
		<div class="upload-tip">
			图片不超过2M，一次最多20张
			<br/>
		{{#if (!basic)}}
			<span class="upload-alternative">不能正确上传？请尝试使用<a class="upload-basic" href="#">普通上传</a></span>
		{{#else}}
			<span class="upload-alternative">现在可以使用批量上传了。使用<a class="upload-multi" href="#">批量上传</a></span>
		{{#/if}}
		</div>
		<div class="upload-info">
			<div class="header">
				<span class="image-name">图片</span>
				<span class="image-size">大小</span>
				<span class="image-delete">删除?</span>
			</div>
			<div id="image-slots"></div>
			<div class="footer">
				<span class="total-num">共<span class="image-num">{{#= 0}}</span>张<span class="num-warning">超过20张的部分，请另上传</span></span>
				<span class="total-size">总计：<span class="image-total-size">{{#= 0}}KB</span></span>
			</div>
		</div>
	</div>
</script>
<script id="image_slot" type="text/template">
	<div class="slot" data_id="{{#= ID}}">
		<span class="image-name">{{#= name}}</span>
		<span class="image-size">{{#= sizeText}}</span>
		<span class="image-delete">
		<a title="取消该图片" class="image-delete"><img src="<?php echo SITE_URL;?>/public/images/icon-recycle.png"/></a>
		</span>
	</div>
</script>
<script id="image_slot_loading" type="text/template">
	<div class="slot image-loading" data_id="{{#= ID}}">
	{{#if isBasic}}
		<span class="image-name">{{#= name}}</span>
		<span class="basic-loading">上传中...</span>
	{{#else}}
		<span class="image-name">{{#= name}}</span>
		<span class="image-size">{{#= sizeText}}</span>
		<span class="percentage"></span>
		<div class="progress"></div>
	{{#/if}}
	</div>
</script>
<script id="image_slot_error" type="text/template">
	<div class="slot error" data_id="{{#= ID}}">
	{{#if isBasic}}
		<span class="image-name">{{#= name}}</span>
		<span class="image-error">{{#= msg}}
	{{#else}}
		<span class="image-name">{{#= name}}</span>
		<span class="image-error">{{#= msg}}
		{{#if retry}}
			&nbsp;|&nbsp;<a href="#" class="image-retry">重试</a>
		{{#/if}}
		</span>
		<span class="image-size">{{#= sizeText}}</span>
	{{#/if}}
		<span class="image-delete"><a title="取消该图片" class="image-delete"><img src="<?php echo SITE_URL;?>/public/images/icon-recycle.png"/></a></span>
	</div>
</script>
<script id="link_dlg" type="text/template">
<div class="link-dlg">
	<div class="row">
		<label for="link_text" class="field">链接文字</label>
		<input id="link_text" type="text" value="SEL" />
	</div>
	<div class="row">
		<label for="link_url" class="field">网址</label>
		<input type="text" name="link_url" id="link_url" />
	</div>
</div>
</script>

<script id="video_item_tmpl" type="text/template">
	<div class="video-item">
		<input type="hidden" name="video{{#= 1}}" value="{{#= 1}}" />
		<a href="#" class="delete-video" title="删除该视频">X</a>
		<div class="thumbnail">
			<label class="video-name">[视频{{#= 1}}]</label>
			<div class="video-thumb">
				<div class="video_overlay"></div>
				<a href="{{#= 1}}" target="_blank">
					<img src="{{#= 1}}" alt="{{#= 1}}"/>
				</a>
			</div>
		</div>
		<div class="video-info">
			<label>视频信息</label>
			<div>
				<span class="video-title">{{#= 1}}</span>
				<a href="{{#= 1}}" class="video-url" target="_blank">{{#= 1}}</a>
			</div>
		</div>
	</div>
</script>
<script id="video_dlg" type="text/template">
<div class="video-dlg">
	<div class="video-tip">
		目前支持爱客电影预告片，以及土豆、优酷、酷6、QQ播客、新浪播客、搜狐视频、Mofile等多家网站视频。
	</div>
	<div class="row">
		<label class="field" for="video_url">输入视频播放页地址</label>
		<input id="video_url" type="text" />
		<div class="msg"></div>
	</div>
</div>
</script>

<script id="preview_tmpl" type="text/template">
	<div class="note-hd">
		<h3>{{#= title}}</h3>
	</div>
	<div class="note-bd">
		<pre class="note">{{html body}}</pre>
	</div>
	<div class="note-ft">
		<span class="pl">{{#= cannot_reply}}</span>
		&nbsp;
		<span class="pl">{{#= note_privacy}}</span>
	</div>
	<div class="preview-footer">
		<span class="bn-flat">
			<input class="continue-edit" value="继续编辑" type="button" class="bn-flat" />
		</span>
		&nbsp;
		<input class="submit-note btn" value="保存" type="button"/>
	</div>
</script>

<script src="<?php echo SITE_URL;?>app/site/js/create_note.js" type="text/javascript"></script>
    
    <!--script-->
    </div>
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
