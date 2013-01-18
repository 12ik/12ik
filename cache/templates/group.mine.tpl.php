<?php include template('header'); ?>
<div class="midder">


    <div class="mc">
    
   	    <h1><?php echo $title;?></h1>
       
        <div class="cleft w700">

            <div class="mod">
                <h2 class="tit-1">我管理的 <?php echo $count_Admingroup;?> 个小组</h2>
                <div class="indent obssin">
                
                <div class="groups">
                        <ul>
                            <?php foreach((array)$arrMyAdminGroup as $item) {?>
                            <li class="item">
                                <div class="pic">
                                    <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><img alt="<?php echo $item['groupname'];?>" class="m_sub_img" src="<?php echo $item['icon_48'];?>" width="48" height="48"></a>
                                </div>
                            
                                <div class="info">
                                    <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>" title="<?php echo $item['groupname'];?>"><?php echo getsubstrutf8(t($item['groupname']),0,12)?></a><br> 
                                    <span class="num">(<?php echo $item['count_user'];?>)</span><br>
                            </div>
                            </li>
                        	<?php } ?>
                        </ul>
                </div>
                </br>
                </div>
            </div>
            
			<div class="mod">
                <h2 class="tit-1">我加入的 <?php echo $count_mygroup;?> 个小组 </h2>
                <div class="indent obssin">
                
                <div class="groups">
                        <ul>
                            <?php foreach((array)$arrMyGroup as $item) {?>
                            <li class="item">
                                <div class="pic">
                                    <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>"><img alt="<?php echo $item['groupname'];?>" class="m_sub_img" src="<?php echo $item['icon_48'];?>"  width="48" height="48"></a>
                                </div>
                            
                                <div class="info">
                                    <a href="<?php echo SITE_URL;?><?php echo ikurl('group','show',array('id'=>$item['groupid']))?>" title="<?php echo $item['groupname'];?>"><?php echo getsubstrutf8(t($item['groupname']),0,12)?></a><br> 
                                    <span class="num">(<?php echo $item['count_user'];?>)</span><br>
                            	</div>
                            </li>
                        	<?php } ?>
                        </ul>
                </div>
                </br>
                </div>
            </div>

    	</div>
    
        <div class="cright w250" id="cright">   
              
			<?php include template('my_menu'); ?>                     
        
        </div>
    
    </div><!--//mc-->


</div>

<?php include template('footer'); ?>