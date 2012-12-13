<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik爱客网 安装程序
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//判断目录可写
$f_cache = iswriteable ( 'cache' );
$f_data = iswriteable ( 'data' );
$f_plugins = iswriteable ( 'plugins' );
$f_uploadfile = iswriteable ( 'uploadfile' );

include 'install/html/index.html';