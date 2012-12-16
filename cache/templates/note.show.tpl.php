<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<div class="cleft">
    <div class="art-body">
    	<h1 class="title"><?php echo $strNote['title'];?></h1>
        <div style="text-align:center;color:#999999;padding-bottom: 10px;border-bottom: 1px solid #DDDDDD; margin-bottom:10px"><a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$strNote['user'][doname]))?>"><?php echo $strNote['user'][username];?></a> 发表于 <?php echo date('Y-m-d H:i:s',$strNote['addtime'])?> <a href="#comments"><?php echo $strNote['count_comment'];?>条回复</a> 浏览<?php echo $strNote['count_view'];?>次 <a href="#formMini">我要回复</a> 
        </div>
    
        <div class="art-text">
            <?php echo $strNote['content'];?>
        </div>
    
    <div class="options-bar">    
    <?php if(intval($IK_USER['user'][userid])==$strNote['userid']) { ?>
    &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=note&ac=do&ts=edit&noteid=<?php echo $strNote['noteid'];?>">修改</a> 
    &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=note&ac=do&ts=del&noteid=<?php echo $strNote['noteid'];?>">删除</a>
    <?php } ?>
    </div>
    
    <div class="clear"></div>

  </div>

<!--tag标签-->
<div class="tags">
    <?php foreach((array)$strNote['tags'] as $key=>$item) {?>
    <a rel="tag" title="" class="post-tag" href="<?php echo SITE_URL;?><?php echo tsurl('note','note_tag',array(tagname=>$item['tagname']))?>"><?php echo $item['tagname'];?></a>
    <?php }?>
    <?php if(intval($IK_USER['user'][userid])==$strNote['userid']) { ?>
    <a rel="tag" href="javascript:void(0);" onclick="showTagFrom()">+标签</a>
    <p id="tagFrom" style="display:none">
    <input class="tagtxt" type="text" name="tags" id="tags" /> <button type="submit" class="subab" onclick="savaTag(<?php echo $noteid;?>)">添加</button> <a href="javascript:void(0);" onclick="showTagFrom()">取消</a>
    </p>
    <?php } ?>
</div>
    
<!--comment评论-->
<ul class="comment">
<?php if(is_array($arrComment)) { ?>
<?php foreach((array)$arrComment as $key=>$item) {?>
<li class="clearfix">
<div class="user-face">
<a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a>
</div>
<div class="reply-doc">
<h4><?php echo date('Y-m-d H:i:s',$item['addtime'])?>
	<a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a>
</h4>

<?php if($item['referid'] !='0') { ?>
<div class="recomment"><a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['recomment'][user][doname]))?>"><img src="<?php echo $item['recomment'][user][face];?>" width="24" align="absmiddle"></a> <strong><a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['recomment'][user][doname]))?>"><?php echo $item['recomment'][user][username];?></a></strong>：<?php echo nl2br($item['recomment'][content])?></div>
<?php } ?>

<p>
<?php echo nl2br($item['content'])?>
</p>

<!--签名-->
<?php if($item['user'][signed] != '') { ?>
<div class="signed"><?php echo $item['user'][signed];?></div>
<?php } ?>


<div class="group_banned">
<?php if($IK_USER['user'][userid] == $item['userid'] || $IK_USER['user'][isadmin]==1) { ?>
<span>
<a href="javascript:void(0)"  onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['noteid'];?>)">回复</a>
</span>

<span>
<a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=note&ac=comment&ts=delete&commentid=<?php echo $item['commentid'];?>" rel="nofollow" onclick="return confirm('确定删除?')">删除</a>
</span>
<?php } ?>
</div>


<div id="rcomment_<?php echo $item['commentid'];?>" style="display:none; clear:both; padding:0px 10px">
<textarea style="width:550px;height:50px;font-size:12px; margin:0px auto;" id="recontent_<?php echo $item['commentid'];?>" type="text" onkeydown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['noteid'];?>,event)" class="txt"></textarea>


<p style=" padding:5px 0px"><button onclick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['noteid'];?>)" id="recomm_btn_<?php echo $item['commentid'];?>" class="subab">提交</button>&nbsp;&nbsp;<a href="javascript:;" onclick="$('#rcomment_<?php echo $item['commentid'];?>').slideToggle('fast');">取消</a>
</p>

</div>
</div>
<div class="clear"></div>
</li>
<?php }?>
<?php } ?>
</ul>

<div class="page"><?php echo $pageUrl;?></div>

<h2>你的回应&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
<div id="comments">
<?php if(intval($IK_USER['user'][userid])==0) { ?>
<div style="border:solid 1px #DDDDDD; text-align:center;padding:20px 0"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','login')?>">登录</a> | <a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">注册</a></div>
<?php } else { ?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=note&ac=comment&ts=add" onSubmit="return checkComment('#formMini');" id="formMini">
	<textarea  style="width:100%;height:100px;" id="editor_mini" name="content" class="txt" onkeydown="keyComment('#formMini',event)"></textarea>
	<input type="hidden" name="noteid" value="<?php echo $strNote['noteid'];?>" />
	<input class="submit" type="submit" value="加上去(Crtl+Enter)" style="margin:10px 0px">
</form>

<?php } ?>

</div>

</div>

<div class="cright">
<?php if($strNote['user'][userid] == $IK_USER['user'][userid] ) { ?>
<p class="pl2"><a href="<?php echo SITE_URL;?><?php echo tsurl('note','list',array('userid'=>$strNote['user'][userid]))?>">&gt; 返回到我的日志</a></p>
<?php } else { ?>
<p class="pl2"><a href="<?php echo SITE_URL;?><?php echo tsurl('note','list',array('userid'=>$strNote['user'][userid]))?>">&gt; 返回到<?php echo $strNote['user'][username];?>的日志</a></p>
<?php } ?>


</div>

</div>
</div>

<?php include template('footer'); ?>