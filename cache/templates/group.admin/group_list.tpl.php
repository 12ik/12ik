<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="page"><?php echo $pageUrl;?></div>

<table  cellpadding="0" cellspacing="0">
<tr class="old"><td width="20">ID</td><td width="100">小组名字</td><td width="200">小组介绍</td><td>帖子统计</td><td>成员统计</td><td>创建时间</td><td>操作</td></tr>
<?php foreach((array)$arrAllGroup as $key=>$item) {?>
<tr class="odd"><td><?php echo $item['groupid'];?></td><td><a href="<?php echo SITE_URL;?><?php echo tsurl('group','show',array('id'=>$item['groupid']))?>" target="_blank">[<?php echo $item['groupname'];?>]</a></td><td><?php echo getsubstrutf8(t($item['groupdesc']),0,20)?></td><td><?php echo $item['count_topic'];?></td><td><?php echo $item['count_user'];?></td><td><?php echo date('Y-m-d H:i:s',$item['addtime'])?></td><td><?php if($item['isaudit'] == 1) { ?><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ts=isaudit&groupid=<?php echo $item['groupid'];?>">[未审核]</a><?php } ?><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ts=isrecommend&groupid=<?php echo $item['groupid'];?>"><?php if($item['isrecommend']=='0') { ?><font color="red">[推荐]</font><?php } else { ?>[取消推荐]<?php } ?></a> <a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=upuser&groupid=<?php echo $item['groupid'];?>">[投送]</a> <a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ts=edit&groupid=<?php echo $item['groupid'];?>">[修改]</a> <a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ts=del&groupid=<?php echo $item['groupid'];?>">[删除]</a></td></tr>
<?php }?>
</table>

</div>
<?php include template("admin/footer");?>