<?php include template('header'); ?>

<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>

<div class="utable">
<form method="POST" action="<?php echo SITE_URL;?><?php echo ikurl('user','do',array('ik'=>'setdoname'))?>">
<table cellpadding="5" cellspacing="5">
<tr>
<th>个性域名：</th><td><input type="text" disabled="true" value="http://www.12ik.com/hi/" class="txt" style="width:140px; font-family:Arial; font-size:12px"/> <input class="txt" name="doname" value="<?php echo $strUser['doname'];?>" type="text" /></td>
</tr>
<tr><th></th><td><input class="submit" type="submit" value="好了，保存"  /></td></tr>

</table>
</form>
</div>



</div>
</div>

<?php include template('footer'); ?>