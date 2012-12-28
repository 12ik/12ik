<?php include template('header'); ?>
<div class="midder">
<div class="mc">

    <div class="cleft">
     
          <div id="new-site-result">
                <div class="hd">
                    <h1><?php echo $title;?></h1>
                </div>
                <div class="bd">
                    <p><?php echo $IK_SITE['base'][site_title];?>的工作人员将核实你提交的内容，确定是否开通你的<?php echo $IK_SITE['base'][site_title];?>小站，需要你等待一段时间，我们会在五日内给你发站内信通知审核结果。 先去 <a href="<?php echo SITE_URL;?><?php echo ikurl('site','explore',array('ik'=>'site'))?>">看看别人的小站</a> 吧！</p>
                    <br>
                    <p>如有疑问，请发送邮件至：12ik.wang@gmail.com</p>
                </div>
           </div>

         
    </div>

    <div class="cright">
         
    </div>
    
</div>
</div>
<?php include template('footer'); ?>