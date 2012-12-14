<?php
$messagetext = geturlfile('http://www.12ik.com/12ik/my/text.html');

$subjectarr = pregmessage($messagetext, '<title>[subject]</title>', 'subject');
		

print_r($subjectarr);

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