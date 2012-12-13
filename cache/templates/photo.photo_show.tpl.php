<?php include template('header'); ?>

<div class="midder">

<div class="mc">
<h1><?php echo $title;?></h1>

<div class="cleft">

<div style="padding:3px;border-bottom:1px solid #ddd;margin:5px 0 10px 0;text-align:center;overflow: hidden;" class="pl">
    <span class="rr">&gt; <a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>photo,albumid=>$strAlbum['albumid']))?>">返回相册</a></span>
    <span class="ll">第<?php echo $nowPage;?>张 / 共<?php echo $conutPage;?>张</span>
 
<?php if($nowPage >1) { ?>
<link href="#" rel="prev">
<a id="pre_photo" title="用方向键←可以向前翻页" href="<?php echo SITE_URL;?><?php echo tsurl('photo','show',array(photoid=>$prev))?>">上一张</a>
<?php if($nowPage < $conutPage) { ?>
/
<?php } ?>
<?php } ?>
<?php if($nowPage < $conutPage) { ?>
<link href="#" rel="next">
<a id="next_photo" title="用方向键→可以向后翻页" name="next_photo" href="<?php echo SITE_URL;?><?php echo tsurl('photo','show',array(photoid=>$next))?>">下一张</a>
<?php } ?>
</div>

<div style="text-align:center">
    <?php if($nowPage < $conutPage) { ?>
	<a title="点击查看下一张" href="<?php echo SITE_URL;?><?php echo tsurl('photo','show',array(photoid=>$next))?>" class="mainphoto">
<?php } ?>
        <img src="<?php echo SITE_URL;?><?php echo tsXimg($strPhoto['photourl'],'photo',600,600,$strPhoto['path'])?>">
	<?php if($nowPage < $conutPage) { ?>
   </a>
   <?php } ?>
</div>

<div class="photo_descri">
    <div class="j a_editable edtext pl">
        <span id="display"><?php echo $strPhoto['photodesc'];?></span>
       <?php if($IK_USER['user'][userid] == $strPhoto['userid'] || $IK_USER['user'][isadmin]==1) { ?><span id="edi"><a href="">修改</a></span><?php } ?>
    </div>
</div>

<div style="color:#999;margin-bottom:5px">
    <?php echo $strPhoto['count_view'];?>人浏览　上传于<?php echo date('Y-m-d',$strPhoto['addtime'])?>　<a class="thickbox" target="_blank" href="<?php echo SITE_URL;?>uploadfile/photo/<?php echo $strPhoto['photourl'];?>">查看原图</a>

　<?php if($IK_USER['user'][userid] == $strPhoto['userid'] || $IK_USER['user'][isadmin]==1) { ?><span class="gact">&gt;&nbsp;<a class="j a_confirm_link" title="删除这张照片" rel="nofollow" href="<?php echo SITE_URL;?>index.php?app=photo&ac=do&ts=photo_del&photoid=<?php echo $strPhoto['photoid'];?>">删除照片</a>&nbsp;&nbsp;</span><?php } ?>
</div>

<div class="clear"></div>
<br>

<div id="comments">

<table class="wr" id="c-80243627">
<tbody>

<?php foreach((array)$arrComment as $key=>$item) {?>
<tr><td width="75" valign="top"><a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><img src="<?php echo $item['user'][face];?>" class="pil"></a>
</td>
<td valign="top">
<span class="wrap">
<h4><?php echo date('Y-m-d H:i:s',$item['addtime'])?>: <a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a></h4>
</span><?php echo $item['content'];?><br>
<div class="align-right">

<?php if(intval($IK_USER['user'][isadmin]) == 1 || $strPhoto['userid']==$IK_USER['user'][userid]) { ?>
<span class="gact">&gt; <a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=photo&ac=do&ts=delcomment&commentid=<?php echo $item['commentid'];?>">删除</a></span>
<?php } ?>

</div>
</td></tr>
<?php }?>
</tbody></table>

<br><br>
<h2>你的回应</h2>

<div class="txd">

<?php if(intval($IK_USER['user'][userid]) > 0) { ?>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=photo&ac=do&ts=comment_do">
<textarea style="width:500px;" name="content"></textarea><br>
<input type="hidden" value="<?php echo $strPhoto['photoid'];?>" name="photoid">
<input class="submit" type="submit" value="加上去">
</form>
<?php } else { ?>
请登录后再评论哦^_^
<?php } ?>

</div>
<br>
</div>

</div>

<div class="cright">
<div class="mod">
<?php if(intval($IK_USER['user'][userid]) > 0) { ?>    
    <h2>我的相册&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
<?php } else { ?>
    <h2><?php echo $strUser['username'];?>的相册&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
<?php } ?>
    <span class="pl">&nbsp;(<a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>user,userid=>$strAlbum['userid']))?>">全部</a>) </span>
    </h2>

    <div class="bd">
        <ul class="album-list">
                <?php foreach((array)$arrAlbum as $key=>$item) {?>
                <li>
                <div class="pic">
                    <a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>photo,albumid=>$item['albumid']))?>" title="<?php echo $item['albumname'];?>">
                        <img width="75" height="75" alt="<?php echo $item['albumname'];?>" src="<?php if($item['albumface'] == '') { ?><?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/photo_album.png<?php } else { ?><?php echo SITE_URL;?><?php echo tsXimg($item['albumface'],'photo',75,75,$item['path'],1)?><?php } ?>">
                    </a>
                </div>
                <div class="info">
                    <a href="<?php echo SITE_URL;?><?php echo tsurl('photo','album',array(ts=>photo,albumid=>$item['albumid']))?>" title="<?php echo $item['albumname'];?>"><?php echo $item['albumname'];?></a>
                    <span class="num"><?php echo $item['count_photo'];?>张照片</span>
                    <p><?php echo getsubstrutf8(t($item['albumdesc']),0,28);?></p>
                </div>
                </li>
                <?php }?>
        </ul>
    </div>
</div>

<div class="clear"></div>
<?php doAction('photo_show_right_footer',$strTopic)?>

</div>

</div>
</div>

<?php include template('footer'); ?>