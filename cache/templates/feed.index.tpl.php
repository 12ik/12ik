<?php include template('header'); ?>

<style>
.mbtl {
    float: left;
    margin: 8px 7px 0 0;
    padding: 0;
    width: 55px;
}
.mbtr {
    border-bottom: 1px solid #EEEEEE;
    margin: 5px 0;
    min-height: 55px;
    overflow: hidden;
    padding: 5px 0;
}
.pl {
    color: #666666;
    line-height: 1.5;
}
.broadsmr {
    color: #999999;
    padding: 5px 24px;
}
.indentrec {
    color: #333333;
    line-height: 1.6em;
    margin-left: 24px;
}

.quote {
    background: url("http://t.douban.com/pics/quotel.gif") no-repeat scroll left 4px transparent;
    margin: 8px 0 0 26px;
    overflow: hidden;
    padding: 0 24px 5px 15px;
    width: auto;
    word-wrap: break-word;
}
.quote .inq {
    background: url("http://t.douban.com/pics/quoter.gif") no-repeat scroll right bottom transparent;
    color: #333333;
    display: inline-block;
    padding-right: 15px;
}

.broadimg {
    border: 1px solid #DDDDDD;
    float: right;
    margin-left: 14px;
}

.clearfix:after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    visibility: hidden;
}

.indentrec {
    color: #333333;
    line-height: 1.6em;
    margin-left: 24px;
}
.timeline-album {
    float: left;
    margin: 8px 12px 8px 0;
}
</style>

<div class="midder">
<div class="mc">
<h1>我的广播</h1>

<div class="cleft">


<div class="isay" id="db-isay">
<form action="<?php echo SITE_URL;?>index.php?app=feed&ac=addfeed&ik=do" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><textarea  style="height: 45px; width:600px" class="txt" name="content"></textarea></td>
  </tr>
  <tr>
    <td height="50"><input type="submit" value="我要广播" class="submit"></td>
  </tr>
</table>

</form> 
</div>


<ul>
<?php foreach((array)$arrFeed as $key=>$item) {?>
<?php if(date('Y-m-d',$item['addtime']) !=date('Y-m-d',$arrFeed[$key-1][addtime])) { ?>
<li style="margin-top:10px;border-bottom:1px solid #ddd;"><h2><?php echo date('Y-m-d h:s:m',$item['addtime'])?></h2></li>
<?php } ?>
<li class="mbtl">
<?php if($item['user'][userid] !=$arrFeed[$key-1][user][userid]) { ?>
<a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>" ><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a>
<?php } ?>
</li>
<li class="mbtr">
<a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$item['user'][doname]))?>"><?php echo $item['user'][username];?></a> 
<?php echo $item['content'];?>
</li>
<div class="clear"></div>
<?php }?>
</ul>

<div class="clear"></div>
<div class="page"><?php echo $pageUrl;?></div>
</div>

<div class="cright">

<div class="clear"></div>
<?php doAction('feed_index_right_footer')?>
</div>

</div>
</div>

<?php include template('footer'); ?>