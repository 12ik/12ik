                <div class="mod" id="g-user-profile">
                
                    <div class="usercard">
                      <div class="pic">
                            <a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$strUser['doname']))?>"><img alt="<?php echo $strUser['username'];?>" src="<?php echo $strUser['face'];?>"></a>
                      </div>
                        <div class="info">
                            <div class="name">
                                <a href="<?php echo SITE_URL;?><?php echo ikurl('hi','',array('id'=>$strUser['doname']))?>"><?php echo $strUser['username'];?></a>
                            </div>
                            <?php if($strArea) { ?>
                            <?php echo $strArea['one'][areaname];?> 
                            <?php echo $strArea['two'][areaname];?> 
                            <?php echo $strArea['three'][areaname];?> 
                            <?php } else { ?>
                            火星
                            <?php } ?>                         
                         <br>
                        </div>
                    </div>
                      
                    <div class="group-nav">
                        <ul>
                            <li <?php if($ac=='my_group_topics') { ?>class="on"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my_group_topics')?>">我的小组话题</a></li>
							<li <?php if($ac=='my_topics') { ?>class="on"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my_topics')?>">我发起的话题</a></li>
                            <li <?php if($ac=='my_replied_topics') { ?>class="on"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my_replied_topics')?>">我回应的话题</a></li>
                            <li <?php if($ac=='my_collect_topics') { ?>class="on"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','my_collect_topics')?>">我收藏的话题</a></li>
                            <li <?php if($ac=='mine') { ?>class="on"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo ikurl('group','mine')?>">我管理/加入的小组</a></li>
                        </ul>
                    </div>
                    
                </div> 
                
                <div class="mod">
                   <?php if($IK_APP['options'][iscreate]==0 || $IK_USER['user'][isadmin]==1) { ?>
                    <div class="create-group">
                        <a href="<?php echo SITE_URL;?><?php echo ikurl('group','create')?>"><i>+</i>申请创建小组</a>
                    </div>
                   <?php } ?> 
                </div>  