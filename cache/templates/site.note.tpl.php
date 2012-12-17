 <!--头部-->
<?php include template('site_header'); ?>
<!--//头部-->
<!--导航-->
<?php include template('site_nav'); ?>
<!--//导航-->
 
<!--内容-->
<div id="content">
    <!--main-->


<style>
#content h1 { margin:0 0 10px 0;line-height:1.2; }
.note-item { margin-bottom:30px; }
.note-hd h3 { font-size:14px;color:#060; }
.left { float:left;padding:0 16px 16px 0; }
.center { clear:both;display:block;text-align:center;  }
.center table {margin:0 auto;}
.right {float:right;padding:0 0 16px 16px;}
.left table, .center table, .right table { width:1px; }
.note-ft { clear:both;padding-top:4px; }
.note-ft .rec { margin-top:-2px; }
.note-content div { font-size:14px; }
.ui-tooltip { width: 270px }
</style>    
    <div class="main"> 
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('ts'=>'list','notesid'=>$notesid))?>">&gt; <?php echo $strNotes['title'];?></a>
        </div>        
        <div class="mod">


<div class="note-item" id="note-<?php echo $noteid;?>">
  <div class="note-hd">
    <h1><?php echo $strNote['title'];?></h1>
  </div>
  <span class="datetime"><?php echo date('Y-m-d H:i:s',$strNote['addtime'])?></span>
  <div id="note_<?php echo $noteid;?>_short" class="summary"> </div>
  <div class="note-content" id="note_<?php echo $noteid;?>_full">
    <div id="link-report">
	   <?php echo nl2br($strNote['content'])?>    
      <div class="report"><a href="#" rel="nofollow">举报</a></div>
    </div>
  </div>
  <br>
  <div class="note-ft" style="" id="note_<?php echo $strNote['contentid'];?>_footer">
        <span class="count">&nbsp;<?php echo $strNote['count_view'];?>人阅读</span>
        <?php if($strNotes['userid']==$userid) { ?>
        <a href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('ts'=>'edit','notesid'=>$notesid,'noteid'=>$noteid))?>">&gt; 修改</a>
        <a title="真的要删除这篇日记吗？" onClick="return confirm('真的要删除这篇日记吗？')" class="a_confirm_link" href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('ts'=>'delnote','notesid'=>$notesid,'noteid'=>$noteid))?>">&gt; 删除</a>
		<?php } ?>
  </div>
</div>

<!--评论-->       
<div class="post-comments">
  <div id="comments">
    <?php foreach((array)$arrComment as $item) {?>
    <div id="13299013" class="comment-item">
        <div class="pic">
            <a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><img alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a>
        </div>
        <div class="content report-comment">
            <div class="author">
              <a href="<?php echo SITE_URL;?><?php echo tsurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a> 
              <?php echo date('Y-m-d H:i:s',$item['addtime'])?>
            </div>
            <p><?php echo nl2br($item['content'])?></p>
            
            <div class="op-lnks">
                <?php if($userid>0) { ?>
                	<?php if($item['user'][userid]==$userid || $strNotes['userid']==$userid) { ?>
                <a title="删除<?php echo $item['user'][username];?>的留言?" class="" href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('ts'=>'del_comment','notesid'=>$notesid,'noteid'=>$noteid,'commentid'=>$item['commentid']))?>" rel="nofollow" onClick="return confirm('删除<?php echo $item['user'][username];?>的留言?')">删除</a>
                	<?php } ?>
                <?php } ?>
            	<?php if($userid>0) { ?><div class="comment-report"><a href="#" rel="nofollow">举报</a></div><?php } ?>
            </div>
    

        </div>
    </div>
    <?php } ?> 
    <div id="last"></div>
    <?php if($userid == '' ) { ?>
    <div class="comment-lnk">&gt;&nbsp;
    <a href="#add_comment" rel="nofollow" class="a_show_login">我来回应</a>
    </div>
    <?php } ?>
    <?php if($mycommentTime && $userid>0) { ?>    
    <h2>你的回应 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;· </h2>
    <div id="add_comment" class="comment-form txd">
      <form action="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('ts'=>'add_comment','notesid'=>$notesid,'noteid'=>$noteid))?>" method="post" name="comment_form">
        <div style="display:none;">
          <input type="hidden" value="-PMQ" name="ck">
        </div>
        <div class="item">
          <textarea cols="64" rows="4" name="content"></textarea>
          <br>
        </div>
        <div class="item">
        	<span class="bn-flat-hot ">
          <input type="submit" value="加上去">
          </span>
         </div>
      </form>
    </div>
    <?php } elseif ($userid>0) { ?>
    <div class="comment-lnk">&gt;&nbsp;
    <a href="<?php echo SITE_URL;?><?php echo tsurl('site','notes',array('notesid'=>$notesid,'noteid'=>$noteid,'goon'=>'1'))?>#add_comment" rel="nofollow">继续发言</a>
    </div>    
    <?php } ?>
  </div>
</div>
<!--//评论-->            
<?php include template('comment_tpl'); ?> 
            
        </div>


    </div>
    
    <!--//main-->
    
    <!--aside-->      
    <div class="aside">  
    
    </div>
    <!--//aside-->  

    <div class="extra">
         
    </div>
 
</div>
<!--//内容-->

<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->
