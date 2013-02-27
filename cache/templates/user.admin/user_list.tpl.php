<?php include template("admin/header");?>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="manu"><?php echo $pageUrl;?></div>

<table  cellpadding="0" cellspacing="0">
<tr class="old"><td width="60">UID</td><td width="200">Email</td><td width="100">姓名</td><td>注册时间</td><td>操作</td></tr>
<?php foreach((array)$arrAllUser as $key=>$item) {?>
<tr class="odd"><td><?php echo $item['userid'];?></td><td><?php echo $item['email'];?></td><td><?php echo $item['username'];?></td><td><?php echo date('Y-m-d H:i:s',$item['addtime'])?></td><td><a href="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=user&ik=view&userid=<?php echo $item['userid'];?>">[明细]</a> <a href="<?php echo SITE_URL;?>index.php?app=user&a=admin&mg=user&ik=isenable&&userid=<?php echo $item['userid'];?>&isenable=<?php if($item['isenable']=='0') { ?>1<?php } else { ?>0<?php } ?>"><?php if($item['isenable']=='0') { ?>[停用]<?php } else { ?><font color="red">[启用]</font><?php } ?></a>

</td></tr>
<?php }?>
</table>

</div>
<?php include template("admin/footer");?>