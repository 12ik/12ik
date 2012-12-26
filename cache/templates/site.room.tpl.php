 <!--头部-->
<?php include template('site_header'); ?>
<!--//头部-->
<!--导航-->
<?php include template('site_nav'); ?>
<!--//导航-->
 
<!--内容-->
<div id="content">
    <!--main-->
    
    <div class="main">
    <noscript>
        <div class="message">
            您的浏览器不支持javascript，不能使用此页面的全部功能。
            请换用其他浏览器或者开启对javascript的支持。
        </div>
    </noscript>
 
    <?php foreach((array)$strLeftMod as $item) {?>
    	<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?>
		<div  class="mod sort"  id="<?php echo $item['table'];?>-<?php echo $item['itemid'];?>">
        <?php } else { ?>
		<div  class="mod" id="<?php echo $item['table'];?>-<?php echo $item['itemid'];?>">
		<?php } ?>
			<div class="hd">
			<h2>
				<span><?php echo $item['title'];?></span>
				<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?>
                	<?php if($item['list']) { ?>
                <span class="pl"> ( <?php echo $item['list'];?>&nbsp;&middot;&nbsp;<?php echo $item['action'];?> ) </span>
                	<?php } else { ?>
                <span class="pl"> ( <?php echo $item['action'];?> ) </span>   
                    <?php } ?>
                <?php } elseif ($item['list'] ) { ?>
                <span class="pl"> ( <?php echo $item['list'];?> ) </span>
                <?php } ?>                
			</h2>
				<div class="edit">
					<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?> <?php echo $item['settingurl'];?> <?php } ?>
				</div>
			</div>
			<div class="bd">
                	<?php if($item['table']=='bulletin') { ?>
                    <div class="bulletin-content" ><?php echo nl2br($item['content'])?></div>
                    <?php } ?>
                    
                	<?php if($item['table']=='notes') { ?>
                    		<?php if($item['content']=='') { ?>
                            <div class="createnew">
                                记录你的最新动向 <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'create','notesid'=>$item['itemid']))?>"> &gt; 提笔写日记</a>
                            </div>
                            <?php } else { ?>  
                                 
                             <!--  <?php foreach((array)$item['content'] as $item) {?>  -->
                                <div class="item-entry">
                                
                                    <div class="title">
                                        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
                                    </div>
                                    <div class="datetime"><?php echo date('Y-m-d H:i:s',$item['addtime'])?></div>
                                    <div id="note_<?php echo $item['contentid'];?>_short" class="summary">
                                    	<?php echo $item['content'];?>
                                    	<a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>#note_<?php echo $item['contentid'];?>_footer">(<?php echo $item['count_comment'];?>回应)</a>
                                    </div>
                                    
                                </div>                               		
                                <!--  <?php } ?> -->
                                
                            <?php } ?>
                    <?php } ?>
                    
                	<?php if($item['table']=='forum') { ?>
                            <table class="list-b">
                            <tr><td>话题</td><td>作者</td><td nowrap="nowrap">回应</td><td align="right">更新时间</td></tr>
                            <!--  <?php foreach((array)$item['content'] as $item) {?>  -->
                            <tr>
                                <td><?php if($item['istop']==1) { ?><img src="/public/images/stick.gif"/><?php } ?> <a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('site','forum',array('forumid'=>$item['forumid'],'discussid'=>$item['discussid']))?>"><?php echo $item['title'];?></a></td>
                                    <?php $struser = aac('user')->getOneUser($item['userid']);?>
                                <td>来自 <a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$struser['doname']))?>">																 									<?php echo $struser['username'];?></a>
                                </td>
                                <td class="count" nowrap="nowrap"><?php echo $item['count_comment'];?></td>
                                <td class="date"><?php echo date('Y-m-d H:i:s',$item['addtime'])?></td>
                            </tr>                           
                            <!--  <?php } ?> -->
                            </table>                             		
                    <?php } ?> 

                	<?php if($item['table']=='photos') { ?>
                        <div class="widget-photo-list"> 
                        <ul class="list-s"> 
                        <!--  <?php foreach((array)$item['content'] as $item) {?>  -->
                            <li>
                            <a href="<?php echo SITE_URL;?><?php echo ikurl('site','photos',array('ik'=>'photo','photosid'=>$item['photosid'],'pid'=>$item['photoid']))?>" title="" alt=""><img src="<?php echo SITE_URL;?><?php echo ikXimg($item['photourl'],'site',100,100,$item['path'],1)?>"/></a>
                            </li>
						<!--  <?php } ?> -->                            
                        </ul> 
                        </div>                                                        		
                    <?php } ?>                                        
                                        
			</div>
		</div>
		<script type="text/javascript">IK('common', 'setting-eventhandler'); </script>
    <?php } ?>   
    
        
        <?php if($countAchives > 0) { ?>
        <div id="div_archives" class="mod">
            <a href="<?php echo SITE_URL;?><?php echo ikurl('site','archives',array('roomid'=>$roomid))?>">&gt; 更多应用</a>
        </div>
        <?php } ?>
        
        <div class="mod" id="sp-rec-room">
            <div class="bd">
                <div class="rec-sec">
                    <span class="rec"></span>
                </div>
            </div>
        </div>

    </div>
    
    <!--//main-->
    
    <!--aside-->      
    <div class="aside">
    
        <div id="sp-user" class="mod" >
            <div class="bd">
                <div class="user-pic">
                    <img src="<?php echo $strSite['icon_180'];?>" alt="<?php echo $strSite['sitename'];?>">
                </div>
                <div class="site-follow">
					<?php if($ismyfollow ) { ?>
            		<span>我喜欢这个小站。</span><span><a id="unlike" href="<?php echo SITE_URL;?><?php echo ikurl('site','siteac')?>" class="lnk-unfollow a_lnk_unlike" title="确实不再关注 <?php echo $strSite['sitename'];?> 吗?">&gt;取消</a></span>
            		<input id="followed" value="1" type="hidden">
                    <?php } else { ?>  
                        <?php if($IK_USER['user'][userid] > 0) { ?>  
                        <a class="lnk-follow a_lnk_like" href="<?php echo SITE_URL;?><?php echo ikurl('site','siteac')?>" id="like">喜欢</a>
                        <?php } else { ?>
                        <a class="lnk-follow a_show_login" href="<?php echo SITE_URL;?><?php echo ikurl('site','siteac')?>" id="like">喜欢</a>
                        <?php } ?>
                    <input id="followed" type="hidden" value="0" />
                    <?php } ?>
                </div>
                <div class="desc">
                    <?php echo $strSite['sitedesc'];?>
                </div>           
                <div class="share" id="share-site">
                    <p>
                    <strong class="title">分享小站</strong>
                    <span class="shuo" title="豆瓣广播"><a href="#" class="a_lnk_share" rel="http://www.douban.com/recommend/?|douban|<?php echo $strSite['sitename'];?>|推荐<?php echo $strSite['sitename'];?>的爱客小站|<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$siteid))?>">&nbsp;</a></span>
                    <span class="sina" title="新浪微博"><a href="#" class="a_lnk_share" rel="http://v.t.sina.com.cn/share/share.php?appkey=|sina|<?php echo $strSite['sitename'];?>|推荐<?php echo $strSite['sitename'];?>的爱客小站|<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$siteid))?>">&nbsp;</a></span>
                    <span class="tqq" title="腾讯微博"><a href="#" class="a_lnk_share" rel="http://v.t.qq.com/share/share.php?source=|qzone|<?php echo $strSite['sitename'];?>|推荐<?php echo $strSite['sitename'];?>的爱客小站|<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$siteid))?>">&nbsp;</a></span>
                    </p>
                    <script>IK('sharetool')</script>
                </div>                           
                <div class="site-info">
                    网站信息
                </div>
            </div>
        </div>
    
        <div class="mod" id="db-followers">
          <div class="hd">
            <h2>
                <span>喜欢该小站的成员</span>
                <span class="pl">
                        ( <a href="<?php echo SITE_URL;?><?php echo ikurl('site','likers',array('id'=>$strSite['siteid']))?>"><?php echo $likesiteNum;?></a> )
                </span>
            </h2>
          </div>
          
          <div class="bd">
                <ul class="list-s">
                    <?php foreach((array)$arrlikeUser as $item) {?>
                    <li>
                    <div class="pic">
                        <a class="nbg" href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['doname']))?>" title="<?php echo $item['username'];?>">
                        <img  alt="<?php echo $item['username'];?>" class="imgg" src="<?php echo $item['face_32'];?>">
                        </a> 
                    </div>
                    </li>
                 	<?php } ?>
                </ul>
          </div>
          
        </div>
        
 
     <?php foreach((array)$strRightMod as $item) {?>
		<div class="mod sort" id="<?php echo $item['table'];?>-<?php echo $item['itemid'];?>">
			<div class="hd">
			<h2>
				<span><?php echo $item['title'];?></span>
				<span class="pl"> ( <a href="updateurl">修改</a> ) </span>
			</h2>
				<div class="edit">
				<a href="#" rel="settingurl" class="a_lnk_mod_setting">设置</a>
				</div>
			</div>
			<div class="bd">
                	<?php if($item['table']=='bulletin') { ?>
                    <div class="bulletin-content" ><?php echo nl2br($item['content'])?></div>
                    <?php } ?>
                	<?php if($item['table']=='notes') { ?>
                    		<?php if($item['content']=='') { ?>
                            <div class="createnew">
                                记录你的最新动向 <a href="http://site.douban.com/widget/notes/8528623/create"> &gt; 提笔写日记</a>
                            </div>
                            <?php } else { ?>       
                               <?php echo $item['content'];?>
                            <?php } ?>
                    <?php } ?>                    
			</div>
		</div>
    <?php } ?>   

 
    
    </div>
    <!--//aside-->  
 

    <div class="extra">
            <a href="#" class="gact">&gt; 举报不良信息</a>
    </div>
 
</div>
<!--//内容-->
<?php if($strSite['userid'] == $IK_USER['user'][userid]) { ?>
<script type="text/javascript">
    var mine_page_url="<?php echo SITE_URL;?><?php echo ikurl('site','layout',array('ik'=>'update','roomid'=>$roomid))?>";
	var globalsiteid = "<?php echo $siteid;?>", globalroomid = "<?php echo $roomid;?>";
    var aside = false;
   IK('<?php echo SITE_URL;?>public/js/lib/jquery-ui-sortable-dd.js',
	  '<?php echo SITE_URL;?>app/site/js/mod_dragdrop.js',
      '<?php echo SITE_URL;?>app/site/js/nav_dragdrop.js');
</script>
<?php } ?>
<script type="text/javascript">
var pop_like_form = "<?php echo SITE_URL;?><?php echo ikurl('site','siteac',array('ik'=>'pop_like_form','siteid'=>$siteid))?>";
var pop_unlike_form = "<?php echo SITE_URL;?><?php echo ikurl('site','siteac',array('ik'=>'pop_unlike_form','siteid'=>$siteid))?>";
IK('room-action');
</script>

<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->
