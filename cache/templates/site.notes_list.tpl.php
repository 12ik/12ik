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
.note-hd { margin-bottom:5px;font-size:14px;background:#efe; }
.note-item { margin-bottom:20px;overflow:hidden; }
.note-item .datetime { margin-bottom:5px; }
.note-item .lnk-more{ float:right;width:30px;height:15px;overflow:hidden;line-height:10em;background:url(<?php echo SITE_URL;?>/public/images/arrow.png) no-repeat center 3px; margin-top:3px; margin-right:10px;}
.note-item .lnk-more:hover{ background-color:#fff; border-radius:3px;}
.note-item .lnk-more-on{ float:right;width:30px;height:15px;overflow:hidden;line-height:10em;background:url(<?php echo SITE_URL;?>/public/images/arrow.png) no-repeat center -13px; margin-top:3px; margin-right:10px;}
.note-item .lnk-more-on:hover{ background-color:#fff; border-radius:3px;}

.ui-tooltip { width: 270px }
</style>    
    <div class="main"> 
         
        <div class="content-nav">
        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','room',array('siteid'=>$siteid,'roomid'=>$roomid))?>">&gt; 回<?php echo $strSite['sitename'];?></a>
        </div>  
        <h1><?php echo $strNotes['title'];?></h1> 
        <?php if($userid>0 && $strNotes['userid']==$userid) { ?>
        <div class="title-link">
        <a class="lnk-flat" href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'create','notesid'=>$notesid))?>">+ 写新日记</a>
        </div> 
        <?php } ?>            
        <div class="mod">

<script language="javascript">
function openfn(id,obj)
{
	$('#note_'+id+'_footer').slideToggle('fast');
	if($(obj).attr('class') =='lnk-more')
	{
		$(obj).attr('class','lnk-more-on');
	}else{
		$(obj).attr('class','lnk-more');	
	}
}
</script>
<?php foreach((array)$arrNote as $item) {?>
<div class="note-item" id="note-<?php echo $item['contentid'];?>">
  <div class="note-hd">
  	<a class="lnk-more" href="javascript:;" onClick="openfn(<?php echo $item['contentid'];?>,this)">展开</a>
    <h3>
    <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>" title="<?php echo $item['title'];?>">
    <?php echo $item['title'];?>
    </a>
    </h3>
  </div>
  <span class="datetime"><?php echo date('Y-m-d H:i:s',$item['addtime'])?></span>
  <div id="note_<?php echo $item['contentid'];?>_short" class="summary">
    <div class="ll">
        <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>" title="<?php echo $item['title'];?>">
            <img src="<?php echo $item['photo'][photo_140];?>" alt="<?php echo $item['title'];?>">
        </a>
    </div>  
   <?php echo getsubstrutf8($item['content'],0,200)?> </div>
  
  <div class="note-content"  id="note_<?php echo $item['contentid'];?>_full">
    <div id=""></div>
  </div>
  <br clear="all"/>
  <div class="note-ft" style="display:none" id="note_<?php echo $item['contentid'];?>_footer">
  	<span class="count">&nbsp;<?php echo $item['count_view'];?>人阅读</span>
    <span class="reply"><a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>#note_<?php echo $item['contentid'];?>_footer">(<?php echo $item['count_comment'];?>回应)</a></span>
    <?php if($userid>0 && $strNotes['userid']==$userid) { ?>
    <a href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'edit','notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>">&gt; 修改</a>
    <a title="真的要删除这篇日记吗？" onClick="return confirm('真的要删除这篇日记吗？')" class="a_confirm_link" href="<?php echo SITE_URL;?><?php echo ikurl('site','notes',array('ik'=>'delnote','notesid'=>$item['notesid'],'noteid'=>$item['contentid']))?>">&gt; 删除</a>
    <?php } ?>
    <div class="sns-bar"></div>
  </div>
</div>
<?php } ?>


            
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
