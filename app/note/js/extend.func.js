function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500}); }
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}

var cateOptions = {
		createCateName : function()
		{
			$('#cate_input').show();
			$('#new_cate').hide();
		},
		cancel : function(){
			$('#cate_input').hide();
			$('#cate_input :input[name=catename]').val('');
			$('#new_cate').show();
		},
		addPost : function()
		{
			var url = siteUrl+'index.php?app=note&ac=cate_ajax&ts=add';
			var catename = $('#cate_input :input[name=catename]').val();
			$.post(url,{catename: catename},function(rs){ 
					if(rs==0)
					{
						 $.dialog.open(siteUrl+'index.php?app=user&ac=ajax&ts=login', {title: '登录'});
						 
					}else if(rs == 1){
						  error('分类名称不能为空^_^');
					 }else{
						 var options='';
						 for(var i=0; i<rs.length; i++)
						 {
							 if(i == rs.length-1)
							 {
							 	options += '<option value="'+rs[i]['cateid']+'" selected="selected">'+rs[i]['catename']+'</option>';
							 }else
							 { 
								options += '<option value="'+rs[i]['cateid']+'">'+rs[i]['catename']+'</option>';
							 }
						 }
						  $('#cate_select').html(options);
						  cateOptions.cancel();
						  succ('新增加分类成功^_^');
					 }
			})
		},
		//编辑分类
		edit : function(obj,cateid)
		{
			$('#info_'+cateid).find('#catename_'+cateid).hide();
			$('#info_'+cateid).find('input').show();
			$('#info_'+cateid).find('#option_'+cateid).show();
			$(obj).parent('span').hide().siblings('span').show();
		},
		cancel_edit: function(obj,cateid)
		{
			$('#info_'+cateid).find('#catename_'+cateid).show();
			$('#info_'+cateid).find('input').hide();
			$('#info_'+cateid).find('#option_'+cateid).hide();
			$(obj).parent('span').hide().siblings('span').show();
		},
		update: function(obj,cateid)
		{
			var url = siteUrl+'index.php?app=note&ac=cate_ajax&ts=update';
			var catename = $('#info_'+cateid).find('input[name=catename]').val();
			if(catename=='') {tips("分类名称不能为空");return false;}
			if(catename.length>15){ tips("分类名称太长了；不能超过15个字");return false;}
			$.post(url,{catename:catename, cateid:cateid},function(rs){
				if(rs==0)
				{
					$.dialog.open(siteUrl+'index.php?app=user&ac=ajax&ts=login', {title: '登录'});
				}else if(rs==1)
				{
				    tips("分类名不能为空，且长度不能超过15个字");
				
				}else{
					
					$('#info_'+cateid).find('input[name=catename]').val(rs['catename']).hide();
					$('#info_'+cateid).find('#catename_'+cateid).text(rs['catename']).show();
					$(obj).parent('span').hide().siblings('span').show();
				}
			});
		}
		
		
	};

/*显示隐藏回复*/
function commentOpen(id,gid)
{
	$('#rcomment_'+id).slideToggle('fast');
}
//Ctrl+Enter 回应
function keyComment(obj,event)
{
     if(event.ctrlKey == true)
	 {
		if(event.keyCode == 13)
		if(checkComment(obj))
		{
			$(obj).submit();
		}
		return false;
	}
}

//安全性检测 回应帖子
function checkComment(obj)
{

	if($(obj).find('textarea[name=content]').val() == ''){ error('你回应的内容不能为空'); return false;}
	if($(obj).find('textarea[name=content]').val().length > 2000){ error('你已经输入了<font color="red">'+$(obj).find('textarea[name=content]').val().length+'</font>个字；你回应的内容不能超过<font color="red">2000</font>个字。');return false;}
	
	$(obj).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
	
	return true;
}

//Ctrl+Enter 回复评论
function keyRecomment(rid,tid,event)
{
     if(event.ctrlKey == true)
	 {
		if(event.keyCode == 13)
		recomment(rid,tid);
		return false;
	}
}
//回复评论
function recomment(rid,tid){

	c = $('#recontent_'+rid).val();
	if(c==''){tips('回复内容不能为空');return false;}
	var url = siteUrl+'index.php?app=note&ac=comment&ts=recomment';
	$('#recomm_btn_'+rid).hide();
	$.post(url,{referid:rid,noteid:tid,content:c} ,function(rs){
				if(rs == 0)
				{
					succ('回复成功');
					window.location.reload();
				}else if( rs == 1){
					
					tips('回复内容写这么多干啥，删除点吧老大^_^')
					$('#recomm_btn_'+rid).show();
				}
	})	
}
//日志首页 伸缩效果
$(function(){
	$('.note_list dt span').bind('click',function(){
		$(this).toggleClass('close');
		$(this).parent().parent().find('.action').slideToggle('fast');
	});
});
/*显示标签界面*/
function showTagFrom(){	$('#tagFrom').toggle('fast');}
/*提交标签*/
function savaTag(tid)
{
	var tag = $('#tags').val();
		if(tag ==''){ tips('请输入标签哟^_^');$('#tagFrom').show('fast');}else{
			var url = siteUrl+'index.php?app=tag&ac=add_ajax&ts=do';
			$.post(url,{objname:'note',idname:'noteid',tags:tag,objid:tid},function(rs){  window.location.reload()   })
		}
	
}