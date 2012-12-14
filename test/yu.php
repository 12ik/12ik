<?php
/*
欢迎光临
上海网站建设
http://www.webqin.net/
if(isset($_POST[domain])){
*/
header('Content-Type: text/html; charset=utf-8');


	/**$con1 = 'http://panda.www.net.cn/cgi-bin/check.cgi?area_domain='.$_POST[domain].$_POST[select].'';**/
	$name ='youao,baiao,boao,bozao,goozao,gmiao,beao,tooao';
	$names = explode(",",$name);
	$len =  count($names);
	$last = ".cn";
	for($i=0; $i<$len; $i++)
	{
		$con1 = 'http://panda.www.net.cn/cgi-bin/check.cgi?area_domain='.$names[$i].$last;
		
		$html = file_get_contents($con1);
		$checked = strpos($html,"Domain name is not available");
			if($checked<>null){
				echo $names[$i].$last.' <span style="color:red">no</span><br/>';
			}else{
				echo $names[$i].$last.' <span style="color:green">ok</span><br/>';
			}
	}

?> 
<!--http://pandavip.www.net.cn/cgi-bin/Check.cgi?url=&queryType=0&sign=2&domain1=qwqw&domain=qwqw&image24.x=35&image24.y=8&com=yes

http://pandavip.www.net.cn/cgi-bin/Check.cgi?url=&queryType=0&sign=2&domain1=qqqqqq&domain=qqqqqq&image24.x=27&image24.y=7&com=yes

http://pandavip.www.net.cn/cgi-bin/Check.cgi?url=&domainlist=abcdefg&domain=abcdefg&sign=1&image2.x=23&image2.y=3&radiobutton=com&com=yes

http://pandavip.www.net.cn/cgi-bin/Check.cgi?url=&domainlist=a%0D%0Ab%0D%0Ac%0D%0Ad&domain=a%2Cb%2Cc%2Cd&sign=1&image2.x=50&image2.y=8&radiobutton=com&com=yes

<form id="form1" name="form1" method="post" action="">
  <label>
    <input name="domain" id="domain" type="text" value="<? echo $_POST[domain]; ?>"/>
  </label>
  <label>
        <select name="select" id="select">
              <option value="<? echo $_POST[select]; ?>" selected="selected"><? echo $_POST[select]; ?></option>
      <option value=".com">.com</option>
      <option value=".net">.net</option>
      <option value=".org">.org</option>
      <option value=".cc">.cc</option>
      <option value=".info">.info</option>
    </select>
  </label>
  <label>
    <input type="submit" name="button" id="button" value="提交" />
  </label>
</form>
-->