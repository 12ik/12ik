<?php include pubTemplate("header");?>

<div style="margin:150px auto; width:350px;">
  <img src="<?php echo SITE_URL;?>public/images/ik_error.gif" style="float:left;">
  <ul style="margin-left:10px; list-style-type:none; list-style-image: none; list-style-position:outside;">
    <li style="font-size:14px; line-height: 32px; padding-left:30px"><?php echo $notice;?></li>
    <li style="color:#666;line-height: 10px;">&nbsp;</li>
    <?php if($isAutoGo == false) { ?>
    <li style="color:#666;"> 
        &gt; <span id="f3s">3</span>秒后 <a href="<?php echo $url;?>"><?php echo $button;?></a>
        <script type="text/javascript">
            (function(){
                var secs=5,si=setInterval(function(){
                    if(--secs){
                        document.getElementById('f3s').innerHTML = secs;
                    }
                    else{
                        location.href="<?php echo $url;?>";clearInterval(si);
                    }
            }, 1000)})();
        </script>
 	</li>
    <?php } ?> 
  </ul>
</div>


<?php include pubTemplate("footer");?>
