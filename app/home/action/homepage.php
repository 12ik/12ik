<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;		
$lstart = $page*10-10;


$arrPhoto = $db->fetch_all_assoc("select * from ".dbprefix."photo order by addtime desc limit $lstart,10");


include template ( "homepage" );