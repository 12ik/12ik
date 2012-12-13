<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
/*
 * 12ik爱客网 安装程序
 * @copyright (c) 2012-3000 12IK All Rights Reserved
 * @author wanglijun
 * @Email:160780470@qq.com
 */

//安装文件的IMG，CSS文件
$skins = 'data/install/skins/';

//进入正题
$title = '12IK-爱客网安装程序';
require_once 'action/' . $install . '.php';