<?php include template('header'); ?>
<div class="midder">
<div class="mc">
<div class="cleft">
    <div class="art-body">
    	<h1 class="title"><?php echo $strArticleinfo['subject'];?></h1>
        <div style="text-align:center;color:#999999;padding-bottom: 10px;border-bottom: 1px solid #DDDDDD; margin-bottom:10px">
        发表于 <?php echo date('Y-m-d H:i:s',$strArticleinfo['dateline'])?> <a href="#comments"><?php echo $strArticleinfo['replynum'];?>条回复</a> 浏览<?php echo $strArticleinfo['viewnum'];?>次 <a href="#formMini">我要回复</a> 
        </div>
    
        <div class="art-text">
             <?php echo $strArticle['message'];?>
        </div>
    
  
    
    <div class="clear"></div>

  </div>
	
    

<!--comment评论-->
<ul class="comment">
<?php if(is_array($arrComment)) { ?>
<?php foreach((array)$arrComment as $key=>$item) {?>
<li class="clearfix">
<div class="user-face">
<a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a>
</div>
<div class="reply-doc">
<h4><?php echo date('Y-m-d H:i:s',$item['addtime'])?>
	<a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a>
</h4>

<?php if($item['referid'] !='0') { ?>
<div class="recomment"><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['recomment'][user][doname]))?>"><img src="<?php echo $item['recomment'][user][face];?>" width="24" align="absmiddle"></a> <strong><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['recomment'][user][doname]))?>"><?php echo $item['recomment'][user][username];?></a></strong>：<?php echo nl2br($item['recomment'][content])?></div>
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
<a href="javascript:void(0)"  onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['nid'];?>)">回复</a>
</span>

<span>
<a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=article&ac=comment&ik=delete&commentid=<?php echo $item['commentid'];?>" rel="nofollow" onclick="return confirm('确定删除?')">删除</a>
</span>
<?php } ?>
</div>


<div id="rcomment_<?php echo $item['commentid'];?>" style="display:none; clear:both; padding:0px 10px">
<textarea style="width:550px;height:50px;font-size:12px; margin:0px auto;" id="recontent_<?php echo $item['commentid'];?>" type="text" onkeydown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['nid'];?>,event)" class="txt"></textarea>


<p style=" padding:5px 0px"><button onclick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['nid'];?>,<?php echo $item['itemid'];?>)" id="recomm_btn_<?php echo $item['commentid'];?>" class="subab">提交</button>&nbsp;&nbsp;<a href="javascript:;" onclick="$('#rcomment_<?php echo $item['commentid'];?>').slideToggle('fast');">取消</a>
</p>

</div>
</div>
<div class="clear"></div>
</li>
<?php }?>
<?php } ?>
</ul>

    
<h2>你的回应&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
<div id="comments">
<?php if(intval($IK_USER['user'][userid])==0) { ?>
<div style="border:solid 1px #DDDDDD; text-align:center;padding:20px 0"><a href="<?php echo SITE_URL;?><?php echo ikurl('user','login')?>">登录</a> | <a href="<?php echo SITE_URL;?><?php echo ikurl('user','register')?>">注册</a></div>
<?php } else { ?>

<form method="POST" action="<?php echo SITE_URL;?><?php echo ikurl('article','comment',array('ik'=>'add'))?>" onSubmit="return checkComment('#formMini');" id="formMini">
	<textarea  style="width:100%;height:100px;" id="editor_mini" name="content" class="txt" onkeydown="keyComment('#formMini',event)"></textarea>
	<input type="hidden" name="nid" value="<?php echo $strArticle['nid'];?>" />
    <input type="hidden" name="itemid" value="<?php echo $strArticle['itemid'];?>" />
	<input class="submit" type="submit" value="加上去(Crtl+Enter)" style="margin:10px 0px">
</form>

<?php } ?>

</div>    

</div>


<div class="cright">
	<p class="pl2"><a href="<?php echo SITE_URL;?><?php echo ikurl('article')?>">&gt; 返回</a></p>
    
</div>

</div>
</div>

<?php include template('footer'); ?>