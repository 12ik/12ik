<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik爱客网 安装程序
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

$host = trim ( $_POST ['host'] );
$port = trim ( $_POST ['port'] );
$user = trim ( $_POST ['user'] );
$pwd = trim ( $_POST ['pwd'] );
$name = trim ( $_POST ['name'] );
$pre = trim ( $_POST ['pre'] );
$select_sql = trim ( $_POST ['sql'] );

$arrdb = array ('host' => $host, 'port' => $port, 'user' => $user, 'pwd' => $pwd, 'name' => $name, 'pre' => $pre );

//网站信息
$site_title = trim ( $_POST ['site_title'] );
$site_subtitle = trim ( $_POST ['site_subtitle'] );
$site_url = trim ( $_POST ['site_url'] );

//用户信息
$email = trim ( $_POST ['email'] );
$password = trim ( $_POST ['password'] );
$username = trim ( $_POST ['username'] );

if (! preg_match ( "/^[\w_]+_$/", $pre ))
	qiMsg ( "数据表前缀不符合(例如：ik_)" );

if ($site_title == '' || $site_subtitle == '' || $site_url == '')
	qiMsg ( "网站信息不能为空！" );

if ($email == '' || $password == '' || $username == '')
	qiMsg ( "用户信息不能为空！" );

if (valid_email ( $email ) == false)
	qiMsg ( "Email输入有误！" );

include 'core/sql/mysql.php';

$db = new MySql ( $arrdb );

if ($db) {
	
	$sql = file_get_contents ( 'install/data.sql' );
	$sql = str_replace ( 'ik_', $pre, $sql );
	$array_sql = preg_split ( "/;[\r\n]/", $sql );
	
	foreach ( $array_sql as $sql ) {
		$sql = trim ( $sql );
		if ($sql) {
			if (strstr ( $sql, 'CREATE TABLE' )) {
				preg_match ( '/CREATE TABLE ([^ ]*)/', $sql, $matches );
				$ret = $db->query ( $sql );
			} else {
				$ret = $db->query ( $sql );
			}
		}
	}
	
	//存入管理员数据
	$salt = md5 ( rand () );
	
	$userid = $db->query ( "insert into " . $pre . "user (`pwd` , `salt`,`email`) values ('" . md5 ( $salt . $password ) . "', '$salt' ,'$email');" );
	
	$db->query ( "insert into " . $pre . "user_info (`userid`,`username`,`email`,`isadmin`,`addtime`,`uptime`) values ('$userid','$username','$email','1','" . time () . "','" . time () . "')" );
	
	//更改网站信息
	$db->query ( "update " . $pre . "system_options set `optionvalue`='$site_title' where `optionname`='site_title'" );
	$db->query ( "update " . $pre . "system_options set `optionvalue`='$site_subtitle' where `optionname`='site_subtitle'" );
	$db->query ( "update " . $pre . "system_options set `optionvalue`='$site_url' where `optionname`='site_url'" );
	
	$arrOptions = $db->fetch_all_assoc ( "select * from " . $pre . "system_options" );
	foreach ( $arrOptions as $item ) {
		$arrOption [$item ['optionname']] = $item ['optionvalue'];
	}
	
	fileWrite ( 'system_options.php', 'data', $arrOption );
	
	//生成配置文件
	$fp = fopen ( IKDATA . '/config.inc.php', 'w' );
	
	if (! is_writable ( IKDATA . '/config.inc.php' ))
		qiMsg ( "配置文件(data/config.inc.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写" );
	$config = "<?php\n" . "	/*\n" . "	 *数据库配置\n" . "	 */\n" . "	\n" . "	\$IK_DB['sql']='" . $select_sql . "';\n" . "	\$IK_DB['host']='" . $host . "';\n" . "	\$IK_DB['port']='" . $port . "';\n" . "	\$IK_DB['user']='" . $user . "';\n" . "	\$IK_DB['pwd']='" . $pwd . "';\n" . "	\$IK_DB['name']='" . $name . "';\n" . "	\$IK_DB['pre']='" . $pre . "';\n" . "	define('dbprefix','" . $pre . "');\n";
	
	$fw = fwrite ( $fp, $config );
	
	$strUser ['email'] = $email;
	$strUser ['password'] = $password;
	
	include 'install/html/result.html';
} else {
	include 'install/html/error.html';
}