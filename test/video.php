<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>无标题文档</title>
</head>

<body>

<?php


//$link = 'http://www.56.com/u64/v_NzQ3MjI3MDE.html';
//$host = '56.com';
//$link = 'http://v.ku6.com/show/whfdQ21lW4Td-MZR4XYCxQ...html';
//$host = 'ku6.com';
//$link = 'http://www.tudou.com/programs/view/Tq-tNnWtI4M/?fr=rec2';//http://www.tudou.com/programs/view/_ke1lzCnBYw/
//$host = 'tudou.com';
//$host = 'youku.com';
$link = 'http://v.youku.com/v_show/id_XMzIxODkzMTIw.html';
$video = getVideoInfo ( $link);

show( $video['flashvar']);
show( $video['title']);
show( $video['imgurl']);
show( $video['videourl']);

function getVideoInfo($link) {
	$host = '';
	preg_match_all ( "/(\w+)\.com/", $link, $host);
	$host = $host[1][0].'.com';
	
	$return = array ();
	if ('youku.com' == $host) {
		//分析视频网址，获取视频编码号
		preg_match_all ( "/id\_(\w+)[\=|.html]/", $link, $matches );
		if (! empty ( $matches [1] [0] )) {
			$return ['flashvar'] = $matches [1] [0];
		}
		//获取视频页面内容，存与$text中
		$text = file_get_contents ( $link );
		
		//获取视频标题
		preg_match ( "/<title>(.*?)—(.*)<\/title>/", $text, $title );
		if (! empty ( $title )) {
			
			$return ['title'] = $title [1];
		}		

		//视频截图
		preg_match_all ( "/pic=(.*)\" target=\"_blank\"\>/", $text, $imgurl);
		if(!empty($imgurl[1][0]))
		{
			$return['imgurl'] = $imgurl[1][0];
		}

		//视频swf地址 value="http://player.youku.com/player.php/sid/XMzIxODkzMTIw/v.swf"
		preg_match_all ("/value=\"http:\/\/player.youku.com\/player.php\/(.*)\"/", $text, $videourl);
		if(!empty($videourl[1][0]))
		{
			$return['videourl'] = 'http://player.youku.com/player.php/'.$videourl[1][0];
		}


	} elseif ('ku6.com' == $host) {
		// http://v.ku6.com/show/Cev33WkRFavAJwI3nVfU7g...html?nv=1&st=1_8_3
		
		$text = file_get_contents ( $link );
		//编号
		preg_match_all ( "/show\/(.*)\.html/", $link, $matches );
		
		if(!empty($matches [1] [0]))
		{
			$return ['flashvar'] = $matches [1] [0];
		}

		preg_match ( "/<title>(.*?) (.*)<\/title>/", $text, $title );
		//视频截图
		preg_match_all ("/cover: \"http:\/\/(.*)\.jpg\"/", $text, $imgurl );

		if (! empty ( $imgurl [1] [0] )) {
			$return ['imgurl'] = $imgurl [1] [0].'.jpg';
		}
		if (! empty ( $title )) {
			$return ['title'] =   mb_convert_encoding( $title [1] , 'UTF-8', 'GBK');
		}
		//视频地址 http://player.ku6.com/refer/Cev33WkRFavAJwI3nVfU7g../v.swf
		preg_match_all ("/value=\"http:\/\/player.youku.com\/player.php\/(.*)\"/", $text, $videourl);
		$return['videourl'] = ' http://player.ku6.com/refer/'.$return ['flashvar'].'/v.swf';
			
		
	} elseif ('tudou.com' == $host) {
		
		//http://www.tudou.com/listplay/UHx2FIoEnMA.html 形式1 http://www.tudou.com/l/UHx2FIoEnMA/v.swf
		//http://www.tudou.com/programs/view/_ke1lzCnBYw/ 形式2 http://www.tudou.com/v/Wwa3w2wp4iA/v.swf
		$tudou = file_get_contents ( $link );
		$type = '';
		
		//视频编号
		preg_match_all ( "/view\/([\w\-]+)\//", $link, $matches );
		if(!empty ( $matches [1] [0] )){
			$type = 2;
			$return ['flashvar'] = $matches [1] [0];
		}else{
			preg_match_all ( "/listplay\/(.*)\.html/", $link, $matches );
			$type = 1 ;
			$return ['flashvar'] = $matches [1] [0];
		}


		//视频标题
		preg_match ( "/<title>(.*?)_(.*)<\/title>/", $tudou, $title );
		
		//截图 pic:"http://i1.tdimg.com/104/431/668/p.jpg" 二次匹配
		preg_match_all ( "/pic: '(.*)'/", $tudou, $imgurl );
		if(empty($imgurl[1][0]))
		{
			preg_match_all ( "/pic:\"(.*)\"/", $tudou, $imgurl );
		}		
		if (! empty ( $imgurl [1] [0] )) {
			$return ['imgurl'] = $imgurl [1] [0];
		}
		if (! empty ( $title )) {
			$return ['title'] = mb_convert_encoding( $title [1] , 'UTF-8', 'GBK');
		}
		//视频swf
		if($type==1)
		{
			$return['videourl'] = 'http://www.tudou.com/l/'.$return ['flashvar'] .'/v.swf';
		}else if($type==2)
		{
			$return['videourl'] = ' http://www.tudou.com/v/'.$return ['flashvar'] .'/v.swf';
		}
		
	}elseif ('56.com' == $host) {
		$text = file_get_contents ( $link );
		//视频编号http://www.56.com/u64/v_NzQ3MjI3MDE.html
		preg_match_all ( "/\/v\_(.*)\.html/", $link, $matches );

		if(!empty ( $matches [1] [0] )){
			$return ['flashvar'] = $matches [1] [0];
		}
		
	 	//视频标题
		preg_match ( "/<title>(.*?)_(.*)<\/title>/", $text, $title );
		if (! empty ( $title )) {
			$return ['title'] = $title [1];
		}	
		//视频截图 "img":"http:\/\/img.v41.56.com\/images\/27\/4\/jou1022i56olo56i56.com_sc_135589736151hd.jpg "
		$text = str_replace('\\','',$text);
		preg_match_all ("/\"img\":\"http:\/\/(.*)\.jpg \"/", $text, $imgurl );
		if (! empty ( $imgurl [1] [0] )) {
			$return ['imgurl'] = $imgurl [1] [0].'.jpg';
		}
		//视频地址 http://player.56.com/v_NzQ3MjI3MDE.swf
		$return['videourl'] = ' http://player.56.com/v_'.$return ['flashvar'].'.swf';

	}
	return $return;
}


?>

<!--
<object width="500" height="400" data=" http://www.tudou.com/v/Wwa3w2wp4iA/v.swf" type="application/x-shockwave-flash">
<param name="movie" value=" http://www.tudou.com/v/Wwa3w2wp4iA/v.swf">
<param value="transparent" name="wmode">
<param value="true" name="allowFullScreen">
<param value="always" name="allowScriptAccess">
<param value="autoplay=1" name="flashvars">
</object>
-->

</body>
</html>