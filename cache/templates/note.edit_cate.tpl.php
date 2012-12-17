<?php include template('header'); ?>
<!--main-->
<div class="midder">

<div class="mc">
<?php include template('edit_xbar'); ?>

<div class="cleft">

<table align="center" style="width:100%;clear: both;" class="table_1">
 <?php foreach((array)$arrCate as $key=>$item) {?>
	<tr id="info_<?php echo $item['cateid'];?>">
    	<td width="27%"><span id="catename_<?php echo $item['cateid'];?>"><?php echo $item['catename'];?></span><input type="text" value="<?php echo $item['catename'];?>" name="catename" class="txt" style="display:none"/></td>
    	<td width="73%">
        <span>
        <a href="javascript:;" onClick="cateOptions.edit(this,'<?php echo $item['cateid'];?>')" >编辑</a>
        </span>
        <span style="display:none">
        <button onClick="cateOptions.update(this,'<?php echo $item['cateid'];?>')" class="subab">保存</button>
        <a href="javascript:;" onClick="cateOptions.cancel_edit(this,'<?php echo $item['cateid'];?>')" >取消</a>
        </span>
        </td>
    </tr>
 <?php }?>
</table>


</div>

    <div class="cright">
    
    <p class="pl2"><a href="<?php echo SITE_URL;?><?php echo tsurl('note','list',array('userid'=>$userid))?>">&gt; 返回到我的日志</a></p>
    
    </div>

</div>

</div>
<!--加载编辑器-->
<?php include template('footer'); ?>