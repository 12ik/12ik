<?php include template("ajax/header");?>
<div style="padding:10px;">
<script src="<?php echo SITE_URL;?>public/js/jquery.js" type="text/javascript"></script>
<script>
function insertImgs(x){
	callback('<img src="'+x+'">');
}
</script>
图片地址：
<br />
<input  id="networkImg" type="text" value="http://" size="50" class="txt" /> 
<br /><br />
<button onclick="insertImgs(document.getElementById('networkImg').value);" class="submit">插入图片</button>
<br />
<br />
例如：http://www.12ik.com/theme/white/logo.gif
</div>

</body>
</html>