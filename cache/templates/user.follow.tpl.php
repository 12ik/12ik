<?php include template('header'); ?>

<div class="midder">

<div class="mc">
	<h1><?php echo $title;?>(<?php echo $strUser['count_follow'];?>)</h1>
	<div class="cleft">

<ul class="user-list">
<?php foreach((array)$arrFollowUser as $key=>$item) {?>
    <li class="clearfix" id="u<?php echo $item['userid'];?>">
        <a title="<?php echo $item['username'];?>" href="<?php echo U('hi','',array('id'=>$item['doname']))?>">
        <img alt="<?php echo $item['username'];?>" src="<?php echo $item['face'];?>" class="face">
        </a>
        <div class="info">
          <h3> <a title="<?php echo $item['username'];?>" href="<?php echo U('hi','',array('id'=>$item['doname']))?>"><?php echo $item['username'];?></a></h3>
          <!-- 签名档 -->
          <p><?php echo $item['area']['areaname'];?></p>
        </div>
        <span class="ban">取消关注</span>
    </li>
<?php }?>          
</ul>
<script language="javascript">
$(function(){
	    $('.user-list li').hover(function () {
            $('.ban', this).show();
        }, function () {
            $('.ban', this).hide();
        });	
})

$('.user-list .ban').click(function () {
	var self = this,
		name = $(this).parent().children().children('h3').children('a').text(),
		msg = '确实不再关注 ' + name + ' 吗?',
		peopleId = $(this).parents('li').attr('id').replace('u', ''),
		hasBlackList = confirm(msg);

	if (hasBlackList) {
		$(this).parents('li').fadeOut(function () {
			var posturl = "<?php echo U('user','do',array('ik'=>'user_nofollow_ajax'))?>";
			$.post_withck(
				posturl,
				{ 'userid_follow': peopleId },
				function () {
					$(self).remove();
				}
			);
		});
	}
});
</script>

    </div>

    <div class="cright">

<?php if($strUser['userid'] == $IK_USER['user'][userid]) { ?>
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo U('user','followed',array('userid'=>$userid))?>">关注我的人(<?php echo $strUser['count_followed'];?>)</a>
        </p> 
<?php } else { ?>
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo U('user','followed',array('userid'=>$userid))?>">关注<?php echo $strUser['username'];?>的人(<?php echo $strUser['count_followed'];?>)</a>
        </p> 
<?php } ?>               
<!---
        <p class="pl2">
            &gt;&nbsp;<a href="/contacts/find">寻找&nbsp;MSN/Gtalk&nbsp;朋友</a>
        </p>
-->        
        <p class="pl2">
            &gt;&nbsp;<a href="<?php echo U('user','contacts',array('ik'=>'invite'))?>">邀请我的朋友加入爱客网</a>
        </p>


    </div>

</div>
</div>
<?php include template('footer'); ?>