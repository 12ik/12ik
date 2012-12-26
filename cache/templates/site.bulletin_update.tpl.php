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
.editor-toolbar { text-align:right; }
#text { width:98.5%;height:300px; }
form .item-submit { padding-left:0; }
form .item { margin-top:10px; }
form label { width:6em; }
.frm-addlink input { width:70%; }
</style>    
    <div class="main"> 
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','bulletin',array('siteid'=>$siteid,'bulletinid'=>$bulletinid))?>">&gt; 返回<?php echo $strBulletin['title'];?></a>
        </div>
        
        <h1>编辑公告栏</h1>
        
        <div class="mod">
            <form name="bulletin_form" method="post" action="">
            <div style="display:none;"><input name="ck" value="" type="hidden"></div>
            
            <div class="editor-toolbar">
            	<a id="addlink" href="javascript:void(0)">添加链接</a>
            </div>
            <div class="item">
				<textarea id="text" name="content"><?php echo $strBulletin['content'];?></textarea>
                <input type="hidden" name="historyurl" value="<?php echo $jump;?>"/>
            </div>
            <div class="item-submit">
                <span class="bn-flat-hot"><input name="submit" value="提交" type="submit"></span>
                &nbsp;&nbsp;
                <a onClick="javascript:history.go(-1)" href="javascript:;" >取消</a>
            </div>
            </form>
        </div>
<script>
IK('dialog','common', function(){
    var templ_link = '<form class="frm-addlink"><div class="item">' +
                        '<label>链接文字: </label><input name="linktext" type="text" value="SEL">' +
                        '</div>' +
                        '<div class="item">' +
                        '<label>网址: </label><input name="href" type="text" value="">' +
                        '</div><input type="submit" style="display:none;"></form>',
        addlink = function(frm, o){
            var text = $.trim(frm[0].elements['linktext'].value),
            url = $.trim(frm[0].elements['href'].value);
            if(url !== ''){
              url = /^http:\/\//.test(url)? url:"http://"+url;
              $('#text').insert_caret('[url=' + url + ']' + (text===''? url : text) + "[/url]");
              o.close();
            }
        };

    $('#addlink').click(function(e){
        e.preventDefault();
        var s = $('#text').get_sel(),
        dlg = dui.Dialog({
        content: templ_link.replace('SEL', s),
        width: 400,
        title: '添加链接',
        buttons: [{
          text: '添加',
          method: function(o){
            addlink( o.node.find('form'), o);
          }
        },'cancel']
        }).open();
        dlg.node.find('form').submit($.proxy(function(e){
            e.preventDefault();
            addlink($(e.target), this);
        }, dlg));
    });
});
</script>

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
