<?php include template('header'); ?>
<div class="midder">
  <div class="mc">
    <h1><?php echo $strTopic['title'];?></h1>
    <div class="cleft"> 
      
      <?php if($page == '1') { ?>
      
      <div class="topic-content clearfix">
        <div class="user-face"> <a href="<?php echo U('hi','',array('id'=>$strTopic['user'][doname]))?>"><img title="<?php echo $strTopic['user'][username];?>" alt="<?php echo $strTopic['user'][username];?>" src="<?php echo $strTopic['user'][face];?>" width="48"></a> <br />
          <?php doAction('topic_face_footer',$strTopic)?> </div>
        <div class="topic-doc">
          <h3> <span class="color-green"><?php echo date('Y-m-d H:i:s',$strTopic['addtime'])?></span> <span class="pl20">来自：<a href="<?php echo U('hi','',array('id'=>$strTopic['user'][doname]))?>"><?php echo $strTopic['user'][username];?></a></span> </h3>
          <div class="topic-view"><?php echo nl2br($strTopic['content'])?></div>
          
          <!--签名--> 
          <?php if($strTopic['user'][signed] != '') { ?>
          <div class="signed"><?php echo $strTopic['user'][signed];?></div>
          <?php } ?> 
          
          <?php if($IK_USER['user'][userid] == $strTopic['userid'] || $IK_USER['user'][userid]==$strGroup['userid'] ||$strGroupUser['isadmin']=="1" || $IK_USER['user'][isadmin]=="1") { ?>
          <div style="text-align:right;"> 
            <?php if($IK_USER['user'][userid]==$strGroup['userid'] ||$strGroupUser['isadmin']=="1" || $IK_USER['user'][isadmin]=="1") { ?> 
            &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=group&a=do&ik=topic_istop&topicid=<?php echo $strTopic['topicid'];?>"><?php if($strTopic['istop']=='0') { ?>置顶<?php } else { ?>取消置顶<?php } ?></a> &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=group&a=do&ik=isposts&topicid=<?php echo $strTopic['topicid'];?>"><?php if($strTopic['isposts']==0) { ?>精华<?php } else { ?>取消精华<?php } ?></a> &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=group&a=do&ik=topic_isshow&topicid=<?php echo $strTopic['topicid'];?>"><?php if($strTopic['isshow']=='0') { ?>隐藏<?php } else { ?>显示<?php } ?></a> &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=group&a=topic_move&groupid=<?php echo $strGroup['groupid'];?>&topicid=<?php echo $strTopic['topicid'];?>">移动</a> 
            
            <?php } ?> 
            &gt;&nbsp; <a href="<?php echo SITE_URL;?>index.php?app=group&a=topic_edit&topicid=<?php echo $strTopic['topicid'];?>">编辑</a> &gt;&nbsp; <a  href="<?php echo SITE_URL;?>index.php?app=group&a=do&ik=deltopic&topicid=<?php echo $strTopic['topicid'];?>" onclick="return confirm('确定删除?')">删除</a> </div>
          <?php } ?> 
        </div>
      </div>
      <?php if($IK_USER['user']) { ?>
      	<div class="sns-bar">
        	<div class="sns-bar-rec">
                <span class="rec">
                    <a class="bn-sharing  i a_share_btn" data-pic="<?php echo $strTopic['content_photo'][0];?>" data-title="<?php echo $strTopic['title'];?>" data-desc="<?php echo getsubstrutf8(t($strTopic['content']),0,150)?>" data-url="<?php echo U('group','topic',array('id'=>$strTopic['topicid']))?>" href="#">分享到</a> &nbsp;&nbsp;
                </span>            
            	<div class="rec-sec"><a href="<?php echo U('group','do',array('ik'=>'topic_recommend'))?>" title="推荐" class="lnk-sharing i a_recommend_btn"  data-title="<?php echo getsubstrutf8(t($strTopic['title']),0,40)?>"  data-desc="<?php echo getsubstrutf8(t($strTopic['content']),0,100)?>"  data-tkind="<?php echo $strTopic['groupid'];?>" data-tid="<?php echo $strTopic['topicid'];?>" data-tuid="<?php echo $IK_USER['user']['userid'];?>" data-url="<?php echo U('group','topic',array('id'=>$strTopic['topicid']))?>">推荐</a> <span class="rec-num" id="rec-num"><?php echo $recommendNum;?>人</span></div>
            </div>
            <div class="sns-bar-fav">
            	<span  class="fav-num"><a href="#" id="like-num"><?php echo $collectNum;?>人</a> 喜欢 </span>
            	<?php if($is_Like) { ?>
                <a href="<?php echo U('group','do',array('ik'=>'topic_collect'))?>" title="取消喜欢" data-tkind="<?php echo $strTopic['groupid'];?>" data-tid="<?php echo $strTopic['topicid'];?>" data-tuid="<?php echo $IK_USER['user']['userid'];?>" class="btn-fav fav-cancel i a_like_btn">喜欢</a> 
				<?php } else { ?>
                <a href="<?php echo U('group','do',array('ik'=>'topic_collect'))?>" title="标为喜欢" data-tkind="<?php echo $strTopic['groupid'];?>" data-tid="<?php echo $strTopic['topicid'];?>" data-tuid="<?php echo $IK_USER['user']['userid'];?>" class="btn-fav fav-add i a_like_btn">喜欢</a> 
            	<?php } ?>
            </div>        
        </div>
      <?php } ?>
      <div class="clear"></div>
      <?php doAction('topic_footer',$strTopic)?> 
      
      <!--tag标签-->
      <div class="tags"> 
        <?php foreach((array)$strTopic['tags'] as $key=>$item) {?> 
        <a rel="tag" title="" class="post-tag" href="<?php echo U('group','topic_tag',array(tagname=>$item['tagname']))?>"><?php echo $item['tagname'];?></a> 
        <?php }?> 
        <?php if($isGroupUser) { ?> 
        <a rel="tag" href="javascript:void(0);" onclick="showTagFrom()">+标签</a>
        <p id="tagFrom" style="display:none">
          <input class="tagtxt" type="text" name="tags" id="tags" />
          <button type="submit" class="subab" onclick="savaTag(<?php echo $topicid;?>)">添加</button>
          <a href="javascript:void(0);" onclick="showTagFrom()">取消</a> </p>
        <?php } ?> 
        
      </div>
      
      <?php } ?>
      
      <div class="clear"></div>
      <div> <?php if($upTopic) { ?>上一篇：<a href="<?php echo U('group','topic',array('id'=>$upTopic['topicid']))?>"><?php echo $upTopic['title'];?></a><?php } ?>
        
        <?php if($downTopic) { ?>下一篇：<a href="<?php echo U('group','topic',array('id'=>$downTopic['topicid']))?>"><?php echo $downTopic['title'];?></a><?php } ?> </div>
      
      <?php if($page == '1') { ?>
      <div class="orderbar"> 
        <?php if($sc=='asc') { ?> 
        <a href="<?php echo U('group','topic',array('id'=>$topicid,'sc'=>'desc'))?>">倒序阅读</a> 
        <?php } else { ?> 
        <a href="<?php echo U('group','topic',array('id'=>$topicid))?>">正序阅读</a> 
        <?php } ?> 
      </div>
      <?php } ?> 
      
      <!--comment评论-->
      <ul class="comment" id="comment">
        <?php if(is_array($arrTopicComment)) { ?> 
        <?php foreach((array)$arrTopicComment as $key=>$item) {?>
        <li class="clearfix">
          <div class="user-face"> <a href="<?php echo U('hi','',array('id'=>$item['user'][doname]))?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a> </div>
          <div class="reply-doc">
            <h4><span class="fr"><?php echo $key+1;?>F</span><a href="<?php echo U('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a> <?php echo date('Y-m-d H:i:s',$item['addtime'])?></h4>
            
            <?php if($item['referid'] !='0') { ?>
            <div class="recomment"><a href="<?php echo U('hi','',array('id'=>$item['recomment'][user][doname]))?>"><img src="<?php echo $item['recomment'][user][face];?>" width="24" align="absmiddle"></a> <strong><a href="<?php echo U('hi','',array('id'=>$item['recomment'][user][doname]))?>"><?php echo $item['recomment'][user][username];?></a></strong>：<?php echo nl2br($item['recomment'][content])?></div>
            <?php } ?>
            
            <p> <?php echo nl2br($item['content'])?> </p>
            
            <!--签名--> 
            <?php if($item['user'][signed] != '') { ?>
            <div class="signed"><?php echo $item['user'][signed];?></div>
            <?php } ?>
            
            <div class="group_banned"> 
              <?php if($isGroupUser != '0') { ?> 
              <span><a href="javascript:void(0)"  onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>)">回复</a></span> 
              <?php } ?> 
              
              <?php if($strTopic['userid'] == $IK_USER['user'][userid] || $IK_USER['user'][userid] == $strGroup['userid'] || $IK_USER['user'][userid] == $item['userid'] || $strGroupUser['isadmin']==1 || $IK_USER['user'][isadmin]==1) { ?> 
              <span><a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=group&a=comment&ik=delete&commentid=<?php echo $item['commentid'];?>" rel="nofollow" onclick="return confirm('确定删除?')">删除</a> </span> 
              <?php } ?> 
            </div>
            <div id="rcomment_<?php echo $item['commentid'];?>" style="display:none; clear:both; padding:0px 10px">
              <textarea style="width:550px;height:50px;font-size:12px; margin:0px auto;" id="recontent_<?php echo $item['commentid'];?>" type="text" onkeydown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>,event)" class="txt"></textarea>
              <p style=" padding:5px 0px">
                <button onclick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>)" id="recomm_btn_<?php echo $item['commentid'];?>" class="subab">提交</button>
                &nbsp;&nbsp;<a href="javascript:;" onclick="$('#rcomment_<?php echo $item['commentid'];?>').slideToggle('fast');">取消</a> </p>
            </div>
          </div>
          <div class="clear"></div>
        </li>
        <?php }?> 
        <?php } ?>
      </ul>
      <div class="page"><?php echo $pageUrl;?></div>
      <h2>你的回应&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
      <div> 
        <?php if(intval($IK_USER['user'][userid])==0) { ?>
        <div style="border:solid 1px #DDDDDD; text-align:center;padding:20px 0"><a href="<?php echo U('user','login')?>">登录</a> | <a href="<?php echo U('user','register')?>">注册</a></div>
        <?php } elseif ($isGroupUser == 0) { ?> 
        不是本组成员不能回应此贴哦 
        <?php } elseif ($strTopic['iscomment'] == 1 && $strTopic['userid'] != $IK_USER['user'][userid]) { ?> 
        本帖除作者外不允许任何人评论 
        <?php } else { ?>
        
        <form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&a=comment&ik=do" onSubmit="return checkComment('#formMini');" id="formMini" enctype="multipart/form-data">
          <textarea  style="width:100%;height:100px;" id="editor_mini" name="content" class="txt" onkeydown="keyComment('#formMini',event)"></textarea>
          <input type="hidden" name="topicid" value="<?php echo $strTopic['topicid'];?>" />
          <input class="submit" type="submit" value="加上去(Crtl+Enter)" style="margin:10px 0px">
        </form>
        
        <?php } ?> 
        
      </div>
    </div>
    <div class="cright">
       <?php if($isGroupUser > 0 ) { ?>
        <div class="side-reg" id="g-side-info-member">
          <div class="bd">
              <div class="group-item">
                  <div class="pic">
                       <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>" title="<?php echo $strGroup['groupname'];?>"><img src="<?php echo $strGroup['icon_48'];?>" alt="<?php echo $strGroup['groupname'];?>"></a>
                  </div>
                  <div class="info">
                      <div class="title">
                          <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>" title="<?php echo $strGroup['groupname'];?>"><?php echo getsubstrutf8(t($strGroup['groupname']),0,14)?></a>
                      </div>
                  <div class="member-info1">我是小组的成员</div>
              </div>
            </div>
          </div>
        </div>    
     <?php } else { ?>
      <div class="side-reg" id="g-side-info">
        <div class="bd">
          <div class="group-item">
            <div class="pic"> <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>"> <img src="<?php echo $strGroup['icon_48'];?>"> </a> </div>
            <div class="info">
              <div class="title"> <a href="<?php echo U('group','show',array('id'=>$strGroup['groupid']))?>"><?php echo getsubstrutf8(t($strGroup['groupname']),0,14)?></a> </div>
              	<div class="member-info"> <i><?php echo $strGroupUserNum;?></i> 人聚集在这个小组 </div>
              	<p><?php echo getsubstrutf8(t($strGroup['groupdesc']),0,46)?></p>
            </div>
          </div>
        </div>
        <div class="ft">
          <div class="member-status"><a class="bn-join" href="<?php echo U('group','do',array('ik'=>'join','groupid'=>$strGroup['groupid']))?>">加入小组</a></div>
        </div>
      </div>
      <?php } ?>
      
      <h2>谁收藏了这篇帖子</h2>
      <script>topic_collect_user('<?php echo $strTopic['topicid'];?>')</script>
      <div id="collects">
        <div style="padding:10px;text-align:center;"><img src="<?php echo SITE_URL;?>public/images/loading.gif" />正在加载中......</div>
      </div>
      <h2 class="usf">最新话题</h2>
      <div class="indent newtopic">
        <ul>
          <?php foreach((array)$newTopic as $key=>$item) {?>
          <li><a title="<?php echo $item['title'];?>" href="<?php echo U('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a> &nbsp; <span class="pl">(<a href="<?php echo U('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a>) </span> </li>
          <?php }?>
        </ul>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>


<?php include template('footer'); ?>