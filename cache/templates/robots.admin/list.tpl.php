<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>



<table>
<tr class="old">
    <td width="60">采集名</td>
    <td width="120">采集时间</td>
    <td>采集次数</td>
    <td>选择操作</td>
</tr>
<?php foreach((array)$thevalue as $key=>$item) {?>
<tr>
    <td><?php echo $item['name'];?></td>
    <td><?php echo $item['lasttime'];?></td>
    <td><?php echo $item['robotnum'];?></td>
    <td><a href="#">开始采集</a> <a href="<?php echo SITE_URL;?>index.php?app=robots&ac=admin&mg=edit&robotid=<?php echo $item['robotid'];?>">编辑配置</a> <a href="#">删除机器</a></td>
</tr>
<?php }?>
</table>

</div>

<?php include template("admin/footer");?>