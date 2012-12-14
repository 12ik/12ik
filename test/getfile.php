<?php
$messagetext = geturlfile('http://127.0.0.1/test/text.html');

$subjectarr = pregmessage($messagetext, '<title>[subject]</title>', 'subject');

$subjecturlarr = pregmessage($messagetext, '<ul>[list]</ul>', 'list');

		

//标题
echo $subjectarr[0].'<br>';
//内容
//print_r($subjecturlarr);

//保存图片
for($i=10; $i<20; $i++)
{
saveremotefile('http://www.met-nude.com/MNPics/MN20121202_Chinese-Nude-JNZYY/img/jnzyy1_('.$i.').jpg',$i);
}

//super site 模式解析器
function pregmessage($message, $rule, $getstr, $limit=1) {
	$result = array('0'=>'');
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	if($limit == 1) {
		preg_match("/$rule/is", $message, $rarr);
		if(!empty($rarr[1])) {
			$result[0] = $rarr[1];
		}
	} else {
		preg_match_all("/$rule/is", $message, $rarr);
		if(!empty($rarr[1])) {
			$result = $rarr[1];
		}
	}
	return $result;
}
/**
 * 转义正则表达式字符串
 */
function convertrule($rule) {
	$rule = preg_quote($rule, "/");		//转义正则表达式
	$rule = str_replace('\*', '.*?', $rule);
	$rule = str_replace('\|', '|', $rule);
	return $rule;
}

function geturlfile($url, $encode=1) {

	$text = '';
	$ch = curl_init();
// set URL and other appropriate options
//CURLOPT_HEADER: 如果你想把一个头包含在输出中，设置这个选项为一个非零值。
//CURLOPT_REFERER: 在HTTP请求中包含一个"referer"头的字符串。
//CURLOPT_PROXY：设置通过的HTTP代理服务器
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$file_contents = curl_exec ( $ch );
	// close curl resource, and free up system resources
	curl_close($ch);
	return $file_contents;
}
//获取文件后缀
//获取文件名后缀
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}
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
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}
//读文件
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


//保存图片到本地
function saveremotefile($url,$name) {

	$patharr = $blank = array('file'=>'', 'thumb'=>'', 'name'=>'', 'type'=>'', 'size'=>0);

	$ext = fileext($url);
	$patharr['type'] = $ext;
	
		//debug 得到存储目录
	//$dirpath = getattachdir();
	//if(!empty($dirpath)) $dirpath .= '/';
	$patharr['file'] = dirname ( __FILE__ ).'/'.$name.'.'.$ext;
	
	$content = sreadfile($url, 'rb', 1, $maxsize);
	writefile($patharr['file'], $content, 'text', 'wb', 0);
	//echo $content;
	if(file_exists($patharr['file']))
	{
		echo $patharr['file'] ;
	}
	
	
/*
	if(in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) {
		$isimage = 1;
	} else {
		$isimage = 0;
		$ext = 'attach';
	}

	//debug 文件名
	if(empty($_SGLOBAL['_num'])) $_SGLOBAL['_num'] = 0;
	$_SGLOBAL['_num'] = intval($_SGLOBAL['_num']);
	$_SGLOBAL['_num']++;
	$filemain = $_SGLOBAL['supe_uid'].'_'.sgmdate($_SGLOBAL['timestamp'], 'YmdHis').$_SGLOBAL['_num'].random(4);
	$patharr['name'] = $filemain.'.'.$ext;
	
	//debug 得到存储目录
	$dirpath = getattachdir();
	if(!empty($dirpath)) $dirpath .= '/';
	$patharr['file'] = $dirpath.$filemain.'.'.$ext;
	
	//debug 上传
	$content = sreadfile($url, 'rb', 1, $maxsize);
	if(empty($content)) return $blank;
	
	writefile(A_DIR.'/'.$patharr['file'], $content, 'text', 'wb', 0);
	if(!file_exists(A_DIR.'/'.$patharr['file'])) return $blank;
	*/

	return $patharr;
}

//写文件
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
			$text = "<?php\r\n\r\nif(!defined('IN_SUPESITE')) exit('Access Denied');\r\n\r\n";
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
