<?php include template('header'); ?>
<script>
$(document).ready(function() {

//选择一级区域
$('#oneid').change(function(){
	$("#stwoid").html('<img src="'+siteUrl+'public/images/loading.gif" />');
	var oneid = $(this).children('option:selected').val();  //弹出select的值
	
	if(oneid==0){
		$("#stwoid").html('');
		$("#sthreeid").html('');
	}else{
		$("#sthreeid").html('');
		$.ajax({
			type: "GET",
			url:  "<?php echo SITE_URL;?>index.php?app=user&ac=area&ik=two&oneid="+oneid,
			success: function(msg){
				$("#stwoid").html(msg);
				
				//选择二级区域
				$('#twoid').change(function(){
					$("#sthreeid").html('<img src="'+siteUrl+'public/images/loading.gif" />');
					var twoid = $(this).children('option:selected').val();  //弹出select的值
					
					if(twoid == 0){
						$("#sthreeid").html('');
					}else{
					
						//ajax
						$.ajax({
							type: "GET",
							url:  "<?php echo SITE_URL;?>index.php?app=user&ac=area&ik=three&twoid="+twoid,
							success: function(msg){
								$('#sthreeid').html(msg);
							}
						});
					
					}

				});
				
			}
		});
	
	}
	
});

});
</script>

<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>

<div class="utable">
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ik=setcity">
<table cellpadding="0" cellspacing="0" width="100%" class="table_1">
<tr>
<th>常居地：</th>
<td>
<?php if($strArea) { ?>
<?php echo $strArea['one'][areaname];?> 
<?php echo $strArea['two'][areaname];?> 
<?php echo $strArea['three'][areaname];?> 
<?php } else { ?>
火星
<?php } ?>
</td>
</tr>

<tr>
<th>修改常居地：</th>
<td>
<select id="oneid" name="oneid" class="txt">
<option value="0">请选择</option>
<?php foreach((array)$arrOne as $key=>$item) {?>
<option value="<?php echo $item['areaid'];?>"><?php echo $item['areaname'];?></option>
<?php }?>
</select>
<span id="stwoid"></span>
<span id="sthreeid"></span>
</td>
</tr>
<tr>
	<th></th>
    <td><input class="submit" type="submit" value="修改"  /></td>
</tr>
</table>
</form>


</div>
</div>
</div>
<?php include template('footer'); ?>