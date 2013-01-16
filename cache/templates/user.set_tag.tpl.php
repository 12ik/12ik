<?php include template('header'); ?>

<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>

<div>
<div class="tags">
<?php foreach((array)$arrTag as $key=>$item) {?>
<a rel="tag" title="" class="post-tag" href=""><?php echo $item['tagname'];?></a>
<?php }?>



<a rel="tag" href="javascript:void(0);" onclick="showTagFrom()">+添加个人标签</a>
<p id="tagFrom" style="display:none">
<input class="tagtxt" type="text" name="tags" id="tags" /> <button type="submit" class="subab" onclick="savaTag(<?php echo $userid;?>)">添加</button> <a href="javascript:void(0);" onclick="showTagFrom()">取消</a>
</p>

</div>
</div>



</div>
</div>

<?php include template('footer'); ?>