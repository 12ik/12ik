<?php include template('header'); ?>
<div class="midder">


    <div class="mc">
    
   	    <h1>我的小组</h1>
       
        <div class="cleft">

            
            <?php include template('my_menu'); ?>
            
            
            
            <div class="indent">
                <table class="olt">
                    <tbody>
                        <tr>
                            <td>话题</td>
                            <td>小组</td>
                            <td>作者</td>
                            <td nowrap="nowrap" align="right">&nbsp;&nbsp;&nbsp;&nbsp;回应</td>
                            <td align="right">最后回应</td>
                        </tr>
            <?php if($arrTopic) { ?>
            <?php foreach((array)$arrTopic as $key=>$item) {?>
                            <tr class="pl">
                                <td><a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>
            <?php if($item['istop']=='1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/headtopic_1.gif" title="[置顶]" alt="[置顶]" />
            <?php } ?>
            <?php if($item['addtime']>strtotime(date('Y-m-d 00:00:00'))) { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/topic_new.gif" align="absmiddle"  title="[新帖]" alt="[新帖]" />
            <?php } ?> 
            <?php if($item['isphoto']=='1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/image_s.gif" title="[图片]" alt="[图片]" align="absmiddle" />
            <?php } ?> 
            <?php if($item['isattach'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/attach.gif" title="[附件]" alt="[附件]" />
            <?php } ?>
            <?php if($item['isposts'] == '1') { ?>
            <img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
            <?php } ?></td>
                                <td nowrap="nowrap"><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['group'][groupname];?></a></td>
                                <td nowrap="nowrap"><a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a></td>
                                <td align="right"><?php if($item['count_comment']>0) { ?><?php echo $item['count_comment'];?><?php } ?></td>
                                <td nowrap="nowrap" align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo getTime($item['uptime'],time())?></td>
                            </tr>
             <?php }?>
            <?php } ?>         
                </tbody>
              </table>
            </div>
            
             
            
            <div class="clear"></div>
    
    
    </div>
    
        <div class="cright" id="cright">
   			<?php doAction('my_right_top')?>
    
    		<h2>爱客小组搜索 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
            <div class="indent">
            <div class="infobox">
                <div class="ex1"><span></span></div>
                <div class="bd">
                   <form method="GET" action="<?php echo SITE_URL;?>index.php" id="searchApp">
                        <div class="tc">
                         <input type="hidden" name="app" value="search" />
                         <input type="hidden" name="ac" value="q" />

                         <input type="text" maxlength="36" size="36" class="txt" name="kw" style="width:200px; margin-bottom:5px">
                        </div>
                        <div class="tc">
                            <input  type="button" value="搜索小组"  class="butt" onClick="searchApp('group')">
                             &nbsp; &nbsp;
                             <input type="button" value="搜索发言"  class="butt" onClick="searchApp('topic')">
                        </div>
                    </form>
                    <script>
                    
						function searchApp(value)
						{
							if(value=='group')						
						    { $('#searchApp').append('<input type="hidden" name="ik" value="group" />'); }
							else
							{ $('#searchApp').append('<input type="hidden" name="ik" value="topic" />'); }
							 
							$('#searchApp').submit();
						}
							
                    </script>
                </div>
                <div class="ex2"><span></span></div>
            </div>
        </div>
        
            <div class="clear"></div>
            <h2>我管理的小组 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
            
            <div class="indent obssin">
            
            <?php foreach((array)$arrMyAdminGroup as $key=>$item) {?>
            <dl class="ob">
            <dt><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><img alt="<?php echo $item['groupname'];?>" class="m_sub_img" src="<?php echo $item['icon_48'];?>" width="48" /></a></dt>
            <dd><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> <span>(<?php echo $item['count_user'];?>)</span></dd>
            </dl>
            <?php }?>
            </div>
            
            <div class="clear"></div>
    
    
            <h2>我参加的小组 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
            
            <div class="indent obssin">
            
            
            <?php foreach((array)$arrMyGroup as $key=>$item) {?>
            <dl class="ob">
            <dt><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><img alt="<?php echo $item['groupname'];?>" class="m_sub_img" src="<?php echo $item['icon_48'];?>" width="48" /></a></dt>
            <dd><a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><?php echo $item['groupname'];?></a> <span>(<?php echo $item['count_user'];?>)</span>
            </dd>
            </dl>
            <?php }?>
            </div>
            
            <div class="clear"></div>
                  
    
            <?php if($IK_APP['options'][iscreate]==0 || $IK_USER['user'][isadmin]==1) { ?>
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group','create')?>">创建小组</a></p>
            <?php } ?>
            
            <p class="pl2">&gt; <a href="<?php echo SITE_URL;?><?php echo ikurl('group','all')?>">全部小组</a></p>
    
    </div>
    
    </div><!--//mc-->


</div>

<script>
$(document).ready(function() {
	$.ajax({
		type: "GET",
		url:  "<?php echo SITE_URL;?>index.php?app=group&ac=task&ik=istask",
		success: function(msg){
			$('#cright').prepend(msg);
		}
	});
});
</script>
<?php include template('footer'); ?>