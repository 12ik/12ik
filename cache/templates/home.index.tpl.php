<?php include template('header'); ?>
<div class="midder">

<?php if($user=='') { ?>
<div class="anony-nav">
<div class="bd">
<div class="reg">

<strong>爱客社区</strong>
<div>
<b>12ik创新社区新体验，内容互动性强，交流更方便</b><br><em>简单</em><em>快捷</em><em>方便</em><em>建设本地化，垂直型社区；目前已有<cite><?php echo $count_user;?></cite>位用户加入！</em>
</div>
<a class="submit" href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">加入我们</a>
</div>

<div class="login">
<form action="<?php echo SITE_URL;?><?php echo tsurl('user','login',array('ts'=>'do'))?>" method="post" name="lzform" id="lzform">
<fieldset>
<legend>登录</legend>
<div class="item">
<label>Email：</label><input type="email" tabindex="1" value="" name="email" class="txt">
</div>
<div class="item">
<label>密码：</label><input type="password" tabindex="2" class="txt" name="pwd" > <a href="<?php echo SITE_URL;?>index.php?app=user&ac=forgetpwd">忘记密码？</a>
</div>

<div class="item1">
<label for="form_remember"><input type="checkbox" tabindex="3" id="form_remember" name="remember"> 记住我</label>
</div>
<div class="item1">
<input type="hidden" name="cktime" value="2592000" />
<input type="submit" tabindex="4" class="submit" value="登录" style="margin-left:10px">
<?php doAction('pub_header_login')?>
</div>
</fieldset>
</form>
</div>

</div>
</div>
<?php } ?>

<div class="mc">


<div class="cleft">

<h2>推荐小组<span class="pl">&nbsp;(<a href="<?php echo SITE_URL;?><?php echo tsurl('group','all')?>">全部</a>) </span></h2>

<div style="overflow:hidden;">
<?php if($arrRecommendGroup) { ?>
<?php foreach((array)$arrRecommendGroup as $key=>$item) {?>
<div class="sub-item">
<div class="pic">
<a href="<?php echo SITE_URL;?><?php echo tsurl('group','show',array('id'=>$item['groupid']))?>">
<img src="<?php echo $item['icon_48'];?>" alt="<?php echo $item['groupname'];?>">
</a>
</div>
<div class="info">
<a href="<?php echo SITE_URL;?><?php echo tsurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> (<?php echo $item['count_user'];?>/<font color="orange"><?php echo $item['count_topic'];?></font>)             
<p><?php echo $item['groupdesc'];?></p>
</div>
</div>
<?php }?>
<?php } ?>
</div>
<div class="clear"></div>

<h2>最热话题<span class="pl">&nbsp;(<a href="<?php echo SITE_URL;?><?php echo tsurl('group','all')?>">更多</a>) </span></h2>
<div class="topic-list">
    <?php if($arrHotTopic) { ?>
    <?php foreach((array)$arrHotTopic as $key=>$item) {?>
	<dl>
    	<dt><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><img src="<?php echo $item['user'][face];?>"/></a></dt>
        <dd>
        	<header class="title"><span><a href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>#comment" title="回复数"><?php echo $item['count_comment'];?></a></span><a href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>" title="<?php echo $time['title'];?>"><?php echo $item['title'];?></a></header>
             <a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><?php echo $item['user'][username];?></a> <summary><?php echo getTime($item['addtime'],time())?> <?php echo $item['count_view'];?>次阅读</summary>
            <p><?php echo $item['content'];?></p>
        </dd>
    </dl>
    <?php }?>
    <?php } ?>
</div>

</div>

<div class="cright">
<?php doAction('index_right')?>

	<h2>活跃用户</h2>
    <div class="indent">
    
    <?php foreach((array)$arrHotUser as $key=>$item) {?>
    <dl class="obu">
        <dt>
            <a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['doname']))?>">
            <img alt="<?php echo $item['username'];?>" class="m_sub_img" src="<?php echo $item['face'];?>" width="48" />
            </a>
        </dt>
        <dd>
            <a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a>
        </dd>
    </dl>
    <?php }?>
 	<br clear="all"/>
    </div>

<h2>最新创建小组</h2>

<div class="line23">
<?php if($arrNewGroup) { ?>
<?php foreach((array)$arrNewGroup as $key=>$item) {?>
<a href="<?php echo SITE_URL;?><?php echo tsurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> (<?php echo $item['count_user'];?><?php if($item['uptime']>strtotime(date('Y-m-d 00:00:00'))) { ?>/<font color="orange"><?php echo $item['count_topic_today'];?></font><?php } else { ?><?php } ?>)<br>
<?php }?>
<?php } ?>
</div>

<h2>最新发表日志</h2>

<div class="line23">
<?php if($arrNewNote) { ?>
<?php foreach((array)$arrNewNote as $key=>$item) {?>
<a href="<?php echo SITE_URL;?><?php echo tsurl('note','show',array('noteid'=>$item['noteid']))?>"><?php echo $item['title'];?></a><br>
<?php }?>
<?php } ?>
</div>

<h2>最新小站日记</h2>

<div class="line23">
<?php if($arrSiteNote) { ?>
<?php foreach((array)$arrSiteNote as $key=>$item) {?>
    <a href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>" title="<?php echo $item['title'];?>">
    <?php echo $item['title'];?>
    </a><br>
<?php }?>
<?php } ?>
</div>

<div class="clear"></div>
<?php doAction('home_index_right_footer')?>
</div>
<?php doAction('index_footer')?>
</div>
</div>

	
</div>

</div>
<?php include template('footer'); ?>