<?php include template('header'); ?>

<style>
.ttable{width:100%}
.ttable th{font-size:18px;height:100px;width:100px;border:solid 1px #DDDDDD; text-align:center;margin:5px 0;font-weight: bold;}
.ttable td{font-size:14px;border:solid 1px #DDDDDD;padding:0 5px;}

.ttable td .pr{text-align:right}
</style>

<div class="midder">
<div class="mc">
<h1>社区任务</h1>
<div class="cleft">

<table class="ttable">
<tr><th>真实的我</th></td><td><p>通过验证Email真实性完成身份认证，发放头像真实性标识，加送500积分</p><p class="pr">
<?php if($strUser['isverify']==0) { ?>
<a class="submit" href="<?php echo SITE_URL;?><?php echo ikurl('user','verify',array(ik=>post))?>">开始认证</a>
<?php } else { ?>
已完成
<?php } ?>
</p></td></tr>
<tr><th>有头有脸</th></td><td><p>偶是谁，偶们都是响当当的人物，偶们就要有头有脸</p><p class="pr">
<?php if($strUser['face']=='') { ?>
<a class="submit" href="<?php echo SITE_URL;?><?php echo ikurl('user','set',array(ik=>face))?>">上传头像</a>
<?php } else { ?>
已完成
<?php } ?>
</p></td></tr>
<tr><th>每日一帖</th></td><td><p>每日一帖，包你满意，一帖不发，情何以堪？</p><p class="pr">
<?php if($strTopic['ct'] == 0) { ?>
未完成
<?php } else { ?>
已完成
<?php } ?>
</p></td></tr>
<tr><th>礼尚往来</th></td><td><p>回帖也是一种礼数的开始，你一回，我一回，如此回荡不绝。</p><p class="pr">

<?php if($strReply['cr'] == 0) { ?>
未完成
<?php } else { ?>
已完成
<?php } ?>
</p></td></tr>
</table>

</div>


</div>
</div>

<?php include template('footer'); ?>