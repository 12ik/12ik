<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('PRC');//设置默认北京时区
echo '北京时间：'.date('Y-m-d H:i:s',time()).'<br/>';
date_default_timezone_set('Hongkong');//设置默认北京时区
echo '香港时间：'.date('Y-m-d H:i:s',time()).'<br/>';

echo '前1天时间：'.date('Y-m-d H:i:s',time()-86400).'<br/>';

$variable = 'work';
echo "My string $variable <br>";//你也可以使用这种方法：
//PHP中文字符串翻转
echo cstrrev("123abc");
function cstrrev($str)
{
	$len = strlen($str);
	for($i = 0; $i < $len; $i++)
	{
		$char = $str{0};
		if(ord($char) > 127)
		{
			$i++;
			if($i < $len)
			{
				$arr[] = substr($str, 0, 2);
				$str = substr($str, 2);
			}
		}
		else
		{
			$arr[] = $char;
			$str = substr($str, 1);
		}
	}
	return join(array_reverse($arr));
}
echo $_SERVER['REMOTE_ADDR']; 
echo getenv('REMOTE_ADDR'); //get environmental  获取环境
echo gethostbyname("www.baidu.com");
