<?php include template('header'); ?>
<div class="midder">
    <div class="mc">
        <h1>
        <?php echo $title;?>
        </h1>    
<form method="POST" action="<?php echo SITE_URL;?><?php echo ikurl('article','do',array('ik'=>'update'))?>"  onsubmit="return checkForm(this);"  enctype="multipart/form-data" id="form_tipic">
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
    <tr><th>&nbsp;</th><td align="left" style="padding:0px 10px"><a href="javascript:;" id="addImage">添加图片</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a class="video-btn" href="javascript:addVideo();">添加视频</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a id="addlink" href="javascript:addLink();">添加链接</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a id="addBlod" href="javascript:addBlod();">加粗文字</a></td></tr>
    <tr>
        <th>内容：</th>
        <td>
        <textarea tabindex="3"  style="width:99.5%;height:300px;" maxlength="10000" id="editor_mini" cols="55" rows="20" name="content" class="txt"   placeholder="请填写内容"></textarea>
        <div class="ik_toolbar" id="ik_toolbar"><span class="textnum" id="textnum"><em>0</em> / <em>10000</em> 受欢迎的字数 </span></div>
        </td>
    </tr> 
    <tr>
    	<th>&nbsp;</th><td>
        <input type="hidden" name="itemid" value="<?php echo $itemid;?>" id="itemid"  />
        <input class="submit" type="submit" value="好啦，发表" tabindex="4" > <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?>">返回</a>
        </td>
    </tr>
</table>

</form>

    
    </div>
</div>

<!--加载编辑器-->
<script language="javascript">
var type  = "article",typeid  = "<?php echo $itemid;?>";
</script>
<script src="<?php echo SITE_URL;?>public/js/editor/xheditor/xheditor.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/editor/xheditor/loadeditor.js" type="text/javascript"></script>

<?php include template('footer'); ?>