<?php
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

$str = "中嘎嘎嘎http://www.12ik.com";
$pattern='/(http:\/\/|https:\/\/|ftp:\/\/)([\w:\/\.\?=&-_]+)/is';

$signed = hview(preg_replace($pattern, '<a rel="nofollow" target="_blank" href="\1\2">\1\2</a>', $str));
echo h($signed);
