<?php
defined('IN_IK') or die('Access Denied.');
//简单跳转的函数
function jumpurl($url, $time=1000, $mode='js') {
	if($mode == 'js') {
		echo "<script>
		function redirect() {
		window.location.replace('$url');
	}
	setTimeout('redirect();', $time);
	</script>";
	} else {
	$time = $time/1000;
	echo "<html><head><title></title><meta http-equiv=\"refresh\" content=\"$time;url=$url\"></head><body></body></html>";
	}
	exit;
}
function getrobotmeg($referurl, $robotlevel=2) {
	global $_SCONFIG;
	
	$searchcursory = array(
		"/\<(script|style|textarea)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si",
		"/<\/(html|head|meta|link|body)\>/si",
		"/([\r\n])\s+/",
		"/\<(table|div)[^\>]*?\>/si",
		"/\<\/(table|div)\>/si"
	);
	$replacecursory = array(
		"",
		"",
		"",
		 "\\1",
		"\n\n###table div explode###\n\n",
		"\n\n###table div explode###\n\n"
	);
	$searchaborative = array(
		"/\<(iframe)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<[\/\!]*?[^\<\>]*?\>/si",
		"/\t/",
		"/[\r\n]+/",
		"/(^[\r\n]|[\r\n]$)+/",
		"/&(quot|#34);/i",
		"/&(amp|#38);/i",
		"/&(lt|#60);/i",
		"/&(gt|#62);/i",
		"/&(nbsp|#160|\t);/i",
		"/&(iexcl|#161);/i",
		"/&(cent|#162);/i",
		"/&(pound|#163);/i",
		"/&(copy|#169);/i",
		"/&#(\d+);/e"
	);
	$replaceaborative = array(
		"",
		"",
		"",
		"\n",
		"",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)"
	);
	$arrayrobotmeg = array();

	$sourcehtml = sreadfile($referurl, 'r', 1);	//读取网页
	$sourcecharset = postget('charset');
	if(empty($sourcecharset) && $sourcecharset == ''){
		preg_match_all("/\<meta[^\<\>]+charset=([^\<\>\"\'\s]+)[^\<\>]*\>/i", $sourcehtml, $temp, PREG_SET_ORDER);
		$sourcecharset = isset($temp) && !empty($temp) ? trim(strtoupper($temp[0][1])) : $_SCONFIG['charset'];
	}
	
	$sourcehtml = encodeconvert($sourcecharset, $sourcehtml);

	$sourcetext = getimageurl($referurl, preg_replace($searchcursory, $replacecursory, $sourcehtml));
	if($robotlevel == 1) {
		$leachsubject = '';
		preg_match_all("/\<title[^\>]*?\>(.*)\<\/title\>/is", $sourcetext, $temp, PREG_SET_ORDER);
		$leachsubject = $temp[0][1];
		$sourcetext = preg_replace("/\n\n###table div explode###\n\n/", '', $sourcetext);
		$leachmessage = preg_replace("/[\r\n]+/", '<br />', preg_replace($searchaborative, $replaceaborative, $sourcetext));
	} elseif($robotlevel == 2) {
		$arraysource = explode("\n\n###table div explode###\n\n", $sourcetext);
		
		$arraycell = array();
		foreach($arraysource as $value) {
			$cell = array(
				'code'	=>	$value,
				'text'	=>	preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value)),
				'pr'	=>	0,
				'title'	=>	'',
				'process'	=>''
			);
		
			if($cell['text'] != '') {
				$arraycell[] = getpr($cell, $searchaborative, $replaceaborative);
			}
		}
	
		$arraysubject = $arraymessage = array();
		$leachsubject = $leachmessage = '';
		foreach($arraycell as $value) {
			if($value['title'] == 'title') {
				$arraysubject[] = $value;
			} elseif($value['pr'] >= 0) {
				$arraymessage[] = $value['code'];
			}
		}
	
		$pr = '';
		foreach($arraysubject as $value) {
			if($pr < $value['pr'] || empty($pr)) {
				$leachsubject = $value['text'];
			}
			$pr = $value['pr'];
		}
		
		$leachmessage = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n", implode("\n", $arraymessage));
		$arraymessage = explode("\n", preg_replace($searchaborative, $replaceaborative, $leachmessage));

		$leachmessage = '';
		foreach($arraymessage as $value) {
			if(trim($value) != '') {
				$leachmessage .= "<p>\t" . trim($value) . "</p>";
			}
		}
	}

	$arrayrobotmeg['leachsubject'] = $leachsubject;
	$arrayrobotmeg['leachmessage'] = $leachmessage;
	$arrayrobotmeg['charset'] = $sourcecharset;

	return $arrayrobotmeg;
}

function getimageurl($referurl, $subject) {
	preg_match_all("/<img.+src=('|\"|)?(.*)(\\1)([\s].*)?>/ismUe", $subject, $temp, PREG_SET_ORDER);

	$offset = '';
	$url = $imagereplace = array();
	$posturl = parse_url($referurl);
	if(is_array($temp) && !empty($temp)) {
		foreach($temp as $tempvalue) {
			$url = parse_url(str_replace('\"', '', $tempvalue[2]));
			$imagereplace['oldimageurl'][] = $tempvalue[0];
			if(isset($url['host']) && !empty($url['host'])){
				$imagereplace['newimageurl'][] = '&lt;img src="' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
			} else {
				$offset = strpos($tempvalue[2], '/');
				if(!is_bool($offset) && $offset == 0){
					$imagereplace['newimageurl'][] = '&lt;img src="' . $posturl['scheme'] . '://' . $posturl['host'] . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				} else {
					$imagereplace['newimageurl'][] = '&lt;img src="' . substr($referurl, 0, strrpos($referurl, '/')) . '/' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				}
			}
		}
	}

	return str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $subject);
}

//获得PR值
function getpr($arraycell, $searchaborative, $replaceaborative) {
	$htmltags = array(
		array('title', 5),
		array('a', -1),
		array('iframe', -2),
		array('p', 1),
		array('li', -1),
		array('input', -0.1),
		array('select', -3),
		array('form', -0.1)
	);

	if(strlen($arraycell['text']) > 10) {
		if(strlen($arraycell['text']) > 200) {
			$arraycell['pr'] += 2;
		}

		foreach($htmltags as $tagsvalue) {
			$temp = array();
			preg_match_all("/\<$tagsvalue[0][^\>]*?\>/is", $arraycell['code'], $temp, PREG_SET_ORDER);
			$tagsnum = count($temp);

			$temp = array();
			if($tagsvalue[0] == 'title' && $tagsnum > 0) {
				$arraycell['title'] = 'title';
			} elseif($tagsvalue[0] == 'a' && $tagsnum > 0) {
				preg_match_all("/\<a[^\>]*?\>(.*?)\<\/a>/is", $arraycell['code'], $temp);
				$temp[2] = preg_replace("/[\n\r\s]*?/is", '', preg_replace ($searchaborative, $replaceaborative, implode('', $temp[1])));
				$ahretnum = strlen($temp[2]) / strlen($arraycell['text']);
				$tagsnum *= $ahretnum * 10;
			}

			$arraycell['pr'] += $tagsnum * $tagsvalue[1];
		}
	} else {
		$arraycell['pr'] -= 10;
	}

	if($arraycell['pr'] >= 0) {
		$g1 = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n\n###p br explode###\n\n", $arraycell['code']);
		$arrayg1 = explode("\n\n###p br explode###\n\n", $g1);

		preg_match_all("/\n\n###p br explode###\n\n/is", $g1, $g4, PREG_SET_ORDER);

		if(count($g4) > 2) {
			$g3 = 0;
			foreach($arrayg1 as $value) {
				$g2 = preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value));

				if($g2 != '') {
					$g2num = strlen($g2);
					if($g2num <= 25) {
						$g3--;
					} elseif($g2num > 70 ) {
						$g3 = 10;
						continue;
					}
					else {
						$g3++;
					}
				}
			}
			
			if($g3 < 0) {
				$arraycell['pr'] += $g3;
			}
		}
	}

	return $arraycell;
}

function showrobotmsg($message, $type='error') {
	$message = addcslashes($message, '"');
	
	if(empty($message)) {
		$typestr = 'msg.style.display = "none";
					msgok.style.display = "none";';
	} else {
		if($type == 'ok') {
			$typestr = 'msg.style.display = "none";
						msgok.style.display = "";
						msgok.innerHTML = "'.$message.'";
						';
		} else {
			$typestr = 'msg.style.display = "";
						msgok.style.display = "none";
						msg.innerHTML =  "'.$message.'";
						';
		}
	}

	print <<<END
	<script language="javascript">
	<!--
	var msg = parent.document.getElementById("divshowrobotmsg");
	var msgok = parent.document.getElementById("divshowrobotmsgok");
	var pf = parent.document.getElementById("phpframe");
	pf.src = "about:blank";
	$typestr
	//-->
	</script>
END;
	exit;
}

function getrobotmessage($sourcehtml, $referurl, $robotlevel=1) {
	global $_SCONFIG;
	
	$searchcursory = array(
		"/\<(script|style|textarea)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si",
		"/<\/(html|head|meta|link|body)\>/si",
		"/([\r\n])\s+/",
		"/\<(table|div)[^\>]*?\>/si",
		"/\<\/(table|div)\>/si"
	);
	$replacecursory = array(
		"",
		"",
		"",
		 "\\1",
		"\n\n###table div explode###\n\n",
		"\n\n###table div explode###\n\n"
	);
	$searchaborative = array(
		"/\<(iframe)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<[\/\!]*?[^\<\>]*?\>/si",
		"/\t/",
		"/[\r\n]+/",
		"/(^[\r\n]|[\r\n]$)+/",
		"/&(quot|#34);/i",
		"/&(amp|#38);/i",
		"/&(lt|#60);/i",
		"/&(gt|#62);/i",
		"/&(nbsp|#160|\t);/i",
		"/&(iexcl|#161);/i",
		"/&(cent|#162);/i",
		"/&(pound|#163);/i",
		"/&(copy|#169);/i",
		"/&#(\d+);/e"
	);
	$replaceaborative = array(
		"",
		"",
		"",
		"\n",
		"",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)"
	);
	$arrayrobotmeg = array();
	$sourcetext = replaceimageurl($referurl, preg_replace($searchcursory, $replacecursory, $sourcehtml));

	$arraysource = explode("\n\n###table div explode###\n\n", $sourcetext);
	$arraycell = array();
	foreach($arraysource as $value) {
		$cell = array(
			'code'	=>	$value,
			'text'	=>	preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value)),
			'pr'	=>	0,
			'title'	=>	'',
			'process'	=>''
		);
		if($cell['text'] != '') {
			if($robotlevel == 2) {
				$arraycell[] = getpr($cell, $searchaborative, $replaceaborative);
			} else {
				$arraycell[] = $cell;
			}
		}
	}

	$arraysubject = $arraymessage = array();
	$leachsubject = $leachmessage = '';
	foreach($arraycell as $value) {
		if($value['title'] == 'title') {
			$arraysubject[] = $value;
		} elseif($value['pr'] >= 0) {
			$arraymessage[] = $value['code'];
		}
	}

	$pr = '';
	foreach($arraysubject as $value) {
		if($pr < $value['pr'] || empty($pr)) {
			$leachsubject = $value['text'];
		}
		$pr = $value['pr'];
	}
	$leachmessage = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n", implode("\n", $arraymessage));
	$arraymessage = explode("\n", preg_replace($searchaborative, $replaceaborative, $leachmessage));
	$leachmessage = '';
	foreach($arraymessage as $value) {
		if(trim($value) != '') {
			$leachmessage .= "<p>" . trim($value) . "</p>\n";
		}
	}

	$arrayrobotmeg['leachsubject'] = $leachsubject;
	$arrayrobotmeg['leachmessage'] = $leachmessage;
	return $arrayrobotmeg;
}

function replaceimageurl($referurl, $subject) {
	preg_match_all("/<img.+src=('|\"|)?(.*)(\\1)([\s].*)?>/ismUe", $subject, $temp, PREG_SET_ORDER);

	$offset = '';
	$url = $imagereplace = array();
	$posturl = parse_url($referurl);
	if(is_array($temp) && !empty($temp)) {
		foreach($temp as $tempvalue) {
			$url = parse_url(str_replace('\"', '', $tempvalue[2]));
			$imagereplace['oldimageurl'][] = $tempvalue[0];
			if(isset($url['host']) && !empty($url['host'])){
				$imagereplace['newimageurl'][] = '&lt;img src="' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
			} else {
				$offset = strpos($tempvalue[2], '/');
				if(!is_bool($offset) && $offset == 0){
					$imagereplace['newimageurl'][] = '&lt;img src="' . $posturl['scheme'] . '://' . $posturl['host'] . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				} else {
					$imagereplace['newimageurl'][] = '&lt;img src="' . substr($referurl, 0, strrpos($referurl, '/')) . '/' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				}
			}
		}
	}

	return str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $subject);
}



//br 替换
function striptbr($text) {
	$text = preg_replace("/(\r\n|\r|\n)/s", '*', $text);
	$text = str_replace('**', '*', $text);
	return $text;
}
//FUNCTION
function showprogress($message, $title = 0) {
	if ($title) {
		echo '<div class="progress" style="background-color:#D6E0EF;border: 1px solid #698CC3;color: #F40914;font-weight: bold;margin: 0.5em 0;padding: 0.5em; font-size:12px">' . $message . '</div>';
	} else {
		echo '<div style="line-height:20px; font-size:14px;">'.$message . '</div><br>';
	}
}
function geturlfile($url, $encode=1) {
	global $thevalue, $_SCONFIG;

	$text = '';
	if(!empty($url)) {
		if(function_exists('file_get_contents')) {
			@$text = file_get_contents($url);
		} else {
			@$carr = file($url);
			if(!empty($carr) && is_array($carr)) {
				$text = implode('',$carr);
			}
		}
	}
	$text = str_replace('·', '', $text);
	if(!empty($thevalue['encode']) && $encode == 1) {
		if(function_exists('iconv')) {
			$text = iconv($thevalue['encode'], $_SCONFIG['charset'], $text);
		} else {
			$text = encodeconvert($thevalue['encode'], $text);
		}
	}
	return $text;
}
//转码
function encodeconvert($encode, $content, $to=0) {
	global $_SCONFIG;
	if($to) {
		$in_charset = strtoupper($_SCONFIG['charset']);
		$out_charset = strtoupper($encode);
	} else {
		$in_charset = strtoupper($encode);
		$out_charset = strtoupper($_SCONFIG['charset']);
	}
	if(!empty($encode) && $in_charset != $out_charset) {
		if (function_exists('iconv') && (@$outstr = iconv("$in_charset//IGNORE", "$out_charset//IGNORE", $content))) {
			$content = $outstr;
		} elseif (function_exists('mb_convert_encoding') && (@$outstr = mb_convert_encoding($content, $out_charset, $in_charset))) {
			$content = $outstr;
		}
	}
	return $content;
}


function printruledebug($infoarr) {
	$rule = '';
	if(is_array($infoarr['code'])) {
		$infoarr['code'] = implode("\n", $infoarr['code']);
	}
	if(!empty($infoarr['code'])) {
		showprogress('识别后有内容,区域源码', 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$infoarr['code'].'</textarea>');
	} else {
		showprogress('没识别出任何内容,请检查识别规则', 1);
	}
	$rule = shtmlspecialchars(getregularstring($infoarr['rule'], 'from'));
	showprogress('测试网页地址', 1);
	showprogress('<input type="text" style="width: 95%" value="'.$infoarr['url'].'">');
	showprogress('正则表达式', 1);
	showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
	showprogress('网页源码', 1);
	showprogress('<textarea style="width:95%;" rows="7">'.shtmlspecialchars($infoarr['source']).'</textarea>');
	exit();
}
/**
 * 正则规则
 */
function getregularstring($rule, $getstr) {
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	return $rule;
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
//替换字符串中的特殊字符
//去掉指定字符串中\\或\'前的\
function sstripslashes($string) {

	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = sstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
/**
 * 解析内容
 */
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
//去掉数组中重复值
function sarray_unique($array) {
	$newarray = array();
	if(!empty($array) && is_array($array)) {
		$array = array_unique($array);
		foreach ($array as $value) {
			$newarray[] = $value;
		}
	}
	return $newarray;
}
//去除空格
function strim($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = strim($val);
		}
	} else {
		$string = trim($string);
	}
	return $string;
}
//按规则替换
function stringreplace($replace, $replaceto, $message) {
	if(is_array($replace)) {
		foreach($replace as $key => $val) {
			$message = stringreplace($val, $replaceto[$key], $message);
		}
	} else {
		if(!empty($replace)) {
			$rule = convertrule($replace);
			if(strpos($replaceto, '[string]') === false) {
				$replacestr = $replaceto;
			} else {
				$replacestr = str_replace('[string]', "\${1}", $replaceto);
			}
			$message = preg_replace("/($rule)/s", $replacestr, $message);
		}
	}
	return $message;
}

function sstrtotime($timestamp) {
	global $_SCONFIG;

	$timestamp = trim($timestamp);
	if(empty($timestamp)) return 0;
	$hour = $minute = $second = $month = $day = $year = 0;
	$exparr = $timearr = array();
	if(strpos($timestamp, ' ') !== false && strpos($timestamp, '-') !== false) {
		$timearr = explode(' ', $timestamp);
		$exparr = explode('-', $timearr[0]);
		$year = empty($exparr[0])?0:intval($exparr[0]);
		$month = empty($exparr[1])?0:intval($exparr[1]);
		$day = empty($exparr[2])?0:intval($exparr[2]);
		$exparr = explode(':', $timearr[1]);
		$hour = empty($exparr[0])?0:intval($exparr[0]);
		$minute = empty($exparr[1])?0:intval($exparr[1]);
		$second = empty($exparr[2])?0:intval($exparr[2]);
	} elseif(strpos($timestamp, '-') !== false && strpos($timestamp, ' ') === false) {
		$exparr = explode('-', $timestamp);
		$year = empty($exparr[0])?0:intval($exparr[0]);
		$month = empty($exparr[1])?0:intval($exparr[1]);
		$day = empty($exparr[2])?0:intval($exparr[2]);
	} elseif(!strpos($timestamp, '-') === false && strpos($timestamp, ' ') !== false) {
		$exparr = explode(':', $timestamp);
		$hour = empty($exparr[0])?0:intval($exparr[0]);
		$minute = empty($exparr[1])?0:intval($exparr[1]);
		$second = empty($exparr[2])?0:intval($exparr[2]);
	} else {
		return 0;
	}
	return gmmktime($hour, $minute, $second, $month, $day, $year) - $_SCONFIG['timeoffset'] * 3600;
}

/**
 * 获取或生成采集地址
 */
function cacherobotlist($type, $url, $robotid, $sarray=array(), $varname='newurlarr') {

	$cachefile = IKDATA.'./data/robot/'.$robotid.'_'.md5($url).'.php';
	if($type == 'get') {
		if(file_exists($cachefile)) {
			include_once($cachefile);
			showprogress('列表缓存文件成功读取'.' ('.srealpath($cachefile).')', 1);	//srealpath是格式化URL地址
			return $$varname;
		} else {
			return false;
		}
	} else {
		$wtext = arrayeval($sarray);
		if(!@$fp = fopen($cachefile, 'w')) {
			showprogress('列表缓存文件无法写入'.' ('.srealpath($cachefile).')', 1);	//缓存无法写入
		} else {
			$text = "<?php\n\n";
			$text .= '$'.$varname.'=';
			$text .= $wtext;
			$text .= "\n\n?>";
			flock($fp, 2);
			fwrite($fp, $text);
			fclose($fp);
			showprogress('列表缓存文件成功写入'.' ('.srealpath($cachefile).')', 1);
		}
	}

}
?>