<?php include template('header'); ?>

<script src="public/js/jquery.js" type="text/javascript"></script>
<script>
//安装卸载APP
function isinstall(appname){
	$('#isinstall_'+appname).html('<img src="public/images/loading.gif">');
	$.ajax({
		type: "GET",
		url:  "index.php?app=system&a=apps&ik=install&appname="+appname,
		success: function(result){
			if(result=='1'){
				window.location.reload(true); 
			}else if(result=='2'){
				window.location.reload(true); 
			}else{
				alert("非法操作！");
			}
		}
	});
}

//升级
function isupdate(appkey,version){
	$.getJSON("http://www.12ik.com/index.php?app="+appkey+"&a=update&old="+version+"&callback=?", function(response){
		if(response != ''){
			$('#'+appkey).html('发现新版本：'+response.newv+'<a target="_blank" href="http://www.12ik.com/"><font color="red">[升级]</font></a>');
		}
		
	});   
}

//设为导航
function isappnav(appkey,appname){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&a=apps&ik=appnav",
		data:"&appkey="+appkey+"&appname="+appname,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
}

//取消导航
function unisappnav(appkey){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&a=apps&ik=unappnav",
		data:"&appkey="+appkey,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
}
//鼠标移动表格效果
$(document).ready(function(){
    $("tr[overstyle='on']").hover(
      function () {
        $(this).addClass("odd");
      },
      function () {
        $(this).removeClass("odd");
      }
    );
});
</script>

<!--main-->
<div class="midder">

<h2><span><a href="http://www.12ik.com/index.php?app=market" target="_blank">下载更多APP组件>></a></span><?php echo $title;?></h2>

<table  cellpadding="0" cellspacing="0">

<tr class="old"><td width="150">APP名称</td><td>版本</td><td>介绍</td><td>作者</td><td>操作</td><td>导航</td><td>安装</td></tr>
<?php foreach((array)$arrApp as $keys=>$item) {?>
<tr overstyle="on">
<td><img src="app/<?php echo $item['name'];?>/icon.png" title="<?php echo $item;?>" align="absmiddle" />
<?php echo $item['about'][name];?>(<?php echo $item['name'];?>)</td>
<td><?php echo $item['about'][version];?><span id="<?php echo $item['name'];?>"></span>
</td>
<td><?php echo $item['about'][desc];?></td>
<td><?php echo $item['about'][author];?></td>
<td>
<?php if($item['about'][isoption] == '1' && $item['about'][isinstall]=='1') { ?><a href="index.php?app=<?php echo $item['name'];?>&a=admin&mg=options">[管理]</a><?php } ?> 
</td>
<td>
<?php if($item['about'][isappnav] == '1' && $IK_SITE['appnav'][$item['name']] == '') { ?><a href="javascript:void('0');" onclick="isappnav('<?php echo $item['name'];?>','<?php echo $item['about'][name];?>');">[导航]</a><?php } ?>

<?php if($item['about'][isappnav] == '1' && $IK_SITE['appnav'][$item['name']] != '') { ?><a href="javascript:void('0');" onclick="unisappnav('<?php echo $item['name'];?>');">[取消导航]</a><?php } ?>
</td>
<td>
<span id="isinstall_<?php echo $item['name'];?>"><a href="javascript:void('0');" onclick="isinstall('<?php echo $item['name'];?>');"><?php if($item['about'][isinstall]=='0') { ?>[安装]<?php } elseif ($item['about'][issystem]=='0') { ?>[卸载]<?php } ?></a></span>
</td>
<tr>
<?php }?>
</table>

</div>

<?php include template('footer'); ?>