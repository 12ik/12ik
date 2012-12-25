<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );

$ik = isset($_POST['ik']) ? $_POST['ik'] : $ik;
$userid = $_SESSION['ikuser']['userid'];

//小站操作
switch ($ik) {
	case "like" :
		
		if($userid>0)
		{
			//$arrJson = array('r'=>'0');
			$follow_siteid = trim($_POST['siteid']);
			aac('site')->create('site_follow',
				array('userid'=>$userid, 'follow_siteid'=>$follow_siteid,'addtime'=>time())
			);
			$arrJson = array('r'=>'0');
		}else{
			$arrJson = array('r'=>'1');
		}
		header("Content-Type: application/json", true);
		echo json_encode($arrJson);
	break;
	case "pop_like_form" :
		$htmltpl = '<div class="like-form"><input id="is_follow" type="checkbox" checked="on" value="0"> <label for="is_follow">同时关注爱客网小站的广播更新 </label>
					<div class="note">可以随时取消关注</div>
					<div class="submit-button">
						<span class="bn-flat"><input id="follow_submit" class="input-btn" type="button" value="保存"></span>
					</div></div>';
		echo $htmltpl;
		
	break;
	
	case "unlike" :
	
		if($userid>0)
		{
			$follow_siteid = trim($_POST['siteid']);
			aac('site')->delete('site_follow',array('userid'=>$userid, 'follow_siteid'=>$follow_siteid));
			$arrJson = array('r'=>'0');
		}else{
			$arrJson = array('r'=>'1');
		}
		header("Content-Type: application/json", true);
		echo json_encode($arrJson);
		
	break;	
	
	case "pop_unlike_form" :
		$htmltpl = '<div class="like-form">
    				<input id="un_follow" type="checkbox" checked="on"> <label for="un_follow">同时取消关注爱客网小站的广播更新 </label>
        			<div class="submit-button">
            		<span class="bn-flat"><input id="unfollow_submit" class="input-btn" type="button" value="确定"></span>
        			</div></div>';
		echo $htmltpl;
		
	break;	
		
	case "follow" :
		  $siteid = trim($_POST['siteid']);
		  $isfollow = trim($_POST['isfollow']);
		  aac('site')->update('site',array('siteid'=>$siteid),array('isfollow'	=> $isfollow));
	break;
	
	case "unfollow" :
		  $siteid = trim($_POST['siteid']);
		  $isfollow = trim($_POST['isfollow']);
		  aac('site')->update('site',array('siteid'=>$siteid),array('isfollow'	=> $isfollow));
	break;		

}