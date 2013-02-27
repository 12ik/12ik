<?php include template('header'); ?>
<script src="public/js/jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	/*$.getJSON("http://www.12ik.com/index.php?app=group&a=notice&callback=?", 
	function(data){
		$.each(data, function(i,item){
			$("#admindex_msg table").append("<tr><td width='100'>"+item.time+"</td><td><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></td></tr>");
		});
	}); 
	*/  
});
</script>

<style>
.fbox{float:left;width:45%;margin-right:10px;}
</style>

<div class="midder">
<?php if($message) { ?><p class="message"><?php echo $message;?></p><?php } ?>
<div class="fbox">
<h2>目录权限</h2>
<table>
<tr><td width="100">cache目录</td><td><?php if(iswriteable('cache')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>data目录</td><td><?php if(iswriteable('data')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>plugins目录</td><td><?php if(iswriteable('plugins')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>uploadfile目录</td><td><?php if(iswriteable('uploadfile')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
</table>
</div>

<div class="fbox">
<h2>软件信息</h2>
<table>
<tr><td width="100">系统支持：</td><td><?php echo $IK_SOFT['info'][name];?></td></tr>
<tr><td>程序版本：</td><td><?php echo $IK_SOFT['info'][version];?></td></tr>
<tr><td>联系方式：</td><td><?php echo $IK_SOFT['info'][email];?></td></tr>
<tr><td>官方网址：</td><td><a href="<?php echo $IK_SOFT['info'][url];?>" target='_blank'><?php echo $IK_SOFT['info'][url];?></a></td></tr>
</table>
</div>

<div class="fbox"> 
<h2>服务器信息</h2>
<table>
    <tr><td width="100">服务器软件：</td><td><?php echo $IK_SOFT['system'][server];?></td></tr>
    <tr><td>操作系统：</td><td><?php echo $IK_SOFT['system'][phpos];?></td></tr>
    <tr><td>PHP版本：</td><td><?php echo $IK_SOFT['system'][phpversion];?></td></tr>
    <tr><td>MySQL版本：</td><td><?php echo $IK_SOFT['system'][mysql];?></td></tr>
    <tr><td>物理路径：</td><td><?php echo $_SERVER['DOCUMENT_ROOT'];?></td></tr>
	 <tr><td>附件上传限制：</td><td><?php echo $IK_SOFT['system'][upload];?></td></tr>
    <tr><td>图像处理：</td><td><?php echo $IK_SOFT['system'][gd];?> </td></tr>
    <tr><td>语言：</td><td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];?></td></tr>
    <tr><td>gzip压缩：</td><td><?php echo $_SERVER['HTTP_ACCEPT_ENCODING'];?></td></tr>
</table>
</div>

<div class="fbox" id="admindex_msg">
<h2>爱客(12IK)官方消息</h2>
<table>

</table>
</div>

</div>
<?php include template('footer'); ?>