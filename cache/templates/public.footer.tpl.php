<!--footer-->
<footer>
<div id="footer">
	<div class="f_content">
        <span class="fl gray-link" id="icp">
            &copy; 2012－2015 12ik.com, all rights reserved
        </span>
        
        <span class="fr">
            <a href="<?php echo SITE_URL;?><?php echo tsurl('home','about')?>">关于12IK</a>
            · <a href="<?php echo SITE_URL;?><?php echo tsurl('home','contact')?>">联系我们</a>
            · <a href="<?php echo SITE_URL;?><?php echo tsurl('home','agreement')?>">用户条款</a>
            · <a href="<?php echo SITE_URL;?><?php echo tsurl('home','privacy')?>">隐私申明</a>
        </span>
        <div class="cl"></div>
        <p>Powered by <a class="softname" href="<?php echo $IK_SOFT['info'][url];?>"><?php echo $IK_SOFT['info'][name];?></a> <?php echo $IK_SOFT['info'][version];?> <?php echo $IK_SOFT['info'][year];?> <?php echo $IK_SITE['base'][site_icp];?><br /><span style="font-size:0.83em;">Processed in <?php echo $runTime;?> second(s)</span>
        <script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>
        </p>   
    </div>
</div>
</footer>

<script src="<?php echo SITE_URL;?>public/js/slide.js" type="text/javascript"></script>

<?php if($IK_USER.user!='') { ?>
<script src="<?php echo SITE_URL;?>public/js/imbox/imbox.js" type="text/javascript"></script>
<script>
var userid=<?php echo intval($IK_USER['user'][userid])?>;
evdata(userid);
</script>
<?php } ?>

<?php doAction('pub_footer')?>
</body>
</html>
<?php if($IK_SITE['base'][isgzip]==1) { ?><?php ob_end_flush();?><?php } ?>