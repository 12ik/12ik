<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?> - <?php echo $IK_APP['options'][appname];?> -
<?php echo $IK_SITE['base'][site_title];?></title>
<link type="text/css" rel="stylesheet"
	href="app/<?php echo $app;?>/skins/<?php echo $skin;?>/style.css" id="skin" />
<style>
body {
	margin: 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
}

.login {
	width: 500px;
	margin: 0 auto;
	background: #3a81c0;
	overflow: hidden;
	margin-top: 100px;
}

.login .logo {
	float: left;
	margin-top: 100px;
	font-size: 14px;
	color: #FFFFFF;
	width: 230px;
	text-align: center;
}

.login .logo a {
	color: #FFFFFF;
	border: none;
	text-decoration: none;
}

.login .logo img {
	border: none;
}

.login .info {
	float: left;
	margin: 50px 0;
}

.login .info a {
	color: #FFFFFF;
	text-decoration: none;
	font-size: 12px;
}

.login .info h1 {
	font-size: 16px;
	color: #FFFFFF;
}

.login .info p {
	font-size: 14px;
	color: #FFFFFF;
}
</style>

</head>
<body>

<div class="login">

<div class="logo"><a href="http://www.12ik.com/" target="_blank">
<img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/logo_login.gif"
	alt="爱客(12IK)社区管理" /> <br />
www.12ik.com </a></div>

<div class="info">
<h1>登录管理后台</h1>
<div>
<form method="post"
	action="<?php echo SITE_URL;?>index.php?app=system&a=login&ik=do">

<p>管理员Email<br />
<input style="width: 200px;" name="email" /></p>
<p>密码<br />
<input style="width: 200px;" type="password" name="pwd" class="uinput" /></p>

<input type="hidden" name="cktime" value="2592000" class="uinput">
<input class="submit" type="submit" value="登录后台" /> <a
	href="<?php echo SITE_URL;?>">返回首页</a></form>
</div>
</div>

</div>


</body>
</html>