<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik爱客网 网站核心函数
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//AutoAppClass
function aac($appname) {
	global $db;
	$class = $appname;
	$path = IKAPP . '/' . $appname . '/';
	if (! class_exists ( $class )) {
		include_once $path . 'class.' . $class . '.php';
	}
	if (! class_exists ( $class )) {
		return false;
	}
	$obj = new $class ( $db );
	return $obj;
	
	unset ( $db );

}

//editor Special info  to html
function editor2html($str) {
	global $db;
	//匹配本地图片
	preg_match_all ( '/\[(photo)=(\d+)\]/is', $str, $photos );
	foreach ( $photos [2] as $item ) {
		$strPhoto = aac ( 'photo' )->getPhotoForApp ( $item );
		$str = str_replace ( "[photo={$item}]", '<a href="' . SITE_URL . 'uploadfile/photo/' . $strPhoto ['photourl'] . '" target="_blank">
							<img class="thumbnail" src="' . SITE_URL . ikXimg ( $strPhoto ['photourl'], 'photo', '500', '500', $strPhoto ['path'] ) . '" title="' . $strTopic ['title'] . $item . '" /></a>', $str );
	}
	
	//匹配附件
	preg_match_all ( '/\[(attach)=(\d+)\]/is', $str, $attachs );
	if ($attachs [2]) {
		foreach ( $attachs [2] as $aitem ) {
			$strAttach = aac ( 'attach' )->getOneAttach ( $aitem );
			if ($strAttach ['isattach'] == '1') {
				$str = str_replace ( "[attach={$aitem}]", '<span class="attach_down">附件下载：
									 <a href="' . SITE_URL . 'index.php?app=attach&a=ajax&ik=down&attachid=' . $aitem . '" target="_blank">' . $strAttach ["attachname"] . '</a></span>', $str );
			} else {
				$str = str_replace ( "[attach={$aitem}]", '', $str );
			}
		}
	}
	
	$find = array ("http://", "-", '.', "/", '?', '=', '&' );
	$replace = array ("", '_', '', '', '', '', '' );
	
	preg_match_all ( '/\[(video)=(.*?)\]/is', $str, $video );
	if ($video [2]) {
		foreach ( $video [2] as $aitem ) {
			//img play title
			$arr = explode ( ',', $aitem );
			$id = str_replace ( $find, $replace, $arr [0] );
			$html = '<div id="img_' . $id . '"><a href="javascript:void(0)" onclick="showVideo(\'' . $id . '\',\'' . $arr [1] . '\');"><img src="' . $arr [0] . '"/></a></div>';
			$html .= '<div id="play_' . $id . '" style="display:none">' . $arr ['2'] . ' <a href="javascript:void(0)" onclick="showVideo(\'' . $id . '\',\'' . $arr [1] . '\');">收起</a>
			<div id="swf_' . $id . '"></div> </div>';
			$str = str_replace ( "[video={$aitem}]", $html, $str );
		
		}
	}
	
	preg_match_all ( '/\[(mp3)=(.*?)\]/is', $str, $music );
	if ($music [2]) {
		foreach ( $music [2] as $aitem ) {
			//url title
			$arr = explode ( ',', $aitem );
			$id = str_replace ( $find, $replace, $arr [0] );
			
			//$mp3flash = '<div id="mp3img_'.$id.'"><a href="javascript:void(0)" onclick="showMp3(\''.$id.'\',\''.$arr[1].'\');"><img src="'.SITE_URL.'public/flash/music.gif" /></a></div>';
			

			$mp3flash = '<div id="mp3swf_' . $id . '" class="mp3player">
			<div>' . $arr [1] . ' <a href="' . $aitem . '" target="_blank">下载</a> </div>
			<object height="24" width="290" data="' . SITE_URL . 'public/flash/player.swf" type="application/x-shockwave-flash">
				<param value="' . SITE_URL . 'public/flash/player.swf" name="movie"/>
				<param value="autostart=no&bg=0xCDDFF3&leftbg=0x357DCE&lefticon=0xF2F2F2&rightbg=0xF06A51&rightbghover=0xAF2910&righticon=0xF2F2F2&righticonhover=0xFFFFFF&text=0x357DCE&slider=0x357DCE&track=0xFFFFFF&border=0xFFFFFF&loader=0xAF2910&soundFile=' . $aitem . '" name="FlashVars"/>
				<param value="high" name="quality"/>
				<param value="false" name="menu"/>
				<param value="#FFFFFF" name="bgcolor"/>
				</object></div>';
			$str = str_replace ( "[mp3={$aitem}]", $mp3flash, $str );
		
		}
	}
	return $str;
	unset ( $db );
}

//12IK Notice

function ikNotice($notice, $button = '点击返回', $url = 'javascript:history.back(-1);', $isAutoGo = false) {
	global $app;
	global $IK_SITE;
	global $IK_APP;
	global $site_theme;
	global $skin;
	global $IK_USER;
	global $IK_SOFT;
	global $runTime;
	
	$title = '系统提示';
	
	include pubTemplate ( 'notice' );
	
	exit ();
}

//系统消息


function qiMsg($msg, $button = '点击返回>>', $url = 'javascript:history.back(-1);', $isAutoGo = false) {
	echo <<<EOT
<html>
<head>
EOT;
	if ($isAutoGo) {
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站信息 提示</title>
<style type="text/css">
<!--
body {
font-family: Arial;
font-size: 12px;
line-height:150%;
text-align:center;
}
a{color:#555555;}
.main {
width:500px;
background-color:#FFFFFF;
font-size: 12px;
color: #666666;
margin:100px auto 0;
list-style:none;
padding:20px;
}
.main p {
line-height: 18px;
margin: 5px 20px;
font-size:14px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">$button</a></p>
</div>
</body>
</html>
EOT;
	exit ();
}

/*
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 * @return unknown
 */

function pagination($count, $perlogs, $page, $url, $suffix = '') {
	$pnums = @ceil ( $count / $perlogs );
	$re = '';
	for($i = $page - 5; $i <= $page + 5 && $i <= $pnums; $i ++) {
		if ($i > 0) {
			if ($i == $page) {
				$re .= ' <span class="thispage">' . $i . '</span> ';
			} else{
				$re .= '<a href="' . $url . $i . $suffix . '">' . $i . '</a>';
			}
		}
	}
	if ($page > 6)
		$re = '<a href="' . $url . '1' . $suffix . '" title="首页">&lt;首页</a><span class="break">...</span>' . $re;
	if ($page + 5 < $pnums)
		$re .= '<span class="break">...</span><a href="' . $url . $pnums . $suffix . '" title="尾页">尾页&gt;</a>';
	if ($pnums <= 1)
		$re = '';
	return $re;
}

//验证Email


function valid_email($email) {
	if (preg_match ( '/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9-]+\.)+[A-Za-z0-9]+$/', $email )) {
		return true;
	} else {
		return false;
	}
}

//处理时间的函数


function getTime($btime, $etime) {
	
	if ($btime < $etime) {
		$stime = $btime;
		$endtime = $etime;
	} else {
		$stime = $etime;
		$endtime = $btime;
	}
	$timec = $endtime - $stime;
	$days = intval ( $timec / 86400 );
	$rtime = $timec % 86400;
	$hours = intval ( $rtime / 3600 );
	$rtime = $rtime % 3600;
	$mins = intval ( $rtime / 60 );
	$secs = $rtime % 60;
	if ($days >= 1) {
		return $days . ' 天前';
	}
	if ($hours >= 1) {
		return $hours . ' 小时前';
	}
	
	if ($mins >= 1) {
		return $mins . ' 分钟前';
	}
	if ($secs >= 1) {
		return $secs . ' 秒前';
	}

}

//获取用户IP


function getIp() {
	
	if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
		$PHP_IP = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) {
		$PHP_IP = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) {
		$PHP_IP = getenv ( 'REMOTE_ADDR' );
	} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) {
		$PHP_IP = $_SERVER ['REMOTE_ADDR'];
	}
	preg_match ( "/[\d\.]{7,15}/", $PHP_IP, $ipmatches );
	$PHP_IP = $ipmatches [0] ? $ipmatches [0] : 'unknown';
	return $PHP_IP;
}

//过滤脚本代码
function cleanJs($text) {
	$text = trim ( $text );
	$text = stripslashes ( $text );
	//完全过滤注释
	$text = preg_replace ( '/<!--?.*-->/', '', $text );
	//完全过滤动态代码
	

	$text = preg_replace ( '/<\?|\?>/', '', $text );
	
	//完全过滤js
	$text = preg_replace ( '/<script?.*\/script>/', '', $text );
	//过滤多余html
	$text = preg_replace ( '/<\/?(html|head|meta|link|base|body|title|style|script|form|iframe|frame|frameset)[^><]*>/i', '', $text );
	//过滤on事件lang js
	while ( preg_match ( '/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onclick|onkey|onload|onchange|onfocus|onblur)[^><]+/i', $text, $mat ) ) {
		$text = str_replace ( $mat [0], $mat [1], $text );
	}
	while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat ) ) {
		$text = str_replace ( $mat [0], $mat [1] . $mat [3], $text );
	}
	return $text;
}

//纯文本输入
function t($text) {
	$text = cleanJs ( $text );
	//彻底过滤空格BY xiomai
	$text = preg_replace ( '/\s(?=\s)/', '', $text );
	$text = preg_replace ( '/[\n\r\t]/', ' ', $text );
	$text = str_replace ( '  ', ' ', $text );
	$text = str_replace ( ' ', '', $text );
	$text = str_replace ( '&nbsp;', '', $text );
	$text = str_replace ( '&', '', $text );
	$text = str_replace ( '=', '', $text );
	$text = str_replace ( '-', '', $text );
	$text = str_replace ( '#', '', $text );
	$text = str_replace ( '%', '', $text );
	$text = str_replace ( '!', '', $text );
	$text = str_replace ( '@', '', $text );
	$text = str_replace ( '^', '', $text );
	$text = str_replace ( '*', '', $text );
	$text = str_replace ( 'amp;', '', $text );
	
	$text = strip_tags ( $text );
	$text = htmlspecialchars ( $text );
	$text = str_replace ( "'", "", $text );
	return $text;
}

//输入安全的html，针对存入数据库中的数据进行的过滤和转义
function h($text) {
	$text = trim ( $text );
	$text = htmlspecialchars ( $text );
	$text = addslashes ( $text );
	return $text;
}

//主要针对输出的内容，对动态脚本，静态html，动态语言全部通吃
function hview($text) {
	$text = stripslashes ( $text ); //删除反斜杠
	$text = nl2br ( $text );
	return $text;
}

//反序列化为UTF-8
function mb_unserialize($serial_str) {
	$serial_str = preg_replace ( '!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
	$serial_str = str_replace ( "\r", "", $serial_str );
	return unserialize ( $serial_str );
}

//反序列化为ASC
function asc_unserialize($serial_str) {
	$serial_str = preg_replace ( '!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $serial_str );
	$serial_str = str_replace ( "\r", "", $serial_str );
	return unserialize ( $serial_str );
}

//utf-8截取
function getsubstrutf8($string, $start = 0, $sublen, $append = true) {
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all ( $pa, $string, $t_string );
	if (count ( $t_string [0] ) - $start > $sublen && $append == true) {
		return join ( '', array_slice ( $t_string [0], $start, $sublen ) ) . "...";
	} else {
		return join ( '', array_slice ( $t_string [0], $start, $sublen ) );
	}
}

//计算时间
function getmicrotime() {
	list ( $usec, $sec ) = explode ( " ", microtime () );
	return (( float ) $usec + ( float ) $sec);
}
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}
//初始化 url
function initurl($url) {

	$newurl = '';
	$blanks = array('url'=>'');
	$urls = $blanks;

	if(strlen($url)<10) return $blanks;
	$urls = @parse_url($url);
	if(empty($urls) || !is_array($urls)) return $blanks;
	if(empty($urls['scheme'])) return $blanks;
	if($urls['scheme'] == 'file') return $blanks;

	if(empty($urls['path'])) $urls['path'] = '/';
	$newurl .= $urls['scheme'].'://';
	$newurl .= empty($urls['user'])?'':$urls['user'];
	$newurl .= empty($urls['pass'])?'':':'.$urls['pass'];
	$newurl .= empty($urls['host'])?'':((!empty($urls['user']) || !empty($urls['pass']))?'@':'').$urls['host'];
	$newurl .= empty($urls['port'])?'':':'.$urls['port'];
	$newurl .= empty($urls['path'])?'':$urls['path'];
	$newurl .= empty($urls['query'])?'':'?'.$urls['query'];
	$newurl .= empty($urls['fragment'])?'':'#'.$urls['fragment'];

	$urls['port'] = empty($urls['port'])?'80':$urls['port'];
	$urls['url'] = $newurl;

	return $urls;
}
//读文件 借用 super site 的方法
function sreadfile($filename, $mode='r', $remote=0, $maxsize=0, $jumpnum=0) {
	if($jumpnum > 5) return '';
	$contents = '';

	if($remote) {
		$httpstas = '';
		$urls = initurl($filename);
		if(empty($urls['url'])) return '';

		$fp = @fsockopen($urls['host'], $urls['port'], $errno, $errstr, 20);
		if($fp) {
			if(!empty($urls['query'])) {
				fputs($fp, "GET $urls[path]?$urls[query] HTTP/1.1\r\n");
			} else {
				fputs($fp, "GET $urls[path] HTTP/1.1\r\n");
			}
			fputs($fp, "Host: $urls[host]\r\n");
			fputs($fp, "Accept: */*\r\n");
			fputs($fp, "Referer: $urls[url]\r\n");
			fputs($fp, "User-Agent: Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)\r\n");
			fputs($fp, "Pragma: no-cache\r\n");
			fputs($fp, "Cache-Control: no-cache\r\n");
			fputs($fp, "Connection: Close\r\n\r\n");

			$httpstas = explode(" ", fgets($fp, 128));
			if($httpstas[1] == 302 || $httpstas[1] == 302) {
				$jumpurl = explode(" ", fgets($fp, 128));
				return sreadfile(trim($jumpurl[1]), 'r', 1, 0, ++$jumpnum);
			} elseif($httpstas[1] != 200) {
				fclose($fp);
				return '';
			}

			$length = 0;
			$size = 1024;
			while (!feof($fp)) {
				$line = trim(fgets($fp, 128));
				$size = $size + 128;
				if(empty($line)) break;
				if(strexists($line, 'Content-Length')) {
					$length = intval(trim(str_replace('Content-Length:', '', $line)));
					if(!empty($maxsize) && $length > $maxsize) {
						fclose($fp);
						return '';
					}
				}
				if(!empty($maxsize) && $size > $maxsize) {
					fclose($fp);
					return '';
				}
			}
			fclose($fp);

			if(@$handle = fopen($urls['url'], $mode)) {
				if(function_exists('stream_get_contents')) {
					$contents = stream_get_contents($handle);
				} else {
					$contents = '';
					while (!feof($handle)) {
						$contents .= fread($handle, 8192);
					}
				}
				fclose($handle);
			} elseif(@$ch = curl_init()) {
				curl_setopt($ch, CURLOPT_URL, $urls['url']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);//timeout
				$contents = curl_exec($ch);
				curl_close($ch);
			} else {
				//无法远程上传
			}
		}
	} else {
		if(@$handle = fopen($filename, $mode)) {
			$contents = fread($handle, filesize($filename));
			fclose($handle);
		}
	}

	return $contents;
}

//写文件 借用 super site 的方法
function writefile($filename, $writetext, $filemod='text', $openmod='w', $eixt=1) {
	if(!@$fp = fopen($filename, $openmod)) {
		if($eixt) {
			exit('File :<br>'.srealpath($filename).'<br>Have no access to write!');
		} else {
			return false;
		}
	} else {
		$text = '';
		if($filemod == 'php') {
			$text = "<?php\r\n\r\nif(!defined('IN_IK')) exit('Access Denied');\r\n\r\n";
		}
		$text .= $writetext;
		if($filemod == 'php') {
			$text .= "\r\n\r\n?>";
		}
		flock($fp, 2);
		fwrite($fp, $text);
		fclose($fp);
		return true;
	}
}
/*写入文件
 @By 小麦 2012-4-10
 @$file 缓存文件
 @$dir 缓存目录
 @$data 内容
 */
function fileWrite($file, $dir, $data) {
	
	//! is_dir ( $dir ) ? mkdir ( $dir, 0777 ) : '';
	if(!is_dir($dir))
	{
		@mkdir ( $dir, 0777 );
		@chmod ( $dir, 0777 );
	}
	
	$dfile = $dir . '/' . $file;
	
	if (is_file ( $dfile ))
		unlink ( $dfile );
	
	$data = "<?php\ndefined('IN_IK') or die('Access Denied.');\nreturn " . var_export ( $data, true ) . ";";
	
	file_put_contents ( $dfile, $data );
	
	return true;

}

/*读取文件
 @$dfile 文件
*/
function fileRead($dfile) {
	if (is_file ( $dfile )) {
		$data = include $dfile;
		return $data;
	}
}

//把数组转换为,号分割的字符串
function array_to_str($arr) {
	$str = '';
	$count = 1;
	if (is_array ( $arr )) {
		foreach ( $arr as $a ) {
			if ($count == 1) {
				$str .= $a;
			} else {
				$str .= ',' . $a;
			}
			$count ++;
		}
	}
	return $str;
}

//生成随机数(1数字,0字母数字组合)
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand ( ( double ) microtime () * 1000000 ) : mt_srand ();
	$seed = base_convert ( md5 ( print_r ( $_SERVER, 1 ) . microtime () ), 16, $numeric ? 10 : 35 );
	$seed = $numeric ? (str_replace ( '0', '', $seed ) . '012340567890') : ($seed . 'zZ' . strtoupper ( $seed ));
	$hash = '';
	$max = strlen ( $seed ) - 1;
	for($i = 0; $i < $length; $i ++) {
		$hash .= $seed [mt_rand ( 0, $max )];
	}
	return $hash;
}

/*
 *封装一个采集函数
 *@ $url 网址
 *@ $proxy 代理
 *@ $timeout 跳出时间
 */

function getHtmlByCurl($url, $proxy, $timeout) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_PROXY, $proxy );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
	$file_contents = curl_exec ( $ch );
	// close curl resource, and free up system resources
	curl_close($ch);
	return $file_contents;
}

//计算文件大小
function format_bytes($size) {
	$units = array (' B', ' KB', ' MB', ' GB', ' TB' );
	for($i = 0; $size >= 1024 && $i < 4; $i ++)
		$size /= 1024;
	return round ( $size, 2 ) . $units [$i];
}

/*
 * 功能:               判断是否是手机访问
 * 参数:               无
 * 返回值:            返回1为是手机访问,返回0时为不是
 */
function is_wap() {
	$http_via = isset ( $_SERVER ['HTTP_VIA'] ) ? strtolower ( $_SERVER ['HTTP_VIA'] ) : '';
	return ! empty ( $http_via ) && strstr ( $http_via, 'wap' ) ? 1 : 0;
}

//object_array 对象转数组
function object_array($array) {
	if (is_object ( $array )) {
		$array = ( array ) $array;
	}
	if (is_array ( $array )) {
		foreach ( $array as $key => $value ) {
			$array [$key] = object_array ( $value );
		}
	}
	return $array;
}

/*此处开始借用moophp的模板代码*/

/**
 * 写文件
 * @param string $file - 需要写入的文件，系统的绝对路径加文件名
 * @param string $content - 需要写入的内容
 * @param string $mod - 写入模式，默认为w
 * @param boolean $exit - 不能写入是否中断程序，默认为中断
 * @return boolean 返回是否写入成功
 */
function isWriteFile($file, $content, $mod = 'w', $exit = TRUE) {

	if (! @$fp = @fopen ( $file, $mod )) {
		if ($exit) {
			exit ( '12IK File :<br>' . $file . '<br>Have no access to write!' );
		} else {
			return false;
		}
	} else {
		@flock ( $fp, 2 );
		@fwrite ( $fp, $content );
		@fclose ( $fp );
		return true;
	}

}

//创建目录
function makedir($dir) {
	return is_dir ( $dir ) or (makedir ( dirname ( $dir ) ) and mkdir ( $dir, 0777 ) and chmod ( $dir, 0777 ));
}

/**
 * 加载模板
 * @param string $file - 模板文件名
 * @return string 返回编译后模板的系统绝对路径
 */
function template($file) {
	global $app;
	$tplfile = 'app/' . $app . '/html/' . $file . '.html';
	$objfile = 'cache/templates/' . $app . '.' . $file . '.tpl.php';	
	if (@filemtime ( $tplfile ) > @filemtime ( $objfile )) {
		//note 加载模板类文件
		require_once 'core/class.template.php';
		$T = new template ();
		$T->complie ( $tplfile, $objfile );
	
	}
	
	return $objfile;
	unset ( $app );
}

//加载公用html模板文件 
function pubTemplate($file) {
	$tplfile = 'public/html/' . $file . '.html';
	$objfile = 'cache/templates/public.' . $file . '.tpl.php';
	
	if (@filemtime ( $tplfile ) > @filemtime ( $objfile )) {
		//note 加载模板类文件
		

		require_once 'core/class.template.php';
		$T = new template ();
		
		$T->complie ( $tplfile, $objfile );
	}
	
	return $objfile;
}

//针对app各个的插件部分，修改自Emlog
/**
 * 该函数在插件中调用,挂载插件函数到预留的钩子上
 *
 * @param string $hook
 * @param string $actionFunc
 * @return boolearn
 */
function addAction($hook, $actionFunc) {
	global $ikHooks;
	if (! @in_array ( $actionFunc, $ikHooks [$hook] )) {
		$ikHooks [$hook] [] = $actionFunc;
	}
	
	return true;
}

/**
 * 执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
function doAction($hook) {
	global $ikHooks;
	$args = array_slice ( func_get_args (), 1 );
	if (isset ( $ikHooks [$hook] )) {
		foreach ( $ikHooks [$hook] as $function ) {
			$string = call_user_func_array ( $function, $args );
		}
	}
}

function createFolders($path) {
	//递归创建  
	if (! file_exists ( $path )) {
		createFolders ( dirname ( $path ) ); //取得最后一个文件夹的全路径返回开始的地方  
		mkdir ( $path, 0777 );
	}
}

//删除文件夹和文件夹下所有的文件
function delDir($dir = '') {
	if (empty ( $dir )) {
		$dir = rtrim ( RUNTIME_PATH, '/' );
	}
	if (substr ( $dir, - 1 ) == '/') {
		$dir = rtrim ( $dir, '/' );
	}
	if (! file_exists ( $dir ))
		return true;
	if (! is_dir ( $dir ) || is_link ( $dir ))
		return @unlink ( $dir );
	foreach ( scandir ( $dir ) as $item ) {
		if ($item == '.' || $item == '..')
			continue;
		if (! delDir ( $dir . "/" . $item )) {
			@chmod ( $dir . "/" . $item, 0777 );
			if (! delDir ( $dir . "/" . $item ))
				return false;
		}
		;
	}
	return @rmdir ( $dir );
}

//获取带http的网站域名 BY wanglijun
function getHttpUrl(){
	$arrUri = explode('index.php',$_SERVER['REQUEST_URI']);
	$site_url = 'http://'.$_SERVER['HTTP_HOST'].$arrUri[0];
	return $site_url;
}

// 10位MD5值
function md10($str = '') {
	return substr ( md5 ( $str ), 10, 10 );
}

/*
 * 12IK专用图片截图函数
 * $file：数据库里的图片url
 * $app：app名称
 * $w：缩略图片宽度
 * $h：缩略图片高度
 * $c:1裁切,0不裁切
 * $srcX:x坐标
 * $srcY:y坐标
 * $srcW:截图宽
 * $isRatio:1 安指定比例截图 0 等比截图
 * $conditions 数组形式 arrary('srcX'=>0, 'srcY'=>0, 'srcW'=>0, 'isRatio'=>0)
 */
function ikXimg($file, $app, $w, $h, $path = '', $c = '0', $conditions='') {
	
	if (! $file) {
		return;
	}
	
	$info = explode ( '.', $file );
	
	$name = md10 ( $file ) . '_' . $w . '_' . $h . '.' . $info [1];
	
	if ($path == '') {
		$cpath = 'cache/' . $app . '/' . $w . '/' . $name;
	} else {
		$cpath = 'cache/' . $app . '/' . $path . '/' . $w . '/' . $name;
	}
	//条件
	if (is_array ( $conditions ) && !empty($conditions)){
		
		$srcX = $conditions['X'];
		$srcY = $conditions['Y'];
		$srcW = $conditions['W'];
		$srcH = $conditions['H'];		
		$isRatio = $conditions['R'];
	}

	//不截图
	if($isRatio==0)
	{
		if (! is_file ( $cpath )) {
			createFolders ( 'cache/' . $app . '/' . $path . '/' . $w );
			$dest = 'uploadfile/' . $app . '/' . $file; 
			$arrImg = getimagesize ( $dest );
			if ($arrImg [0] <= $w) {
				copy ( $dest, $cpath );
			} else {
				require_once 'core/IKImage.php';
				$resizeimage = new IKImage ( "$dest", $w, $h, $c, "$cpath");
			}
		}
		
	}else{
		//截图
		if (! is_file ( $cpath ))
		{
			createFolders ( 'cache/' . $app . '/' . $path . '/' . $w );
			require_once 'core/IKImage.php';
			$resizeimage = new IKImage ( "$file", $w, $h, $c, "$cpath", $srcX, $srcY,$srcW,$srcH, $isRatio);
		}		
		
	}


	return $cpath;
}

//gzip压缩输出
function ob_gzip($content) {
	if (! headers_sent () && extension_loaded ( "zlib" ) && strstr ( $_SERVER ["HTTP_ACCEPT_ENCODING"], "gzip" )) {
		//$content = gzencode($content." \n//此页已压缩",9); 
		$content = gzencode ( $content, 9 );
		header ( "Content-Encoding: gzip" );
		header ( "Vary: Accept-Encoding" );
		header ( "Content-Length: " . strlen ( $content ) );
	}
	return $content;
}

/* tsUrl()  By 12ik
 * U提供至少4种的url展示方式
 * (1)index.php?app=group&a=topic&topicid=1 //标准默认模式
 * (2)index.php/group/topic/topicid-1   //path_info模式
 * (3)group-topic-topicid-1.html   //rewrite模式1
 * (4)group/topic/ik-user/topicid-1/   //rewrite模式2
 * (5)group/topic/1   //rewrite模式2
 * (6)group/topic/id/1   //rewrite模式2
 * (7)group/topic/1/   //rewrite模式2
 */
function U($app, $a = '', $params = array()) {
	//global $IK_SITE;
	//echo $IK_SITE['base']['site_urltype'];
	if (is_file ( 'data/system_options.php' )) {
		$options = include 'data/system_options.php';
	} else {
		$options = include 'data/cache/system/options.php';
	}
	
	$urlset = $options ['site_urltype'];
	
	if($urlset==1){
		foreach($params as $k=>$v){
			$str .= '&'.$k.'='.$v;
		}
		if($a==''){
			$a = '';
		}else{
			$a='&a='.$a;
		}
		
		$url = SITE_URL.'index.php?app='.$app.$a.$str;
		
	}elseif($urlset == 2){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'-'.$v;
		}
		if($a==''){
			$a='';
		}else{
			$a='/'.$a;
		}
		$url = 'index.php/'.$app.$a.$str;
	}elseif($urlset == 3){
		foreach($params as $k=>$v){
			$str .= '-'.$k.'-'.$v;
		}
		
		if($a==''){
			$a='';
		}else{
			$a='-'.$a;
		}
		
		$page = strpos($str,'page');
		
		if($page){
			$url = $app.$a.$str;
		}else{
			$url = $app.$a.$str.'.html';
		}
		
	}elseif($urlset == 4){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'-'.$v;
		}		
		if($a==''){
			$a='';
		}else{
			$a='/'.$a;
		}
		
		$url = $app.$a.$str;
	}elseif($urlset == 5){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		$str=str_replace('/id','',$str);	
		if($a==''){
			$a='';
		}else{
			$a='/'.$a;
		}
		
		$url = $app.$a.$str;
	}elseif($urlset == 6){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		
		if($a==''){
			$a='';
		}else{
			$a='/'.$a;
		}
		
		$url = $app.$a.$str;
	}elseif($urlset == 7){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		$str=str_replace('/id','',$str);
		$str=str_replace('/ik','',$str);
		if($a==''){
			$a='';
		}else{
			$a='/'.$a;
		}
		
		$page = strpos($str,'page');
		
		if($page){
			$url = $app.$a.$str;
		}else{
			$url = $app.$a.$str.'/';
		}
		
	}	
	return $url;
}

//reurl BY Charm 2012-4-10


function reurl(){ 
	$options = fileRead('data/system_options.php');	
	$scriptName = explode('index.php',$_SERVER['SCRIPT_NAME']);

	$rurl = substr($_SERVER['REQUEST_URI'], strlen($scriptName[0]));
	
	
	if(strpos($rurl,'?')==false){
	
		if(preg_match('/index.php/i',$rurl)){
			$rurl = str_replace('index.php','',$rurl);
			$rurl = substr($rurl, 1);			
			$params = $rurl;
			
		}else{
			$params = $rurl;
		}
		
		
		if($rurl){
			
			if($options['site_urltype']==3){
			//http://localhost/group-topic-id-1.html
				$params = explode('.', $params);
				
				$params = explode('-', $params[0]);
			
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							
							if($v) $kv[] = $v;
							
							break;
					}
				}
				
				$ck = count($kv)/2;
				
				if($ck>=2){
					$arrKv = array_chunk($kv,$ck);
					foreach($arrKv as $key=>$item){
						$_GET[$item[0]] = $item[1];
					}
				}elseif($ck==1){
					$_GET[$kv[0]] = $kv[1];
				}else{
					
				}
				
			}elseif($options['site_urltype']==4){
			//http://localhost/group/topic/id-1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}elseif($options['site_urltype']==5){
			//http://localhost/group/topic/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;
							if(empty($_GET['ac'])) $_GET['ac']='index';
							break;
						case 2:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			
			}elseif($options['site_urltype']==6){
			//http://localhost/group/topic/id/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			}elseif($options['site_urltype']==7){
			//http://localhost/group/topic/1/
				
				$params = explode('/', $params);

				foreach( $params as $p => $v ){
					//echo $p.'='.$v.'<br/>';
					switch($p){
						case 0:
							$_GET['app']=$v;
							break;
						case 1:
							$_GET['ac']=$v;//默认
							//echo $_GET['app'].'------------';
							if(empty($_GET['ac']))
							{ 
								$_GET['ac']='index';
								
							}
							/*else if(((int) $v)>0){
								
								$_GET['ac']='index';
								$_GET['id']=$v;
							}
							*/
							else if($_GET['app']=='hi' && $params[2]=='')
							{
								$_GET['ac']='index';
								$_GET['id']=$v;
							}				
							break;
						case 2:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
							if(is_string($v) && !empty($v))
							{
								$paramid = substr($v, strlen($v)-2);
								if($paramid!='id')
								{
									$_GET['ik']=$v;
									break;								
								}

							}
						default:
								$_GET[$v]=$params[$p+1];
							break;
					}
				}
				
			}else{
				
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}
		}
	}
}

//检测目录是否可写1可写，0不可写
function iswriteable($file) {
	if (is_dir ( $file )) {
		$dir = $file;
		if ($fp = fopen ( "$dir/test.txt", 'w' )) {
			fclose ( $fp );
			unlink ( "$dir/test.txt" );
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	} else {
		if ($fp = fopen ( $file, 'a+' )) {
			fclose ( $fp );
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

//删除目录下文件
function delDirFile($dir) {
	$arrFiles = dirList ( $dir, 'files' );
	foreach ( $arrFiles as $item ) {
		unlink ( $dir . '/' . $item );
	}
}

/*
 * 12IK专用上传函数 
 * $file 要上传的文件 如$_FILES['photo']
 * $projectid 上传针对的项目id  如$userid
 * $dir 上传到目录  如 user
 * $uptypes 上传类型，数组 array('jpg','png','gif')
 *
 * 返回数组：array('name'=>'','path'=>'','url'=>'','path'=>'','size'=>'')
 */
function ikUpload($files, $projectid, $dir, $uptypes) {
	
	//ClearOptCache('group');

	if (! empty ( $files )) {
		
		$menu2 = intval ( $projectid / 1000 );
		
		$menu1 = intval ( $menu2 / 1000 );
		
		$path = $menu1 . '/' . $menu2;
		
		$dest_dir = 'uploadfile/' . $dir . '/' . $path;
		
		createFolders ( $dest_dir );
		
		$arrType = explode('.',strtolower($files['name'])); //转小写一下
		
		$type = array_pop ( $arrType );
		
		if (in_array ( $type, $uptypes )) {
			
			$name = $projectid . '.' . $type;
			
			$dest = $dest_dir . '/' . $name;
			
			//先删除
			unlink($dest);
			//后上传
			
			move_uploaded_file ( $files ['tmp_name'], mb_convert_encoding ( $dest, "gb2312", "UTF-8" ) );
			
			// 所有者有所有权限，其他所有人可读和执行
			chmod ( $dest, 0755 );//chmod($dest, 0777);
			
			return array ('name' => $name, 'path' => $path, 'url' => $path . '/' . $name, 'type' => $type, 'size' => $files ['size'] );
		
		} else {
			return false;
		}
	}
}

//扫描目录
function ikScanDir($dir, $isDir = null) {
	
	if ($isDir == null) {
		$dirs = array_filter ( glob ( $dir . '/' . '*' ), 'is_dir' );
	} else {
		$dirs = array_filter ( glob ( $dir . '/' . '*' ), 'is_file' );
	}
	
	foreach ( $dirs as $key => $item ) {
		$arrDirs [] = array_pop ( explode ( '/', $item ) );
	}
	
	return $arrDirs;

}

//删除目录下所有文件
function rmrf($dir) {
	foreach ( glob ( $dir ) as $file ) {
		if (is_dir ( $file )) {
			rmrf ( "$file/*" );
			rmdir ( $file );
		} else {
			unlink ( $file );
		}
	}
}

/**
 * 修改于 2012-4-13 小麦
 * 清除指定路径缓存 用法： ClearAppCache($app.'/'.$arrUpload['path']);
 * @param string $dir - 路径名
 * @return true 返回 true 成功 false 失败
 */
function ClearAppCache($dir)
{	
	$cachedir =  'cache/'.$dir;
	foreach ( glob ( $cachedir ) as $file ) {		
		if (is_dir ( $file )) {
			//echo $file;
			rmrf ( "$file/*" );
			rmdir ( $file );
		} else {
			unlink ( $file );
		}
		return TRUE;
	}
    return FALSE;
}
//限制输入字符长度，防止缓冲区溢出攻击
function LenLimit($Str,$MaxSlen){
    if(isset($Str{$MaxSlen})){
        return " ";
    }else{
        return $Str;
    }
}

//post,get对象过滤通用函数
function long_check($post)
{
   $MaxSlen=3000;//限制较长输入项最多3000个字符
   if (!get_magic_quotes_gpc())    // 判断magic_quotes_gpc是否为打开
   {
      $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
   }
   $post = LenLimit($post,$MaxSlen);
   $post = str_replace("\'", "’", $post);
   $post= htmlspecialchars($post);    // 将html标记转换为可以显示在网页上的html
   //$post = nl2br($post);    // 回车
   return $post;
}

function big_check($post){
	$MaxSlen=20000;//限制大输入项最多20000个字符
	if (!get_magic_quotes_gpc())    // 判断magic_quotes_gpc是否为打开
	{
		$post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
	}
	$post = LenLimit($post,$MaxSlen);
	$post = str_replace("\'", "’", $post);
	$post = str_replace("<script ", "", $post);
	$post = str_replace("</script ", "", $post);	
	return $post;
}

function short_check($str)
{
   $MaxSlen=500;//限制短输入项最多300个字符
   if (!get_magic_quotes_gpc())    // 判断magic_quotes_gpc是否打开
   {
      $str = addslashes($str);    // 进行过滤
   }
		$str = LenLimit($str,$MaxSlen);
		$str = str_replace(array("\'","\\","#"),"",$str);
		if($str!=''){
			$str= htmlspecialchars($str);
		}
		return preg_replace("/　+/","",trim($str));
}

function filter_script($str){
	return preg_replace(array('/<\s*script/','/<\s*\/\s*script\s*>/',"/<\?/","/\?>/"),array("&lt;script","&lt;/script&gt;","&lt;?","?&gt;"),$str);
}

//过滤16进制
function cleanHex($input){
     $clean = preg_replace("![\][xX]([A-Fa-f0-9]{1,3})!", "",$input);
     return $clean;
}

//多余字截取函数
function sub_str($str, $length = 0, $append = true, $charset='utf8') {
	$str = trim($str);
	$strlength = strlen($str);
	$charset = strtolower($charset);
	if ($charset == 'utf8') {
		$l = 0;
		$i = 0;
		while ($i < $strlength) {
			if (ord($str{$i}) < 0x80) {
				$l++; $i++;
			} else if (ord($str{$i}) < 0xe0) {
				$l++; $i += 2;
			} else if (ord($str{$i}) < 0xf0) {
				$l += 2; $i += 3;
			} else if (ord($str{$i}) < 0xf8) {
				$l += 1; $i += 4;
			} else if (ord($str{$i}) < 0xfc) {
				$l += 1; $i += 5;
			} else if (ord($str{$i}) < 0xfe) {
				$l += 1; $i += 6;
			}
			if ($l >= $length) {
				$newstr = substr($str, 0, $i);
				break;
			}
		}
		if($l < $length) {
			return $str;
		}
	} elseif($charset == 'gbk') {
		if ($length == 0 || $length >= $strlength) {
			return $str;
		}
		while ($i <= $strlength) {
			if (ord($str{$i}) > 0xa0) {
				$l += 2; $i += 2;
			} else {
				$l++; $i++;
			}
			if ($l >= $length) {
				$newstr = substr($str, 0, $i);
				break;
			}
		}
	}
	if ($append && $str != $newstr) {
		$newstr .= '..';
	}
	return $newstr;
}


function str_addslashes($str) {
	if(!get_magic_quotes_gpc()) {
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$str[$key] = str_addslashes($val);
			}
		} else {
			$str = addslashes($str);
		}
	}
	return $str;
}
function str_filter($str,$max_num='20000'){
	if(is_array($str)){
		foreach($str as $key => $val) {
			$str[$key] = str_filter($val,$max_num);
		}
	}else{
		$str = LenLimit($str,$max_num);
		$str = trim($str);
		$str = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',htmlspecialchars($str));
		$str = str_replace("　","",$str);
	}
	return str_addslashes($str);
}
/**
 * html代码正常输出
 * @param str
 * 用法：html_filter($_POST("detail")); <font color="red">1</font>正常方式输出
 */
function html_filter($str,$max_num='20000'){
	if(is_array($str)){
		foreach($str as $key => $val){
			$str[$key] = html_filter($val);
		}
	}else{
		$str = LenLimit($str,$max_num);
		$str = trim($str);
		$tran_before = array('/<\s*a[^>]*href\s*=\s*[\'\"]?(javascript|vbscript)[^>]*>/i','/<([^>]*)on(\w)+=[^>]*>/i','/<\s*\/?\s*(script|i?frame)[^>]*\s*>/i');
		$tran_after = array('<a href="#">','<$1>','&lt;$1&gt;');
		$str = preg_replace($tran_before,$tran_after,$str);
		$str = str_replace("　","",$str);
	}
	return str_addslashes($str);
}
//htmlspecialchars() 函数把一些预定义的字符转换为 HTML 实体。& （和号） 成为 &amp;
//html 转化
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
				str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}
function saddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = saddslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}
//将数组加上单引号,并整理成串
function simplode($sarr, $comma=',') {
	return '\''.implode('\''.$comma.'\'', $sarr).'\'';
}

//数组转换成字串
function arrayeval($array, $level = 0) {
	$space = '';
	$evaluate = "Array $space(";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",$space";
	}
	$evaluate .= "$space)";
	return $evaluate;
}
//格式化路径
function srealpath($path) {
	$path = str_replace('./', '', $path);
	if(DIRECTORY_SEPARATOR == '\\') {
		$path = str_replace('/', '\\', $path);
	} elseif(DIRECTORY_SEPARATOR == '/') {
		$path = str_replace('\\', '/', $path);
	}
	return $path;
}
//取8位md5
function smd5($str) {
	return substr(md5($str), 8, 16);
}
//获取文件名后缀
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}
function sgmdate($timestamp, $dateformat='', $format=0) {
	global $_SCONFIG, $_SGLOBAL, $lang;

	if(empty($dateformat)) {
		$dateformat = 'Y-m-d H:i:s';
	}

	if(empty($timestamp)) {
		$timestamp = $_SGLOBAL['timestamp'];
	}

	$result = '';
	if($format) {
		$time = $_SGLOBAL['timestamp'] - $timestamp;
		if($time > 24*3600) {
			$result = gmdate($dateformat, $timestamp + $_SGLOBAL['timezone'] * 3600);
		} elseif ($time > 3600) {
			$result = intval($time/3600).'小时前';
		} elseif ($time > 60) {
			$result = intval($time/60).'分钟前';
		} elseif ($time > 0) {
			$result = $time.'秒前';
		} else {
			$result = '现在';
		}
	} else {
		$result = gmdate($dateformat, $timestamp + $_SGLOBAL['timezone'] * 3600);
	}
	return $result;
}
//获得表
function tname($name, $mode=0) {
	return 'ik_'.$name;
}
//修改人 小麦 QQ:160780470  
/*
 *  视频采集
 *  //$link = 'http://www.56.com/u64/v_NzQ3MjI3MDE.html';
	//$host = '56.com';
	//$link = 'http://v.ku6.com/show/whfdQ21lW4Td-MZR4XYCxQ...html';
	//$host = 'ku6.com';
	//$link = 'http://www.tudou.com/programs/view/Tq-tNnWtI4M/?fr=rec2';//http://www.tudou.com/programs/view/_ke1lzCnBYw/
	//$host = 'tudou.com';
	//$host = 'youku.com';
	//$link = 'http://v.youku.com/v_show/id_XMzIxODkzMTIw.html';
 * */
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
			$return ['imgurl'] = 'http://'.$imgurl [1] [0].'.jpg';
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
			$return ['imgurl'] = 'http://'.$imgurl [1] [0].'.jpg';
		}
		//视频地址 http://player.56.com/v_NzQ3MjI3MDE.swf
		$return['videourl'] = ' http://player.56.com/v_'.$return ['flashvar'].'.swf';

	}
	return $return;
}
//显示视频
function ikVideo($videourl,$title='',$w = 500, $h = 400)
{
	$html = '<div align="center"><object width="'.$w.'" height="'.$h.'" data="'.$videourl.'" type="application/x-shockwave-flash"><param name="movie" value="'.$videourl.'"><param value="transparent" name="wmode"><param value="true" name="allowFullScreen"><param value="always" name="allowScriptAccess"><param value="autoplay=1" name="flashvars"></object><p>'.$title.'</p></div>';
	return $html;
}
//所有的 ' (单引号), " (双引号), \ (反斜线) and 空字符会自动转为含有反斜线的转义字符
function addslashes_deep($value) {
	$value = is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
	return $value;
}
//删除由 addslashes() 函数添加的反斜杠
function stripslashes_deep($value) {
	if (is_array($value)) {
		$value = array_map('stripslashes_deep', $value);
	} elseif (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value->{$key} = stripslashes_deep($data);
		}
	} else {
		$value = stripslashes($value);
	}

	return $value;
}
function noGPC() {
	if ( get_magic_quotes_gpc() ) {
		$_POST = stripslashes_deep($_POST);
		$_GET = stripslashes_deep($_GET);
		$_COOKIE = stripslashes_deep($_COOKIE);
		$_REQUEST= stripslashes_deep($_REQUEST);
	}
}