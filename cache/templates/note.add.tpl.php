<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<h1>写日志</h1>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=note&ac=add&ik=do">
<table cellspacing="0" cellpadding="0" class="table_1">
<tr><th>分类：</th><td>

<select name="cateid" class="txt" id="cate_select" style="float:left;">
<?php if($arrCate=='') { ?>
<option selected="select" value="0">默认分类</option>
<?php } else { ?>
<?php foreach((array)$arrCate as $key=>$item) {?>
<option  <?php if($item['cateid'] == $cateid ) { ?> selected="select"  <?php } ?>  value="<?php echo $item['cateid'];?>" ><?php echo $item['catename'];?></option>
<?php }?>
<?php } ?>
</select> <span id="cate_input" style="display:none; float:left; margin-left:5px; margin-top:2px">
<input type="text" class="txt" style="width:100px;float:left; display:inline-block" name="catename"/>
<input class="subab" type="button" value="新增" onClick="cateOptions.addPost();"  style="float:left; display:inline-block; margin-left:5px; margin-top:2px" /> 
<a href="javascript:;" onClick="cateOptions.cancel();" style="float:left; display:inline-block; margin-left:5px; margin-top:2px" >取消</a>
</span>
<span id="new_cate" style="float:left; margin-left:5px; margin-top:2px">
<a href="javascript:;" onClick="cateOptions.createCateName()">+新建分类</a>
</span>

</td></tr>
<tr><th>题目：</th><td><input style="width:400px;" name="title" class="txt"/></td></tr>
<tr><th>内容：</th><td><textarea style="width:600px;height:300px;" id="editor_mini" name="content"></textarea></td></tr>
<tr><th>标签：</th><td><input style="width:400px;" name="tag"  class="txt"/> <span class="tip">(多个标签请用空格分开)</span></td></tr>

<tr><th></th><td><input class="submit" type="submit" value="发布日志" /></td></tr>
</table>
</form>


</div>
</div>
<!--加载编辑器-->
<script src="<?php echo SITE_URL;?>public/js/editor/xheditor/xheditor.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/editor/xheditor/loadeditor.js" type="text/javascript"></script>
<?php include template('footer'); ?>