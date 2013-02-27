<div style="margin-bottom: 10px;overflow: hidden;">
<?php foreach((array)$arrUser as $key=>$item) {?>
<dl class="obu">
        <dt>
        	<a href="<?php echo U('hi','',array('id'=>$item['doname']))?>" title="<?php echo $item['username'];?>">
        		<img  alt="<?php echo $item['username'];?>"  src="<?php echo $item['face'];?>"class="m_sub_img"  >
            </a>
        </dt>
        <dd>
        	 <?php echo $item['username'];?><br>
            <span class="pl">(<a href="<?php echo U('location','area',array(areaid=>$item['area'][areaid]))?>"><?php echo $item['area'][areaname];?></a>)</span>
        </dd>
</dl>
        
        
<?php }?>
<br clear="all">
</div>