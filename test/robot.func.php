<?php

/*
	[12IK] (C) 2012-2015 12IK.COM
	$Id: robot.func.php 10898 2008-12-31 02:58:50Z charm $
*/

//if(!defined('IN_SUPESITE')) {
//	exit('Access Denied');
//}

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

?>