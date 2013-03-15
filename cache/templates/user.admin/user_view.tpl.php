<?php include template("admin/header");?>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<table  cellpadding="0" cellspacing="0">
<tr><td>用户名：</td><td><?php echo $strUser['username'];?></td></tr>
<tr><td>Email：</td><td><?php echo $strUser['email'];?></td></tr>
<?php if($strUser['signed']) { ?><tr><td>签名：</td><td><?php echo $strUser['signed'];?></td></tr><?php } ?>
<?php if($strUser['blog']) { ?><tr><td>博客：</td><td><?php echo $strUser['blog'];?></td></tr><?php } ?>
<?php if($strUser['about']) { ?><tr><td>关于：</td><td><?php echo $strUser['about'];?></td></tr><?php } ?>
<tr><td>注册日期:</td><td><?php echo date('Y-m-d H:i:s',$strUser['addtime'])?></td></tr>
<tr><td>上次访问:</td><td><?php echo date('Y-m-d H:i:s',$strUser['uptime'])?></td></tr>
<tr><td>上次访问 IP: </td><td><?php echo $strUser['ip'];?></td></tr>
<tr><td>积分: </td><td><?php echo $strUser['count_score'];?></td></tr>
<table>

</div>

<?php include template("admin/footer");?>