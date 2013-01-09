<?php include template("ajax/header");?>
<script>function insertEdit(x){callback(x);}</script>
<h2><?php echo $strAlbum['albumname'];?></h2>
<div class="photolist">
<ul>
<?php foreach((array)$arrPhoto as $key=>$item) {?>
<li>
<div class="simg"><img src="<?php echo SITE_URL;?><?php echo ikXimg($item['photourl'],'photo',100,100,$item['path'])?>" /></div>
<a href="javascript:void('0');" onclick="insertEdit('[photo=<?php echo $item['photoid'];?>]');">[插入]</a>
</li>
<?php }?>
</ul>
</div>
</body>
</html>