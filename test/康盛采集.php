<?php

/*
	[SupeSite] (C) 2007-2009 Comsenz Inc.
	$Id: admin_robots.php 13470 2009-11-04 07:19:53Z zhaofei $
*/

//外部访问验证
if(!defined('IN_SUPESITE_ADMINCP')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./function/robot.func.php');
$perpage = 20;
//计算起始记录
empty($_GET['page']) ? $page = 1 : $page = intval($_GET['page']);
($page < 1) ?  $page=1:'';
$start = ($page - 1) * $perpage;

//对于页面标签的点亮样式附件
$addclass = $extclass = $viewclass = $importclass = '';
if (empty($_GET['op'])) {
	$viewclass = ' class="active"';
} elseif ($_GET['op'] == 'add' || $_GET['op'] == 'copy') {
	if(!(checkperm('managemodrobot') || checkperm('manageeditrobot'))) {
		showmessage('no_authority_management_operation');
	}
	$addclass = ' class="active"';
} elseif ($_GET['op'] == 'edit') {
	if(!(checkperm('managemodrobot') || checkperm('manageeditrobot'))) {
		showmessage('no_authority_management_operation');
	}
	$extclass = ' class="active"';
} elseif ($_GET['op'] == 'import' ||  $_GET['op'] == 'export') {
	if(!(checkperm('managemodrobot') || checkperm('manageeditrobot'))) {
		showmessage('no_authority_management_operation');
	}
	$importclass = ' class="active"';
} elseif($_GET['op'] == 'robot') {
	if(!(checkperm('managemodrobot') || checkperm('manageuserobot'))) {
		showmessage('no_authority_management_operation');
	}
} elseif($_GET['op'] == 'delete') {
	if(!(checkperm('managemodrobot') || checkperm('managedelrobot'))) {
		showmessage('no_authority_management_operation');
	}
} else {
	if(!(checkperm('managemodrobot') || checkperm('manageuserobot'))) {
		showmessage('no_authority_management_operation');
	}
}

$listarr = array();
$thevalue = array();
$importvalue = array();

//对页面提交的处理操作
if(submitcheck('importsubmit')) {
	
	//导入采集器的表单提交处理
	$importdata = preg_replace("/(#.*\s+)*/", '', $_POST['importtext']);	//替换采集器中的注释问份
	@$thevalue = unserialize(base64_decode($importdata));	//对采集器编码时行base64解码处理并进行反序列化操作转为可用的数组变量
	//反序列化后，如果结果不是数组，或版本号为空，则报出"机器人配置信息不正确"
	if(!is_array($thevalue) || empty($thevalue['version'])) {
		showmessage('robot_import_data_invalid');
	}
	//对不同版本的采集机器为验证
	if(empty($_POST['ignoreversion']) && strip_tags($thevalue['version']) != strip_tags(S_VER)) {
		showmessage('robot_import_version_invalid');
	}
	//采集器名称为空，则对将当前的时间戳做为采集器文件名
	if(empty($thevalue['name'])) $thevalue['name'] = $_SGLOBAL['timestamp'];
	unset($thevalue['robotid'], $thevalue['version']);	//销毁采集器记录的ID与版本号
	$thevalue = saddslashes($thevalue);		//对值重新addslashes操作
	$insertsqlarr = $thevalue;
	$insertsqlarr['uid'] = $_SGLOBAL['supe_uid'];
	$insertsqlarr['dateline'] = $_SGLOBAL['timestamp'];
	$robotid = inserttable('robots', $insertsqlarr, 1);		//将导入的采集器写入数据库
	updaterobot($robotid);	//更新采集器缓存
	showmessage('robot_import_success', $theurl);
	
} elseif (submitcheck('valuesubmit')) {
	
	//采集器编辑与添加的提交表单的处理
	$postlisturl = addslashes(serialize(array('manual'=>$_POST['listurl_manual'], 'auto'=>$_POST['listurl_auto'])));
	$_POST['autotype'] = !empty($_POST['autotype']) && intval($_POST['autotype']) == 2 ? 2 : 1;
	if(empty($_POST['name'])) $_POST['name'] = $_SGLOBAL['timestamp'];
	$_POST['subjectreplace'] = !empty($_POST['subjectreplace']) ? implode("\n", $_POST['subjectreplace']) : '';
	$_POST['subjectreplaceto'] = !empty($_POST['subjectreplaceto']) ? implode("\n", $_POST['subjectreplaceto']) : '';
	$_POST['messagereplace'] = !empty($_POST['messagereplace']) ? implode("\n", $_POST['messagereplace']) : '';
	$_POST['messagereplaceto'] = !empty($_POST['messagereplaceto']) ? implode("\n", $_POST['messagereplaceto']) : '';
	$catarr = explode('_', $_POST['import']);

	$setsqlarr = array(
		'name' => $_POST['name'],
		'dateline' => $_SGLOBAL['timestamp'],
		'listurltype'=> 'new',
		'listurl' => $postlisturl,
		'listpagestart' => $_POST['listpagestart'],
		'listpageend' => $_POST['listpageend'],
		'allnum' => $_POST['allnum'],
		'pernum' => $_POST['pernum'],
		'importcatid' => intval($catarr[1]),
		'importtype' => $catarr[0],
		'reverseorder' => intval($_POST['reverseorder']),
		'encode' => $_POST['encode'],
		'savepic' => $_POST['savepic'],
		'saveflash' => $_POST['saveflash'],
		'subjecturlrule' => striptbr($_POST['subjecturlrule']),
		'subjecturllinkrule' => striptbr($_POST['subjecturllinkrule']),
		'subjecturllinkpre' => $_POST['subjecturllinkpre'],
		'subjectrule' => striptbr($_POST['subjectrule']),
		'subjectfilter' => striptbr($_POST['subjectfilter']),
		'subjectreplace' => $_POST['subjectreplace'],
		'subjectreplaceto' => $_POST['subjectreplaceto'],
		'subjectkey' => $_POST['subjectkey'],
		'subjectallowrepeat' => $_POST['subjectallowrepeat'],
		'datelinerule' => striptbr($_POST['datelinerule']),
		'fromrule' => striptbr($_POST['fromrule']),
		'authorrule' => striptbr($_POST['authorrule']),
		'messagerule' => striptbr($_POST['messagerule']),
		'messagefilter' => striptbr($_POST['messagefilter']),
		'messagepagetype' => $_POST['messagepagetype'],
		'messagepagerule' => striptbr($_POST['messagepagerule']),
		'messagepageurlrule' => striptbr($_POST['messagepageurlrule']),
		'messagepageurllinkpre' => $_POST['messagepageurllinkpre'],
		'messagereplace' => $_POST['messagereplace'],
		'messagereplaceto' => $_POST['messagereplaceto'],
		'picurllinkpre' => $_POST['picurllinkpre'],
		'autotype' => $_POST['autotype'],
		'wildcardlen' => $_POST['autotype'] == 1 ? $_POST['wildcardlen'] : '',
		'subjecturllinkcancel' => striptbr($_POST['subjecturllinkcancel']),
		'subjecturllinkfilter' => striptbr($_POST['subjecturllinkfilter']),
		'subjecturllinkpf' => $_POST['subjecturllinkpf'],
		'subjectkeycancel' => $_POST['subjectkeycancel'],
		'messagekey' => $_POST['messagekey'],
		'messagekeycancel' => $_POST['messagekeycancel'],
		'messageformat' => $_POST['messageformat'],
		'messagepageurllinkpf' => $_POST['messagepageurllinkpf'],
		'uidrule' => shtmlspecialchars($_POST['uidrule']),
		'defaultdateline' =>  empty($_POST['defaultdateline']) ? 0 : sstrtotime($_POST['defaultdateline'])
	);
	
	//对于新增的采集器与编辑的采集器的分别处理
	if(empty($_POST['robotid'])) {
		$robotid = 0;
		$setsqlarr['uid'] = $_SGLOBAL['supe_uid'];
		$robotid = inserttable('robots', $setsqlarr, 1);
		updaterobot($robotid);	//更新采集器缓存
		showmessage('robot_add_success', $theurl);
	} else {
		//UPDATE
		$wheresqlarr = array(
			'robotid' => $_POST['robotid']
		);
		updatetable('robots', $setsqlarr, $wheresqlarr);
		updaterobot($_POST['robotid']);	//更新采集器缓存
		showmessage('robot_edit_success', $theurl);
	}

} elseif (submitcheck('debug')) {
	
	//采集器编辑调试用
	@ini_set('max_execution_time', 2000);	//设置超时时间
	$_POST['debugprocess'] = !empty($_POST['debugprocess']) ? trim($_POST['debugprocess']) : 0;
	if(empty($_POST['debugprocess'])) {
		showprogress($alang['robot_debug_no_process'], 1);
		exit();
	}
	
	//初始化
	$_POST['listurl_manual'] = !empty($_POST['listurl_manual']) && is_array($_POST['listurl_manual']) ? $_POST['listurl_manual'] : array();
	$_POST['debugurl'] = !empty($_POST['debugurl']) ? trim($_POST['debugurl']) : '';
	
	//start
	$listurlarr = $listurlarr2 = $infoarr = array();		//初始采集页面数组
	$output = '';
	$sourcehtml = '';
	$sourcecharset = '';
	$rule = '';
	$i = $urlorder = 0;
	
	//对采集数组进行整理
	if(empty($_POST['debugurl'])) {
		if(!empty($_POST['listurl_auto'])) {
			$_POST['autotype'] = !empty($_POST['autotype']) && intval($_POST['autotype']) == 2 ? 2 : 1;
			$_POST['listpagestart'] = !empty($_POST['autotype']) && $_POST['autotype'] == 1? intval($_POST['listpagestart']) : ord($_POST['listpagestart']);
			$_POST['listpageend'] = !empty($_POST['autotype']) && $_POST['autotype'] == 1? intval($_POST['listpageend']) : ord($_POST['listpageend']);
			$_POST['wildcardlen'] = !empty($_POST['wildcardlen']) ? intval($_POST['wildcardlen']) : 0;
			if($_POST['listpagestart'] > $_POST['listpageend']) {
				$urlorder = $_POST['listpagestart'];
				$_POST['listpagestart'] = $_POST['listpageend'];
				$_POST['listpageend'] = $urlorder;
				$urlorder = 1;
			}
			for($i = $_POST['listpagestart']; $i <= $_POST['listpageend']; $i++) {
				$strreplace = $i;
				if(!empty($_POST['wildcardlen']) && $_POST['autotype'] == 1) {
					$strreplace = str_pad($i, $_POST['wildcardlen'], 0, STR_PAD_LEFT);
				} elseif($_POST['autotype'] == 2) {
					$strreplace = chr($i);
				}
				if($_POST['autotype'] == 1 || ($_POST['autotype'] == 2 && preg_match("/[a-z]/i", $strreplace))) {
					$listurlarr2[] = preg_replace("/\[page\]/", $strreplace, $_POST['listurl_auto']);
				}
			}
			if($urlorder == 1) krsort($listurlarr2);
		}

		if(!empty($_POST['listurl_manual'])) {
			$listurlarr = $_POST['listurl_manual'];
		}
		if($urlorder == 0) {
			$listurlarr = array_merge($listurlarr, $listurlarr2);
		} else {
			$listurlarr = array_merge($listurlarr2, $listurlarr);
		}
	} else {
		$listurlarr[] = $_POST['debugurl'];
	}

	if(empty($listurlarr)) {
		showprogress($alang['robot_debug_no_link'], 1);
		exit();
	}
	
	if(empty($_POST['debugurl']) || in_array($_POST['debugprocess'], array('showlisturl', 'pinglisturl', 'charset', 'subjecturlrule', 'subjecturllinkrule', 'subjecturllinkcancel', 'subjecturllinkfilter', 'subjecturllinkpre', 'subjecturllinkpf'))) {
		//测试：显示链接
		if($_POST['debugprocess'] == 'showlisturl') {
			showprogress($alang['robot_debug_link_list'], 1);
			if($i >= 1000) {
				showprogress($alang['robot_debug_excessive_list']);
			}
			$output = implode("<br />\n", $listurlarr);
			showprogress($output);
			exit();
		}

		//测试：尝试连接
		if($_POST['debugprocess'] == 'pinglisturl') {
			$i = 0;
			showprogress($alang['robot_debug_link_list'], 1);
			foreach($listurlarr as $tmpvalue) {
				$sourcehtml = geturlfile($tmpvalue, 0);
				if(!empty($sourcehtml)) {
					$output = $alang['robot_debug_connecting_success'];
				} else {
					$output = $alang['robot_debug_unable_to_connect'];
				}
				showprogress($tmpvalue.'--'.$output."\n");
				$i++;
				if($i >= 10) {
					break;
				}
			}
			exit();
		}
		
		//程序识别
		if($_POST['debugprocess'] == 'charset') {
			$sourcehtml = geturlfile($listurlarr[0], 0);	//读取网页
			if(empty($sourcehtml)) {
				showprogress($listurlarr[0].$alang['robot_debug_unable_to_read'], 1);
				exit();
			}
			
			showprogress($alang['robot_debug_pages_encode'], 1);
			preg_match_all("/\<meta[^\<\>]+charset=([^\<\>\"\'\s]+)[^\<\>]*\>/i", $sourcehtml, $temp, PREG_SET_ORDER);
			$sourcecharset = !empty($temp) ? trim(strtoupper($temp[0][1])) : '';
			if(!empty($sourcecharset)) {
				showprogress($alang['robot_debug_pages_encode'].':'.$sourcecharset);
				showprogress($alang['robot_debug_web_site_encode'].$_SCONFIG['charset']);
				showprogress($alang['robot_debug_encode_the_same'], 1);
			} else {
				showprogress($listurlarr[0].$alang['robot_debug_no_recognition']);
			}
			exit();
		}
		
		$sourcecharset = !empty($_POST['encode']) ? trim($_POST['encode']) : '';
		
		if(empty($sourcecharset)) {
			showprogress($alang['robot_debug_encode_not_set'], 1);
		}

		$listurlarr[0] = encodeconvert($sourcecharset, $listurlarr[0], 1);

		$sourcehtml = geturlfile($listurlarr[0], 0);	//读取网页
		if(empty($sourcehtml)) {
			showprogress($listurlarr[0].$alang['robot_debug_unable_to_read'], 1);
			exit();
		}
		
		$sourcehtml = encodeconvert($sourcecharset, $sourcehtml);
		//列表区域识别规则测试
		$_POST['subjecturlrule'] = !empty($_POST['subjecturlrule']) ? sstripslashes(trim($_POST['subjecturlrule'])) : '';
		if(empty($_POST['subjecturlrule'])) {
			showprogress($alang['robot_debug_regional_list_not_set'], 1);
			$subjecturlarr[0] = $sourcehtml;
		} else {
			$subjecturlarr = pregmessage($sourcehtml, $_POST['subjecturlrule'], 'list');	//解析列表区域
		}
		
		if($_POST['debugprocess'] == 'subjecturlrule') {
			$infoarr = array(
				'code'	=>	$subjecturlarr[0],
				'url'	=>	$listurlarr[0],
				'rule'	=>	$_POST['subjecturlrule'],
				'source'	=>	$sourcehtml
			);
			printruledebug($infoarr);
		}	//$subjecturlarr[0]	识别出来的内容
		
		if(empty($subjecturlarr[0])) {
			showprogress($alang['robot_debug_regional_list_not_set_2'], 1);
			exit();
		}
	
		//文章链接URL识别规则
		$_POST['subjecturllinkrule'] = !empty($_POST['subjecturllinkrule']) ? sstripslashes(trim($_POST['subjecturllinkrule'])) : '';
		$newurlarr = array();
		if(empty($_POST['subjecturllinkrule'])) {
			showprogress($alang['robot_debug_subject_url_not_set'], 1);
			$subjecturlarr[0] = preg_replace(array("/[\n\r]+/", "/\<\/a\>/i", "/\<a/i") , array('', "</a>\n", "\n<a"), $subjecturlarr[0]);
			preg_match_all("/\<a.+href=('|\"|)?([^\s\<\>]*)(\\1)([\s].*)?\>(.*)\<\/a\>/i", $subjecturlarr[0], $ahreftemp);
			$newurlarr = sarray_unique($ahreftemp[2]);	//去重
		} else {
			$urlarr = pregmessage($subjecturlarr[0], $_POST['subjecturllinkrule'], 'url', -1);		//解析上步过虑后的结果
			$newurlarr = sarray_unique($urlarr);	//去重
		}

		if($_POST['debugprocess'] == 'subjecturllinkrule') {
			$infoarr = array(
				'code'	=>	$newurlarr,
				'url'	=>	$listurlarr[0],
				'rule'	=>	$_POST['subjecturllinkrule'],
				'source'	=>	$subjecturlarr[0]
			);
			printruledebug($infoarr);
		}	//$newurlarr 链接数组
		if(empty($newurlarr)) {
			showprogress($alang['robot_debug_subject_url_not_set_2'], 1);
			exit();
		}
		
		//文章链接URL剔除规则
		$_POST['subjecturllinkcancel'] = !empty($_POST['subjecturllinkcancel']) ? sstripslashes(trim($_POST['subjecturllinkcancel'])) : '';
		if($_POST['debugprocess'] == 'subjecturllinkcancel') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subject_url_cancel_0'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		if(!empty($_POST['subjecturllinkcancel'])) {
			$urlarr = $newurlarr;
			$newurlarr = array();
			$rule = '('.convertrule($_POST['subjecturllinkcancel']).')';
			foreach($urlarr as $tmpvalue) {
				if(!preg_match("/$rule/i", $tmpvalue)) {
					$newurlarr[] = $tmpvalue;
				}
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkcancel') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subject_url_cancel_1'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['subjecturllinkcancel']).')');
			showprogress($alang['robot_debug_regular'], 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$newurlarr 链接数组
		if(empty($newurlarr)) {
			showprogress($alang['robot_debug_url_cancel_no_link'], 1);
			exit();
		}
		
		//文章链接URL过滤规则
		$_POST['subjecturllinkfilter'] = !empty($_POST['subjecturllinkfilter']) ? sstripslashes(trim($_POST['subjecturllinkfilter'])) : '';
		if($_POST['debugprocess'] == 'subjecturllinkfilter') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subject_url_filter_0'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		if(!empty($_POST['subjecturllinkfilter'])) {
			$urlarr = $newurlarr;
			$newurlarr = array();
			$rule = '('.convertrule($_POST['subjecturllinkfilter']).')';
			foreach($urlarr as $tmpvalue) {
				$newurlarr[] = trim(preg_replace("/$rule/s", '', $tmpvalue));
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkfilter') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subject_url_filter_1'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['subjecturllinkfilter']).')');
			showprogress($alang['robot_debug_regular'], 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$newurlarr 链接数组
		if(empty($newurlarr)) {
			showprogress($alang['robot_debug_subject_url_filter_no_link'], 1);
			exit();
		}
		
		//文章链接URL补充前缀
		if($_POST['debugprocess'] == 'subjecturllinkpre') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subjecturllinkpre_0'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['subjecturllinkpre'] = !empty($_POST['subjecturllinkpre']) ? sstripslashes(trim($_POST['subjecturllinkpre'])) : '';
		if(!empty($_POST['subjecturllinkpre'])) {
			foreach ($newurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					if(strpos($tmpvalue, '://') === false) {
						$newurlarr[$tmpkey] = $_POST['subjecturllinkpre'].$tmpvalue;
					} elseif(strpos($tmpvalue, '://')>10) {
						$newurlarr[$tmpkey] = $_POST['subjecturllinkpre'].$tmpvalue;
					}
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($listurlarr[0]);
			foreach ($newurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					$url = parse_url($tmpvalue);
					if(!empty($url['host'])){
						$newurlarr[$tmpkey] = $tmpvalue;
					} else {
						$offset = strpos($tmpvalue, '/');
						if(!is_bool($offset) && $offset == 0){
							$newurlarr[$tmpkey] = $posturl['scheme'].'://'.$posturl['host'].$tmpvalue;
						} else {
							$newurlarr[$tmpkey] = substr($listurlarr[0], 0, strrpos($listurlarr[0], '/')).'/'.$tmpvalue;
						}
					}
				}
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkpre') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subjecturllinkpre_1'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$newurlarr 链接数组
		
		//文章链接URL补充后缀
		if($_POST['debugprocess'] == 'subjecturllinkpf') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subjecturllinkpf_0'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['subjecturllinkpf'] = !empty($_POST['subjecturllinkpf']) ? sstripslashes(trim($_POST['subjecturllinkpf'])) : '';
		if(!empty($_POST['subjecturllinkpf'])) {
			foreach ($newurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					$newurlarr[$tmpkey] = $tmpvalue.$_POST['subjecturllinkpf'];
				}
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkpf') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress($alang['robot_debug_subjecturllinkpf_1'], 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$newurlarr 链接数组
		
	} else {
		$newurlarr[0] = $_POST['debugurl'];
	}

	foreach($newurlarr as $key => $value) {
		if(empty($value)) {
			continue;
		} else {
			$newurlarr[0] = $value;
			break;
		}
	}

	//读取第一篇文章
	$messagemsgtext = '';
	$newurlarr[0] = encodeconvert($sourcecharset, $newurlarr[0], 1);
	$messagemsgtext = geturlfile($newurlarr[0], 0);	//读取网页
	$messagemsgtext = encodeconvert($sourcecharset, $messagemsgtext);
	if(empty($messagemsgtext)) {
		showprogress($alang['robot_debug_unable_to_read'].' '.$newurlarr[0], 1);
		exit();
	}
	
	//文章标题识别规则
	$_POST['subjectrule'] = !empty($_POST['subjectrule']) ? sstripslashes(trim($_POST['subjectrule'])) : '';
	if(empty($_POST['subjectrule'])) {
		showprogress($alang['robot_debug_subjectrule_no_set_0'], 1);
		exit();
	}
	$subjectarr = array();
	$subjectarr = pregmessage($messagemsgtext, $_POST['subjectrule'], 'subject');
	if($_POST['debugprocess'] == 'subjectrule') {
		$infoarr = array(
			'code'	=>	$subjectarr[0],
			'url'	=>	$newurlarr[0],
			'rule'	=>	$_POST['subjectrule'],
			'source'	=>	$messagemsgtext
		);
		printruledebug($infoarr);
	}	//$subjectarr[0]	识别出来的标题
	
	if(empty($subjectarr[0])) {
		showprogress($alang['robot_debug_subjectrule_no_set_1'], 1);
		exit();
	}	//$subjectarr[0] 标题
	
	//文章标题过滤规则
	$_POST['subjectfilter'] = !empty($_POST['subjectfilter']) ? sstripslashes(trim($_POST['subjectfilter'])) : '';
	if(!empty($_POST['subjectfilter'])) {
		$rule = '('.convertrule($_POST['subjectfilter']).')';
		$subjectarr[0] = trim(preg_replace("/$rule/s", '', $subjectarr[0]));
	}

	if($_POST['debugprocess'] == 'subjectfilter') {
		showprogress($alang['robot_debug_subjectfilter_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
		$rule = shtmlspecialchars('('.convertrule($_POST['subjectfilter']).')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//$subjectarr[0] 标题
	
	if(empty($subjectarr[0])) {
		showprogress($alang['robot_debug_subjectfilter_1'], 1);
		exit();
	}

	//文章标题文字替换
	if($_POST['debugprocess'] == 'subjectreplace') {
		showprogress($alang['robot_debug_subjectreplace_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
	}
	$_POST['subjectreplace'] = !empty($_POST['subjectreplace']) ? sstripslashes(strim($_POST['subjectreplace'])) : '';
	$_POST['subjectreplaceto'] = !empty($_POST['subjectreplaceto']) ? sstripslashes(strim($_POST['subjectreplaceto'])) : '';
	if(!empty($_POST['subjectreplace'])) {
		$subjectarr[0] = stringreplace($_POST['subjectreplace'], $_POST['subjectreplaceto'], $subjectarr[0]);
	}
	if($_POST['debugprocess'] == 'subjectreplace') {
		showprogress($alang['robot_debug_subjectreplace_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
		exit();
	}	//$subjectarr[0] 标题
	
	//文章标题包含关键字
	$_POST['subjectkey'] = !empty($_POST['subjectkey']) ? sstripslashes(trim($_POST['subjectkey'])) : '';
	if($_POST['debugprocess'] == 'subjectkey') {
		$newsubject = '';
		showprogress($alang['robot_debug_subject'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
		$rule = convertrule($_POST['subjectkey']);
		$newsubject = preg_replace("/($rule)/s", '', $subjectarr[0]);
		if($newsubject == $subjectarr[0]) {
			showprogress($alang['robot_debug_subjectkey_0'], 1);
		} else {
			showprogress($alang['robot_debug_subjectkey_1'], 1);
		}
		$rule = shtmlspecialchars('('.$rule.')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//$subjectarr[0] 标题
	
	//文章标题关键字剔除过滤
	$_POST['subjectkeycancel'] = !empty($_POST['subjectkeycancel']) ? sstripslashes(trim($_POST['subjectkeycancel'])) : '';
	if($_POST['debugprocess'] == 'subjectkeycancel') {
		$newsubject = '';
		showprogress($alang['robot_debug_subject'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
		$rule = convertrule($_POST['subjectkeycancel']);
		$newsubject = preg_replace("/($rule)/s", '', $subjectarr[0]);
		if($newsubject == $subjectarr[0]) {
			showprogress($alang['robot_debug_subjectkeycancel_0'], 1);
		} else {
			showprogress($alang['robot_debug_subjectkeycancel_1'], 1);
		}
		$rule = shtmlspecialchars('('.$rule.')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//$subjectarr[0] 标题
	
	//标题结束
	//内容开始
	//文章内容识别规则
	$messagearr = array();
	$_POST['messagerule'] = !empty($_POST['messagerule']) ? sstripslashes(trim($_POST['messagerule'])) : '';
	if(empty($_POST['messagerule'])) {
		showprogress($alang['robot_debug_messagerule_0'], 1);
		$rsmessagearr = getrobotmessage($messagemsgtext, $newurlarr[0], 2);
		$messagearr[0] = $rsmessagearr['leachmessage'];
	} else {
		$messagearr = pregmessage($messagemsgtext, $_POST['messagerule'], 'message');
	}
	if($_POST['debugprocess'] == 'messagerule') {
		$infoarr = array(
			'code'	=>	$messagearr[0],
			'url'	=>	$newurlarr[0],
			'rule'	=>	$_POST['messagerule'],
			'source'	=>	$messagemsgtext
		);
		printruledebug($infoarr);
		//$messagearr[0]	识别出来的文章内容
	}
	if(empty($messagearr[0])) {
		showprogress($alang['robot_debug_messagerule_1'], 1);
		exit();
	}

	//文章内容过滤规则
	if($_POST['debugprocess'] == 'messagefilter') {
		showprogress($alang['robot_debug_messagefilter_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		$rule = shtmlspecialchars('('.convertrule($_POST['messagefilter']).')');
	}
	$_POST['messagefilter'] = !empty($_POST['messagefilter']) ? sstripslashes(trim($_POST['messagefilter'])) : '';
	if(!empty($_POST['messagefilter'])) {
		$rule = '('.convertrule($_POST['messagefilter']).')';
		$messagearr[0] = trim(preg_replace("/$rule/s", '', $messagearr[0]));
	}
	if($_POST['debugprocess'] == 'messagefilter') {
		showprogress($alang['robot_debug_messagefilter_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		$rule = shtmlspecialchars('('.convertrule($_POST['messagefilter']).')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//messagefilter[0] 内容
	if(empty($messagearr[0])) {
		showprogress($alang['robot_debug_messagefilter_2'], 1);
		exit();
	}

	//文章内容文字替换
	if($_POST['debugprocess'] == 'messagereplace') {
		showprogress($alang['robot_debug_messagereplace_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
	}
	$_POST['messagereplace'] = !empty($_POST['messagereplace']) ? sstripslashes(strim($_POST['messagereplace'])) : '';
	$_POST['messagereplaceto'] = !empty($_POST['messagereplaceto']) ? sstripslashes(strim($_POST['messagereplaceto'])) : '';
	if(!empty($_POST['subjectreplace'])) {
		$messagearr[0] = stringreplace($_POST['messagereplace'], $_POST['messagereplaceto'], $messagearr[0]);
	}
	if($_POST['debugprocess'] == 'messagereplace') {
		showprogress($alang['robot_debug_messagereplace_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		exit();
	}	//$messagearr[0] 标题

	//文章内容包含关键字
	$_POST['messagekey'] = !empty($_POST['messagekey']) ? sstripslashes(trim($_POST['messagekey'])) : '';
	if($_POST['debugprocess'] == 'messagekey') {
		$newsubject = '';
		showprogress($alang['robot_debug_message'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		$rule = convertrule($_POST['messagekey']);
		$newmessage = preg_replace("/($rule)/s", '', $messagearr[0]);
		if($newmessage == $messagearr[0]) {
			showprogress($alang['robot_debug_messagekey_0'], 1);
		} else {
			showprogress($alang['robot_debug_messagekey_1'], 1);
		}
		$rule = shtmlspecialchars('('.$rule.')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//$messagearr[0] 标题
	
	//文章内容关键字剔除过滤
	$_POST['messagekeycancel'] = !empty($_POST['messagekeycancel']) ? sstripslashes(trim($_POST['messagekeycancel'])) : '';
	if($_POST['debugprocess'] == 'messagekeycancel') {
		$newsubject = '';
		showprogress($alang['robot_debug_message'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		$rule = convertrule($_POST['messagekeycancel']);
		$newmessage = preg_replace("/($rule)/s", '', $messagearr[0]);
		if($newmessage == $messagearr[0]) {
			showprogress($alang['robot_debug_messagekeycancel_0'], 1);
		} else {
			showprogress($alang['robot_debug_messagekeycancel_1'], 1);
		}
		$rule = shtmlspecialchars('('.$rule.')');
		showprogress($alang['robot_debug_regular'], 1);
		showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
		exit();
	}	//$subjectarr[0] 标题
	
	//文章内容格式化
	$_POST['messageformat'] = !empty($_POST['messageformat']) ? intval($_POST['messageformat']) : 0;
	if($_POST['debugprocess'] == 'messageformat') {
		showprogress($alang['robot_debug_messageformat_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
	}
	if(!empty($_POST['messageformat'])) {
		$rsmessagearr = getrobotmessage($messagearr[0], $newurlarr[0]);
		$messagearr[0] = $rsmessagearr['leachmessage'];
	}
	if($_POST['debugprocess'] == 'messageformat') {
		showprogress($alang['robot_debug_messageformat_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		exit();
	}
	
	//文章内容分页区域识别规则
	$messagepagearr = array();
	$_POST['messagepagerule'] = !empty($_POST['messagepagerule']) ? sstripslashes(trim($_POST['messagepagerule'])) : '';
	if(!empty($_POST['messagepagerule'])) {
		$messagepagearr = pregmessage($messagemsgtext, $_POST['messagepagerule'], 'pagearea');
	}
	if($_POST['debugprocess'] == 'messagepagerule') {
		$infoarr = array(
			'code'	=>	$messagepagearr[0],
			'url'	=>	$newurlarr[0],
			'rule'	=>	$_POST['messagepagerule'],
			'source'	=>	$messagemsgtext
		);
		printruledebug($infoarr);
	}	//$messagepagearr[0]	识别出来的文章内容分页区域
	
	//文章内容分页链接识别规则
	$pageurlarr = array();
	$_POST['messagepageurlrule'] = !empty($_POST['messagepageurlrule']) ? sstripslashes(trim($_POST['messagepageurlrule'])) : '';
	if(!empty($_POST['messagepageurlrule'])) {
		$urlarr = pregmessage($messagepagearr[0], $_POST['messagepageurlrule'], 'page', -1);		//解析上步过虑后的结果
		$pageurlarr = sarray_unique($urlarr);	//去重
	}
	if($_POST['debugprocess'] == 'messagepageurlrule') {
		$infoarr = array(
			'code'	=>	$pageurlarr,
			'url'	=>	$newurlarr[0],
			'rule'	=>	$_POST['messagepageurlrule'],
			'source'	=>	$messagepagearr[0]
		);
		printruledebug($infoarr);
	}	//$pageurlarr 链接数组
	
	//文章内容分页链接URL补充前缀
	if($_POST['debugprocess'] == 'messagepageurllinkpre') {
		$newurlarrtmp = implode("\n", $pageurlarr);
		showprogress($alang['robot_debug_messagepageurllinkpre_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
	}
	$_POST['messagepageurllinkpre'] = !empty($_POST['messagepageurllinkpre']) ? sstripslashes(trim($_POST['messagepageurllinkpre'])) : '';
	if(!empty($_POST['messagepageurllinkpre'])) {
		foreach ($pageurlarr as $tmpkey => $tmpvalue) {
			if(!empty($tmpvalue)) {
				if(strpos($tmpvalue, '://') === false) {
					$pageurlarr[$tmpkey] = $_POST['messagepageurllinkpre'].$tmpvalue;
				} elseif(strpos($tmpvalue, '://')>10) {
					$pageurlarr[$tmpkey] = $_POST['messagepageurllinkpre'].$tmpvalue;
				}
			}
		}
	} else {
		$url = array();
		$posturl = parse_url($newurlarr[0]);
		foreach ($pageurlarr as $tmpkey => $tmpvalue) {
			if(!empty($tmpvalue)) {
				$url = parse_url($tmpvalue);
				if(!empty($url['host'])){
					$pageurlarr[$tmpkey] = $tmpvalue;
				} else {
					$offset = strpos($tmpvalue, '/');
					if(!is_bool($offset) && $offset == 0){
						$pageurlarr[$tmpkey] = $posturl['scheme'].'://'.$posturl['host'].$tmpvalue;
					} else {
						$pageurlarr[$tmpkey] = substr($newurlarr[0], 0, strrpos($newurlarr[0], '/')).'/'.$tmpvalue;
					}
				}
			}
		}
	}
	if($_POST['debugprocess'] == 'messagepageurllinkpre') {
		$newurlarrtmp = implode("\n", $pageurlarr);
		showprogress($alang['robot_debug_messagepageurllinkpre_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		exit();
	}	//$pageurlarr 链接数组
	
	//文章内容分页链接URL补充后缀
	if($_POST['debugprocess'] == 'messagepageurllinkpf') {
		$newurlarrtmp = implode("\n", $pageurlarr);
		showprogress($alang['robot_debug_messagepageurllinkpf_0'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
	}
	$_POST['messagepageurllinkpf'] = !empty($_POST['messagepageurllinkpf']) ? sstripslashes(trim($_POST['messagepageurllinkpf'])) : '';
	if(!empty($_POST['messagepageurllinkpf'])) {
		foreach ($pageurlarr as $tmpkey => $tmpvalue) {
			if(!empty($tmpvalue)) {
				$pageurlarr[$tmpkey] = $tmpvalue.$_POST['messagepageurllinkpf'];
			}
		}
	}
	if($_POST['debugprocess'] == 'messagepageurllinkpf') {
		$newurlarrtmp = implode("\n", $pageurlarr);
		showprogress($alang['robot_debug_messagepageurllinkpf_1'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		exit();
	}	//$pageurlarr 链接数组
	
	//其他开始
	//信息来源识别规则
	if($_POST['debugprocess'] == 'fromrule') {
		$_POST['fromrule'] = !empty($_POST['fromrule']) ? sstripslashes(trim($_POST['fromrule'])) : '';
		if(empty($_POST['fromrule'])) {
			showprogress($alang['robot_debug_fromrule_0'], 1);
			exit();
		}
		$fromarr = array();
		if(preg_match("/\[from\]/", $_POST['fromrule'])) {
			$fromarr = pregmessage($messagemsgtext, $_POST['fromrule'], 'from');
		} else {
			$fromarr[0] = $_POST['fromrule'];
		}

		if(preg_match("/\[from\]/", $_POST['fromrule'])) {
			$infoarr = array(
				'code'	=>	$fromarr[0],
				'url'	=>	$newurlarr[0],
				'rule'	=>	$_POST['fromrule'],
				'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
		} else {
			showprogress($alang['robot_debug_fromrule_1'], 1);
			showprogress(shtmlspecialchars($fromarr[0]));
		}
		//$fromarr[0]	识别出来的来源
	}
	
	//作者识别规则
	if($_POST['debugprocess'] == 'authorrule') {
		$_POST['authorrule'] = !empty($_POST['authorrule']) ? sstripslashes(trim($_POST['authorrule'])) : '';
		if(empty($_POST['authorrule'])) {
			showprogress($alang['robot_debug_authorrule_0'], 1);
			exit();
		}
		$authorarr = array();
		if(preg_match("/\[author\]/", $_POST['authorrule'])) {
			$authorarr = pregmessage($messagemsgtext, $_POST['authorrule'], 'author');
		} else {
			$tmpauthorrule = explode('|', $_POST['authorrule']);
			$tmpauthorrule = strim($tmpauthorrule);
			if(is_array($tmpauthorrule)) {
				foreach($tmpauthorrule as $tmpkey => $tmpvalue) {
					if(empty($tmpvalue)) {
						unset($tmpauthorrule[$tmpkey]);
					}
				}
				$tmprand = 0;
				$tmprand = rand(0, count($tmpauthorrule)-1);
				$authorarr[0] = $tmpauthorrule[$tmprand];
			} else {
				$authorarr[0] = $tmpauthorrule;
			}
		}
		if(preg_match("/\[author\]/", $_POST['authorrule'])) {
			$infoarr = array(
				'code'	=>	$authorarr[0],
				'url'	=>	$newurlarr[0],
				'rule'	=>	$_POST['authorrule'],
				'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
		} else {
			showprogress($alang['robot_debug_authorrule_1'], 1);
			showprogress(shtmlspecialchars($authorarr[0]));
		}
		//$authorarr[0]	识别出来的作者
	}
	
	//发布者UID
	if($_POST['debugprocess'] == 'uidrule') {
		$_POST['uidrule'] = !empty($_POST['uidrule']) ? sstripslashes(trim($_POST['uidrule'])) : '';
		if(empty($_POST['uidrule'])) {
			showprogress($alang['robot_debug_uidrule_0'], 1);
			exit();
		}
		$uidarr = array();
		$tmpuidrule = explode('|', $_POST['uidrule']);
		$tmpuidrule = strim($tmpuidrule);
		if(is_array($tmpuidrule)) {
			foreach($tmpuidrule as $tmpkey => $tmpvalue) {
				if(empty($tmpvalue)) {
					unset($tmpuidrule[$tmpkey]);
				}
			}
			$tmprand = 0;
			$tmprand = rand(0, count($tmpuidrule)-1);
			$uidarr[0] = $tmpuidrule[$tmprand];
		} else {
			$uidarr[0] = $tmpuidrule;
		}
		showprogress($alang['robot_debug_uidrule_1'], 1);
		showprogress(shtmlspecialchars($uidarr[0]));
	}

	exit();
}

//输入页面标签
echo '
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>'.$alang['robot_title'].'</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
				<tr>
					<td'.$viewclass.'><a href="'.$theurl.'" class="view">'.$alang['robot_view_list'].'</a></td>
					<td'.$addclass.'><a href="'.$theurl.'&op=add" class="add">'.$alang['robot_add'].'</a></td>
					<td'.$importclass.'><a href="'.$theurl.'&op=import" class="other">'.$alang['robot_robot_import'].'</a></td>
';
if($_GET['op'] == 'robot') echo '<td><a href="admincp.php?action=robots">'.$alang['robot_progress_stop'].'</a></td>';
echo '
				</tr>
			</table>
		</td>
	</tr>
</table>
';

//GET METHOD
if (empty($_GET['op'])) {
	
	//op为空时，则表示采集器的列表操作
	$query = $_SGLOBAL['db']->query('SELECT COUNT(*) FROM '.tname('robots'));
	$listcount = $_SGLOBAL['db']->result($query, 0);
	$multipage = '';
	if($listcount) {
		$plussql = 'ORDER BY lasttime DESC LIMIT '.$start.','.$perpage;
		$listarr = selecttable('robots', array(), array(), $plussql);	//取出给定条件的采集器列表记录
		$multipage = multi($listcount, $perpage, $page, $theurl);	//分页处理
	}
	
} elseif ($_GET['op'] == 'edit' || $_GET['op'] == 'copy') {

	//编辑采集器初始值
	$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('robots').' WHERE robotid=\''.$_GET['robotid'].'\'');
	if($thevalue = $_SGLOBAL['db']->fetch_array($query)) {
		$thevalue['listurl_manual'] = $thevalue['listurl_auto'] = '';
		if($thevalue['listurltype'] == 'auto') {
			$thevalue['listurl_auto'] = $thevalue['listurl'];
		} elseif($thevalue['listurltype'] == 'manual') {
			$thevalue['listurl_manual'] = explode("\n", preg_replace("/\n+/", "\n", preg_replace("/(\r\n|\r|\n)/s", "\n", $thevalue['listurl'])));
		} elseif($thevalue['listurltype'] == 'extraction') {
			$thevalue['listurl_manual'] = unserialize($thevalue['listurl']);
		} elseif($thevalue['listurltype'] == 'new') {
			$thevalue['listurl'] = unserialize($thevalue['listurl']);
			$thevalue['listurl_manual'] = $thevalue['listurl']['manual'];
			$thevalue['listurl_auto'] = $thevalue['listurl']['auto'];
		}
		$thevalue['listurl'] = '';
		$thevalue['defaultdateline'] = sgmdate($thevalue['defaultdateline']);
		if(!empty($thevalue['listurl_manual'])) {
			foreach($thevalue['listurl_manual'] as $tmpkey => $tmpvalue) {
				$tmpvalue = trim($tmpvalue);
				if(!empty($tmpvalue)) {
					$thevalue['listurl'] .= <<<EOF
							<div id="url_s$tmpkey">
							$tmpvalue
							<a href="javascript:;" onclick="delitem('s$tmpkey');">$alang[robot_delete]</a>
							<input id="listurl_manual[]" type="text" name="listurl_manual[]" size="5" style="display: none;" value="$tmpvalue"/>
							</div>
EOF;
				}
			}
		}
		$thevalue['listurl_manual'] = $thevalue['listurl'];
		$thevalue['subjectreplace'] = explode("\n", $thevalue['subjectreplace']);
		$thevalue['subjectreplaceto'] = explode("\n", $thevalue['subjectreplaceto']);
		$thevalue['messagereplace'] = explode("\n", $thevalue['messagereplace']);
		$thevalue['messagereplaceto'] = explode("\n", $thevalue['messagereplaceto']);
		if ($_GET['op'] == 'copy') {	//复制采集器的初始值
			$thevalue['robotid'] = 0;
		}

	} else {
		showmessage('robot_robotid_no_exists');
	}
	
} elseif ($_GET['op'] == 'add') {
	
	//添加新采集器初始值
	$thevalue = array(
		'robotid' => '0',
		'name' => '',
		'encode' => '',
		'reverseorder' => '0',
		'listurltype'=>'new',
		'listurl' => '',
		'listpagestart' => '0',
		'listpageend' => '0',
		'allnum' => '100',
		'pernum' => '1',
		'savepic' => '0',
		'saveflash' => '0',
		'subjecturlrule' => '',
		'subjecturllinkrule' => '',
		'subjecturllinkpre' => '',
		'subjectrule' => '',
		'subjectfilter' => '',
		'subjectreplace' => '',
		'subjectreplaceto' => '',
		'subjectkey' => '',
		'datelinerule' => '',
		'fromrule' => '',
		'authorrule' => '',
		'messagerule' => '',
		'messagefilter' => '',
		'messagepagetype' => 'page',
		'messagepagerule' => '',
		'messagepageurlrule' => '',
		'messagereplace' => '',
		'messagereplaceto' => '',
		'picurllinkpre' => '',
		'messagepageurllinkpre' => '',
		'subjectallowrepeat' => '1',
		'autotype' => '1',
		'wildcardlen' => '0',
		'subjecturllinkcancel' => '',
		'subjecturllinkfilter' => '',
		'subjecturllinkpf' => '',
		'subjectkeycancel' => '',
		'messagekey' => '',
		'messagekeycancel' => '',
		'messageformat' => '1',
		'messagepageurllinkpf' => '',
		'uidrule' => '',
		'listurl_auto' => '',
		'listurl_manual' => '',
		'defaultdateline' => ''
	);
		
} elseif($_GET['op'] == 'delete') {

	//删除采集器处理
	$_SGLOBAL['db']->query('DELETE FROM '.tname('robots').' WHERE robotid=\''.$_GET['robotid'].'\'');
	if($_SGLOBAL['db']->affected_rows()) {
		delrobotmsg($_GET['robotid']);
		$cachefile = S_ROOT.'./data/robot/robot_'.$_GET['robotid'].'.cache.php';
		if(file_exists($cachefile)) {
			@unlink($cachefile);
		}
	}
	showmessage('robot_delete_success', $theurl);

} elseif($_GET['op'] == 'clearcache') {

	clearrobotcache($_GET['robotid']);
	showmessage('robot_clearcache_success', $theurl);

} elseif($_GET['op'] == 'robot') {
	
	//采集处理
	@ini_set('max_execution_time', 2000);	//设置超时时间

	empty($_GET['lpage'])?$lpage=0:$lpage=$_GET['lpage'];	//列表页的页数
	empty($_GET['mpage'])?$mpage=0:$mpage=$_GET['mpage'];	//页面的分页数
	empty($_GET['mnum'])?$mnum=0:$mnum=$_GET['mnum'];	//当前页面分页数
	empty($_GET['status'])?$status=0:$status=$_GET['status'];	//当次采集个数

	//ONE VIEW FOR UPDATE
	$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('robots').' WHERE robotid=\''.$_GET['robotid'].'\'');
	if($thevalue = $_SGLOBAL['db']->fetch_array($query)) {
	} else {
		showmessage('robot_robotid_no_exists');
	}
	
	showprogress($alang['robot_robot_start'], 1);

	$listurlarr = $listurlarr2 = array();		//初始采集页面数组
	//对采集数组进行整理
	$thevalue['listurl_manual'] = $thevalue['listurl_auto'] = '';
	if($thevalue['listurltype'] == 'auto') {
		$thevalue['listurl_auto'] = $thevalue['listurl'];
	} elseif($thevalue['listurltype'] == 'manual') {
		$thevalue['listurl_manual'] = explode("\n", preg_replace("/\n+/", "\n", preg_replace("/(\r\n|\r|\n)/s", "\n", $thevalue['listurl'])));
	} elseif($thevalue['listurltype'] == 'extraction') {
		$thevalue['listurl_manual'] = unserialize($thevalue['listurl']);
	} elseif($thevalue['listurltype'] == 'new') {
		$thevalue['listurl'] = unserialize($thevalue['listurl']);
		$thevalue['listurl_manual'] = $thevalue['listurl']['manual'];
		$thevalue['listurl_auto'] = $thevalue['listurl']['auto'];
	}
	$urlorder = 0;
	if(!empty($thevalue['listurl_auto'])) {
		$thevalue['autotype'] = !empty($thevalue['autotype']) && intval($thevalue['autotype']) == 2 ? 2 : 1;
		$thevalue['listpagestart'] = !empty($thevalue['autotype']) && $thevalue['autotype'] == 1? intval($thevalue['listpagestart']) : ord($thevalue['listpagestart']);
		$thevalue['listpageend'] = !empty($thevalue['autotype']) && $thevalue['autotype'] == 1? intval($thevalue['listpageend']) : ord($thevalue['listpageend']);
		$thevalue['wildcardlen'] = !empty($thevalue['wildcardlen']) ? intval($thevalue['wildcardlen']) : 0;
		if($thevalue['listpagestart'] > $thevalue['listpageend']) {
			$urlorder = $thevalue['listpagestart'];
			$thevalue['listpagestart'] = $thevalue['listpageend'];
			$thevalue['listpageend'] = $urlorder;
			$urlorder = 1;
		}
		for($i = $thevalue['listpagestart']; $i <= $thevalue['listpageend']; $i++) {
			$strreplace = $i;
			if(!empty($thevalue['wildcardlen']) && $thevalue['autotype'] == 1) {
				$strreplace = str_pad($i, $thevalue['wildcardlen'], 0, STR_PAD_LEFT);
			} elseif($thevalue['autotype'] == 2) {
				$strreplace = chr($i);
			}
			if($thevalue['autotype'] == 1 || ($thevalue['autotype'] == 2 && preg_match("/[a-z]/i", $strreplace))) {
				$listurlarr2[] = preg_replace("/\[page\]/", $strreplace, $thevalue['listurl_auto']);
			}
		}
		if($urlorder == 1) krsort($listurlarr2);
	} 
	if(!empty($thevalue['listurl_manual'])) {
		$listurlarr = $thevalue['listurl_manual'];
	}
	if($urlorder == 0) {
		$listurlarr = array_merge($listurlarr, $listurlarr2);
	} else {
		$listurlarr = array_merge($listurlarr2, $listurlarr);
	}
	
	if(!empty($listurlarr)) {
		//LIST CACHE
		$listcache = false;
		
		//GET LIST TEXT
		$listtext = '';
		if($lpage < count($listurlarr)) {
			$lurl = trim($listurlarr[$lpage]);
			//显示采集地址
			showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_list'].' <a href="'.$lurl.'" target="_blank">'.$lurl.'</a> '.$alang['robot_robot_begin']);
			if(empty($_GET['clearcache'])) {
				$newurlarr = cacherobotlist('get', $lurl, $_GET['robotid']);	//获取采集列表缓存
			} else {
				$newurlarr = array();
			}
			if($newurlarr) {
				$listcache = true;
			} else {
				$lurl = encodeconvert($thevalue['encode'], $lurl, 1);
				$listtext = geturlfile($lurl);	//获取索引列表
				$newurlarr = array();
			}
		} else {
			showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_list'].$alang['robot_robot_end']);
		}

		//GET SUBJECT URL LIST
		$subjecturl = array();
		if(!$listcache && !empty($listtext)) {
			showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_list'].$alang['robot_robot_text'].$alang['robot_robot_end']);
			//列表区域识别
			if(empty($thevalue['subjecturlrule'])) {
				$subjecturlarr[0] = $listtext;	//$listtext 网页源码
			} else {
				$subjecturlarr = pregmessage($listtext, $thevalue['subjecturlrule'], 'list');	//解析列表区域
			}
			$subjecturl = $subjecturlarr[0];
		}
		if(!$listcache && !empty($subjecturl)) {
			showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_list'].$alang['robot_robot_url'].$alang['robot_robot_area'].'</b>'.$alang['robot_robot_success']);
			//文章链接URL识别
			$urlarr = array();
			if(empty($thevalue['subjecturllinkrule'])) {
				$subjecturl = preg_replace(array("/[\n\r]+/", "/\<\/a\>/i", "/\<a/i") , array('', "</a>\n", "\n<a"), $subjecturl);
				preg_match_all("/\<a.+href=('|\"|)?([^\s\<\>]*)(\\1)([\s].*)?\>(.*)\<\/a\>/i", $subjecturl, $ahreftemp);
				$urlarr = sarray_unique($ahreftemp[2]);	//去重
			} else {
				$urlarr = pregmessage($subjecturl, $thevalue['subjecturllinkrule'], 'url', -1);		//解析上步过虑后的结果
			}

			if(!empty($urlarr)) {
				showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_list'].$alang['robot_robot_url'].'</b>'.$alang['robot_robot_success']);
				//文章链接URL剔除
				if(!empty($thevalue['subjecturllinkcancel'])) {
					$tmparr = array();
					$rule = '('.convertrule($thevalue['subjecturllinkcancel']).')';
					foreach($urlarr as $tmpvalue) {
						if(!preg_match("/$rule/i", $tmpvalue)) {
							$tmparr[] = $tmpvalue;
						}
					}
					$urlarr = $tmparr;
				}
				//文章链接URL过滤
				if(!empty($thevalue['subjecturllinkfilter'])) {
					$tmparr = array();
					$rule = '('.convertrule($thevalue['subjecturllinkfilter']).')';
					foreach($urlarr as $tmpvalue) {
						$tmparr[] = trim(preg_replace("/$rule/s", '', $tmpvalue));
					}
					$urlarr = $tmparr;
				}
				//整理完整的文章页地址
				//文章链接URL补充前缀
				if(!empty($thevalue['subjecturllinkpre'])) {
					foreach ($urlarr as $tmpkey => $tmpvalue) {
						if(!empty($tmpvalue)) {
							if(strpos($tmpvalue, '://') === false) {
								$urlarr[$tmpkey] = $thevalue['subjecturllinkpre'].$tmpvalue;
							} elseif(strpos($tmpvalue, '://')>10) {
								$urlarr[$tmpkey] = $thevalue['subjecturllinkpre'].$tmpvalue;
							}
						}
					}
				} else {
					$url = array();
					$posturl = parse_url($lurl);
					foreach ($urlarr as $tmpkey => $tmpvalue) {
						if(!empty($tmpvalue)) {
							$url = parse_url($tmpvalue);
							if(!empty($url['host'])){
								$urlarr[$tmpkey] = $tmpvalue;
							} else {
								$offset = strpos($tmpvalue, '/');
								if(!is_bool($offset) && $offset == 0){
									$urlarr[$tmpkey] = $posturl['scheme'].'://'.$posturl['host'].$tmpvalue;
								} else {
									$urlarr[$tmpkey] = substr($lurl, 0, strrpos($lurl, '/')).'/'.$tmpvalue;
								}
							}
						}
					}
				}
				//文章链接URL补充后缀
				if(!empty($thevalue['subjecturllinkpf'])) {
					foreach ($urlarr as $tmpkey => $tmpvalue) {
						if(!empty($tmpvalue)) {
							$urlarr[$tmpkey] = $tmpvalue.$thevalue['subjecturllinkpf'];
						}
					}
				}
				$newurlarr = sarray_unique($urlarr);	//过滤重复的值，并修整数组
				if($thevalue['reverseorder']) {
					krsort($newurlarr);
					$newurlarr = array_merge(array(), $newurlarr);	//利用合并的方式重新编排数组键名
				}
			}
		}

		if(!empty($newurlarr)) {
			$thevalue['pernum'] = empty($thevalue['pernum']) ? 5 : $thevalue['pernum'];
			$thevalue['allnum'] = empty($thevalue['allnum']) ? 65535 : $thevalue['allnum'];
			if(!$listcache) cacherobotlist('make', $lurl, $_GET['robotid'], $newurlarr);	//生成文章列表数列表URL地址
			
			while (true) {		//死循环采集文章
				$nextpage = false;
				if($mpage >= count($newurlarr)) {	//文章列表页数是否大于单个索引页整理出来的文章列表总数
					$lpage++;	//索引页累加1跳到下 一个索引页执行
					//判断是否超过索引列表了，如果越界了，则退出死循环
					if($lpage < count($listurlarr)) {
						$mpage=0;
						//LIST NUM
						showprogress($alang['robot_robot_next_list']);
						$jumptourl = $theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&clearcache=1&status='.$status;
						showprogress('<a href="'.$jumptourl.'"><b>'.$alang['robot_progress_next_list']."</b></a>", 1);
						include_once template('admin/tpl/footer.htm',1);
						jumpurl($jumptourl, 1);
					} else {
						break;
					}
				} else {
					//判断是否该跳到下一页执行了
					if($mpage%$thevalue['pernum']==$thevalue['pernum']-1) {
						$nextpage = true;
					}
					$msgurl = $newurlarr[$mpage];	//采集文章的url
					
					$gotonext = true;
					
					//PAGE
					//对文章分页的采集处理
					if(!empty($_GET['pageurl'])) {
						$pagekey = $_GET['pagekey'];
						$pageurl = $_GET['pageurl'];
						$itemid = $_GET['itemid'];
						$pageurl = encodeconvert($thevalue['encode'], $pageurl, 1);
						$messagemsgtext = geturlfile($pageurl);
						$msgmsgarr = pregmessagearray($messagemsgtext, $thevalue, $mnum, 1, 0, $pageurl);
						if(!empty($msgmsgarr['message'])) $itemid = messageaddtodb($msgmsgarr, $_GET['robotid'], $itemid);
						if(empty($msgmsgarr['pagearr'][0])) {
							$gotonext = false;
							$_GET['pagekey'] = $_GET['pageurl'] = '';
						} else {
							$pageurl = $msgmsgarr['pagearr'][0];
							showprogress('['.$mnum.'] '.'['.$pagekey.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message_page'].'</b>'.$alang['robot_robot_success'], 1);
							$pagekey++;
							include_once template('admin/tpl/footer.htm',1);
							jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'&itemid='.$itemid.'&pagekey='.$pagekey.'&pageurl='.rawurlencode($pageurl), 1);
						}
					} elseif (!empty($_GET['pagekey'])) {
						$pagekey = $_GET['pagekey'];
						$itemid = $_GET['itemid'];
						$pagearr = cacherobotlist('get', $msgurl, $_GET['robotid'], array(), 'pagearr');
						if(empty($pagearr[$pagekey-1])) {
							$gotonext = false;
							$_GET['pagekey'] = '';
						} else {
							$pageurl = $pagearr[$pagekey-1];
							$pageurl = encodeconvert($thevalue['encode'], $pageurl, 1);
							$messagemsgtext = geturlfile($pageurl);
							$msgmsgarr = pregmessagearray($messagemsgtext, $thevalue, $mnum, 0, 0, $pageurl);
							if(!empty($msgmsgarr['message'])) $itemid = messageaddtodb($msgmsgarr, $_GET['robotid'], $itemid);
							showprogress('['.$mnum.'] '.'['.$pagekey.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message_page'].'</b>'.$alang['robot_robot_success'], 1);
							$pagekey++;
							include_once template('admin/tpl/footer.htm',1);
							jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'&itemid='.$itemid.'&pagekey='.$pagekey, 1);
						}
					}
					
					//MESSAGE
					if($gotonext) {
						$msgurl = encodeconvert($thevalue['encode'], $msgurl, 1);
						$messagetext = geturlfile($msgurl);		//获取指定URL地址的文章内容
					} else {
						$messagetext = '';
					}
					if(!empty($messagetext)) {
						showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message'].' <a href="'.$msgurl.'" target="_blank">'.$msgurl.'</a> '.'</b>'.$alang['robot_robot_success'], 1);
						
						//采集次数累加1并结整采集程序
						if(empty($status)) {
							$_SGLOBAL['db']->query('UPDATE '.tname('robots').' SET lasttime=\''.$_SGLOBAL['timestamp'].'\',robotnum=robotnum+1 WHERE robotid=\''.$_GET['robotid'].'\'');
							$status = 1;
						}
						
						$msgarr = pregmessagearray($messagetext, $thevalue, $mnum, 1, 1, $msgurl);	//解析文章内容
						if(!empty($msgarr['subject']) && !empty($msgarr['message'])) {
							//INSERT ITEM
							$itemid = messageaddtodb($msgarr, $_GET['robotid'], 0);
							$mnum++;
						} else {
							$mnum++;
						}

						//对文章列表页的处理
						if(!empty($msgarr['pagearr']) && $thevalue['messagepagetype'] == 'page') {
							cacherobotlist('make', $msgurl, $_GET['robotid'], $msgarr['pagearr'], 'pagearr');
							include_once template('admin/tpl/footer.htm',1);
							jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'&itemid='.$itemid.'&pagekey=1', 1);
						} elseif (!empty($msgarr['pagearr']) && $thevalue['messagepagetype'] == 'next') {
							$pageurl = $msgarr['pagearr'][0];
							include_once template('admin/tpl/footer.htm',1);
							jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'&itemid='.$itemid.'&pagekey=1&pageurl='.rawurlencode($pageurl), 1);
						}
						
						//ALL NUM
						//判断采集总数是否超过了允许的采集总数
						if($mnum >= $thevalue['allnum']) {
							showprogress($alang['robot_robot_all_max'].' ('.$mnum.') '.$alang['robot_robot_end'], 1);
							$lpage = count($listurlarr) + 1;
							include_once template('admin/tpl/footer.htm',1);
							jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum, 1);
						}
						
					} elseif($gotonext) {
						showprogress($alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message'].' (<a href="'.$msgurl.'" target="_blank">'.$msgurl.'</a>) '.'</b>'.$alang['robot_robot_failed'], 1);
					}		
				}
				$mpage++;
				if($nextpage) {
					//PER NUM
					showprogress($alang['robot_robot_next_message'].' ('.$thevalue['pernum'].')', 1);
					showprogress('<a href="'.$theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'"><b>'.$alang['robot_progress_next_list']."</b></a>", 1);
					include_once template('admin/tpl/footer.htm',1);
					jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status, 1);
				}
			}
		} else {
			$lpage++;
			if($lpage < count($listurlarr)) {
				$mpage=0;
				//LIST NUM
				showprogress($alang['robot_robot_next_list']);
				showprogress('<a href="'.$theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status.'"><b>'.$alang['robot_progress_next_list']."</b></a>", 1);
				include_once template('admin/tpl/footer.htm',1);
				jumpurl($theurl.'&op=robot&robotid='.$_GET['robotid'].'&lpage='.$lpage.'&mpage='.$mpage.'&mnum='.$mnum.'&status='.$status, 1);
			}
		}
	} else {
		showprogress($alang['robot_robot_url_error'], 1);
	}
	
	showprogress('<a href="'.CPURL.'?action=robotmessages&robotid='.$_GET['robotid'].'">'.$alang['robot_robot_result'].'</a>', 1);
	$listarr = array();
	$thevalue = array();
	$importvalue = array();
	
} elseif($_GET['op'] == 'clear') {
	
	delrobotmsg($_GET['robotid']);
	showmessage('robot_clear_success', $theurl);

} elseif($_GET['op'] == 'export') {
	
	//ONE VIEW FOR UPDATE
	$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('robots').' WHERE robotid=\''.$_GET['robotid'].'\'');
	if($thevalue = $_SGLOBAL['db']->fetch_array($query)) {
	} else {
		showmessage('robot_robotid_no_exists');
	}
	exportfile($thevalue, 'robot_'.$thevalue['name']);
	$listarr = array();
	$thevalue = array();
	$importvalue = array();

} elseif($_GET['op'] == 'import') {
	
	$listarr = array();
	$thevalue = array();
	$importvalue = array(
		'importtext' => '',
		'ignoreversion' => '0'
	);
	
} elseif($_GET['op'] == 'exportmessage') {

	$filename = S_ROOT.'./data/robot/robot_'.$_GET['robotid'].'_message.txt';
	$filename_url = S_URL.'/data/robot/robot_'.$_GET['robotid'].'_message.txt';
	if(@$fp = fopen($filename, 'w')) {
		@ini_set('max_execution_time', 1000);
		showprogress($alang['exportmessage_begin'].' <a href="'.$filename_url.'">'.$filename_url.'</a>', 1);
		$query = $_SGLOBAL['db']->query('SELECT i.subject, m.message FROM '.tname('robotitems').' i LEFT JOIN '.tname('robotmessages').' m ON m.itemid=i.itemid WHERE i.robotid=\''.$_GET['robotid'].'\'');
		$i = 1;
		while ($topic = $_SGLOBAL['db']->fetch_array($query)) {
			$text = '<br>--------------------------------------<br>['.$i.'] '.$topic['subject'].'<br>--------------------------------------<br><br>'.$topic['message'].'<br>';
			$text = str_replace('&nbsp;', ' ', $text);
			$text = str_replace('<br>', "\r\n", $text);
			$text = str_replace('<br />', "\r\n", $text);
			$text = strip_tags($text);
			$text = trim($text);
			$text = $text."\r\n\r\n\r\n";
	        @fwrite($fp, $text);
			showprogress('['.$i.'] '.$topic['subject'].' '.$alang['exportmessage_success']);
			$i++;
		}
		@fclose($fp);
		showprogress($alang['exportmessage_end'].' <a href="'.$filename_url.'">'.$filename_url.'('.$alang['exportmessage_download'].')</a>', 1);
	} else {
		showmessage('robot_exportmessage_fopen_error');
	}
	$listarr = array();
	$thevalue = array();
	$importvalue = array();

}

//LIST SHOW
if(is_array($listarr) && $listarr) {
	
	echo label(array('type'=>'table-start', 'class'=>'listtable'));
	echo '<tr>';
	echo '<th>'.$alang['robot_robot_name'].'</th>';
	echo '<th width="20%">'.$alang['robot_robot_robot_time'].'</th>';
	echo '<th width="10%">'.$alang['robot_robot_num'].'</th>';
	echo '<th width="33%">'.$alang['robot_robot_op_select'].'</th>';
	echo '</tr>';

	foreach ($listarr as $listvalue) {
		$listvalue['dateline'] = sgmdate($listvalue['dateline']);
		$execurl = $theurl . '&op=robot&clearcache=1&robotid=' . $listvalue['robotid'];
		if(empty($listvalue['lasttime'])) {
			$listvalue['lasttime'] = '-';
		} else {
			$listvalue['lasttime'] = sgmdate($listvalue['lasttime']);
		}
		empty($class) ? $class=' class="darkrow"': $class='';
		echo '<tr'.$class.'>';
		echo '<td><a href="'.CPURL.'?action=robotmessages&robotid='.$listvalue['robotid'].'"><b>'.$listvalue['name'].'</b></a></td>';
		echo '<td align="center">'.$listvalue['lasttime'].'</td>';
		echo '<td align="center">'.$listvalue['robotnum'].'</td>';
		echo '<td align="center"><a href="'.$execurl.'">'.$alang['robot_robot_op_start'].'</a> | <a href="'.$theurl.'&op=edit&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_edit'].'</a> | <a href="'.$theurl.'&op=copy&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_copy'].'</a> | <a href="'.$theurl.'&op=export&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_export'].'</a><br><a href="'.CPURL.'?action=robotmessages&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_result'].'</a> | <a href="'.$theurl.'&op=exportmessage&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_export_message'].'</a> | <a href="'.$theurl.'&op=clear&robotid='.$listvalue['robotid'].'">'.$alang['robot_robot_op_clear'].'</a> | <a href="'.$theurl.'&op=delete&robotid='.$listvalue['robotid'].'" onclick="return confirm(\''.$alang['delete_all_note'].'\');">'.$alang['robot_robot_op_delete'].'</a></td>';
		echo '</tr>';
	}
	echo label(array('type'=>'table-end'));
	
	if(!empty($multipage)) {
		echo label(array('type'=>'table-start', 'class'=>'listpage'));
		echo '<tr><td>'.$multipage.'</td></tr>';
		echo label(array('type'=>'table-end'));
	}
}

$output = '';
$s_url = S_URL;
//THE VALUE SHOW
if(is_array($thevalue) && $thevalue) {
	$savepicarr = array(
		'0' => $alang['robot_savepic_0'],
		'1' => $alang['robot_savepic_1']
	);
	$saveflasharr = array(
		'0' => $alang['robot_saveflash_0'],
		'1' => $alang['robot_saveflash_1']
	);
	$messagepagetypearr = array(
		'page' => $alang['robot_messagepagetype_page'],
		'next' => $alang['robot_messagepagetype_next']
	);
	$subjectallowrepeatarr = array(
		'1' => $alang['robot_subjectallowrepeat_1'],
		'0' => $alang['robot_subjectallowrepeat_0']
	);
	//获取资讯分类
	$clistarr = getcategory('news');
	$allcatarr = getcategory();
	$catselectstr = '<select name="import">';
	$catselectstr .= '<option value="0">-------</option>';
	foreach ($allcatarr as $key => $cvalue) {
		if(empty($channels['types'][$key])) continue;
		$catselectstr .='<optgroup label="'.$channels['types'][$key]['name'].'">';
		foreach ($cvalue as $value) {
			$checkstr = $thevalue['importcatid'] == $value['catid']?' selected':'';
			$catselectstr .= '<option value="'.$key.'_'.$value['catid'].'"'.$checkstr.'>'.$value['pre'].$value['name'].'</option>';
		}
		$catselectstr .= '</optgroup>';
	}
	$catselectstr .= '</select>';
	
	$autotype = array(1=>'', 2=>'');
	$messageformat = array(0=>'', 1=>'');
	$thevalue['autotype'] = empty($thevalue['autotype']) || $thevalue['autotype'] != 2 ? 1 : 2;
	$autotype[$thevalue['autotype']] = 'checked="checked"';
	$messageformat[$thevalue['messageformat']] = 'checked="checked"';
	
	$subjectreplace = '';	//标题替换初始化
	if(!empty($thevalue['subjectreplace'])) {
		if(is_array($thevalue['subjectreplace'])) {
			foreach($thevalue['subjectreplace'] as $tmpkey => $tmpvalue) {
				$subjectreplace .= 'addreplace(\'subjectreplace\', \''.convertstr($tmpvalue).'\', \''.convertstr($thevalue['subjectreplaceto'][$tmpkey]).'\');'."\n";
			}
		} else {
			$subjectreplace = 'addreplace(\'subjectreplace\', \''.convertstr($thevalue['subjectreplace']).'\', \''.convertstr($thevalue['subjectreplaceto']).'\');'."\n";
		}
	} else {
		$subjectreplace = 'addreplace(\'subjectreplace\', \'\', \'\');'."\n";
	}
	$messagereplace = '';	//内容替换初始化
	if(!empty($thevalue['messagereplace'])) {
		if(is_array($thevalue['messagereplace'])) {
			foreach($thevalue['messagereplace'] as $tmpkey => $tmpvalue) {
				$messagereplace .= 'addreplace(\'messagereplace\', \''.convertstr($tmpvalue).'\', \''.convertstr($thevalue['messagereplaceto'][$tmpkey]).'\');'."\n";
			}
		} else {
			$messagereplace = 'addreplace(\'messagereplace\', \''.convertstr($thevalue['messagereplace']).'\', \''.convertstr($thevalue['messagereplaceto']).'\');'."\n";
		}
	} else {
		$messagereplace = 'addreplace(\'messagereplace\', \'\', \'\');'."\n";
	}

	$tmpvalue = $thevalue['listurl_manual'];
	$thevalue = shtmlspecialchars($thevalue);
	$thevalue['listurl_manual'] = $tmpvalue;
	$reverseorderstr = label(array('type'=>'radio', 'alang'=>'robot_reverseorder', 'name'=>'reverseorder', 'options'=>$savepicarr, 'value'=>$thevalue['reverseorder']));
	$formhash = formhash();
	$output .= <<<EOF
		<script language="javascript" src="$s_url/include/js/selectdate.js"></script>
		<script language="javascript" src="$s_url/include/js/infoajax.js"></script>
		<script language="javascript">
		<!--
		var objdebugframe;
		
		function debugsubmit(obj, nodename, process) {
			var debugurl = '';
			var allowurlnull = false;
			if(objdebugframe == null) {
				objdebugframe = $('tr_debugframe').cloneNode(true);
			}
			var objnode = $(nodename);
			if($('tr_debugframe') != null) {
				debugurl = $('f_debugurl').value;
				if($('f_allowurlnull').checked) {
					debugurl = '';
					allowurlnull = $('f_allowurlnull').checked;
				}
			}
			closedebugframe();
			objnode.parentNode.insertBefore(objdebugframe, objnode.nextSibling);
			editdoc = document.getElementById("debugframe").contentWindow.document;
			editdoc.open('text/html', 'replace');
			editdoc.write('loading...');
			editdoc.close();
			$('f_debugurl').value = debugurl;
			$('f_allowurlnull').checked = allowurlnull;
			objsubmit = $('valuesubmit');
			objsubmit.name = 'debug';
			obj.form.target = 'debugframe';
			$('debugurl').value = debugurl;
			$('debugprocess').value = process;
			obj.form.submit();
			objsubmit.name = 'valuesubmit';
			obj.form.target = '';
			$('debugurl').value = '';
			$('debugprocess').value = '';
		}
		function closedebugframe() {
			var objnode = $('tr_debugframe');
			if(objnode != null) {
				objnode.parentNode.removeChild(objnode);
			}
		}
		
		var r = 0;
		function addreplace(str, replace, replaceto) {
			objtd = $('td_'+str+'_title');
			if(objtd.lastChild != null) {
				pn = objtd.lastChild
				pn.appendChild(document.createTextNode(' '));
				oBody = document.createElement('input');
				oBody.type = 'button';
				oBody.value = '$alang[robot_delete]';
				if(window.document.all != null) {
					oBody.attachEvent('onclick', new Function('delreplace(\''+pn.id+'\');'));
				} else {
					oBody.addEventListener('click', new Function('delreplace(\''+pn.id+'\');'), false);
				}
				pn.appendChild(oBody);
			}
			pn = document.createElement('div');
			pn.id = 'replace_'+(r+1);
			pn.appendChild(document.createElement('br'));
			pn.appendChild(document.createTextNode('$alang[robot_subjectreplace] '));
			oBody = document.createElement("input");
			oBody.id = str+'[]';
			oBody.name = str+'[]';
			oBody.type = 'text';
			oBody.size = '40';
			oBody.value = replace;
			pn.appendChild(oBody);
			pn.appendChild(document.createElement('br'));
			pn.appendChild(document.createTextNode('$alang[robot_subjectreplace_exp]'));
			pn.appendChild(document.createElement('br'));
			pn.appendChild(document.createTextNode('$alang[robot_subjectreplaceto] '));
			oBody = document.createElement("input");
			oBody.id = str+'to[]';
			oBody.name = str+'to[]';
			oBody.type = 'text';
			oBody.size = '40';
			oBody.value = replaceto;
			pn.appendChild(oBody);
			pn.appendChild(document.createElement('br'));
			pn.appendChild(document.createTextNode('$alang[robot_subjectreplaceto_exp]'));
			objtd.appendChild(pn);
			r++
		}
		function delreplace(str) {
			pn = document.createElement("div");
			pn.id = str;
			pn.style.display = 'none';
			$(str).parentNode.replaceChild(pn, $(str));
		}
		//-->
		</script>
		<form method="post" name="thevalueform" id="theform" action="$theurl" enctype="multipart/form-data" onSubmit="return validate(this)">
			<input type="hidden" name="formhash" value="$formhash">
			<div class="colorarea01">
				<h2>$alang[robot_main]</h2>
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tbody id="hiddendebugframe" style="display: none;">
					<tr id="tr_debugframe">
						<th>$alang[robot_debugframe]<br /><input name="f_debugurl" type="text" id="f_debugurl" style="width: 95%"><br />
						<input name="f_allowurlnull" type="checkbox" id="f_allowurlnull">$alang[robot_allowurlnull_0]&nbsp;&nbsp;
						<a href="javascript:;" onclick="$('f_debugurl').value='';">$alang[robot_allowurlnull_1]</a><br /><br />
							$alang[robot_debugframe_info]
							<div align="right"><a href="javascript:;" onclick="closedebugframe();">$alang[robot_debugframe_close]</a></div></th>
						<td><iframe id="debugframe" name="debugframe" width="100%" height="300" marginwidth="0" scrolling="auto" frameborder="0" src="about:blank"></iframe></td>
					</tr>
					</tbody>
					<tr id="tr_name">
						<th>$alang[robot_name]</th>
						<td><input name="name" type="text" id="name" size="30" value="$thevalue[name]" /></td>
					</tr>
					<tr id="tr_allnum">
						<th>$alang[robot_allnum]</th>
						<td><input name="allnum" type="text" id="allnum" size="10" value="$thevalue[allnum]" /></td>
					</tr>
					<tr id="tr_pernum">
						<th>$alang[robot_pernum]</th>
						<td><input name="pernum" type="text" id="pernum" size="10" value="$thevalue[pernum]" /></td>
					</tr>
					<tr id="tr_import">
						<th>$alang[robot_importcatid]</th>
						<td>$catselectstr</td>
					</tr>
					<tr id="tr_dateline">
						<th>$alang[robot_dateline]</th>
						<td><input name="defaultdateline" type="text" id="defaultdateline" size="30" value="$thevalue[defaultdateline]" readonly/><img onclick="getDatePicker('defaultdateline', event, 21)" src="$s_url/admin/images/time.gif"/>&nbsp;<a href="javascript:;" onclick="$('defaultdateline').value='';">$alang[robot_defaultdateline_delete]</td>
					</tr>
				</table>
			</div>
			<div class="colorarea02">
				<h2>$alang[robot_list]</h2>
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tr id="tr_robot_listurltype">
						<td valign="top" width="50%">
							$alang[robot_listurltype_manual]<br /><br />
							<div id="udiv">$thevalue[listurl_manual]</div>
							$alang[add_a_new_link]:<input type="text" id="url" name="url" size="40" /><input type="button" value="$alang[space_add_tag]" onclick="insertitem();" /><br />
							$alang[for_example]:http://www.discuz.net/file_1.htm
						</td>
						<td valign="top" width="50%">
							$alang[robot_listurltype_auto]<br /><br />
							URL: <input type="text" name="listurl_auto" id="listurl_auto" size="46" value="$thevalue[listurl_auto]" onblur="inputcheck(this);" /><br />
							$alang[for_example]: http://www.discuz.net/file_[page].htm<br />
							&nbsp;$alang[robot_from]:&nbsp;&nbsp;&nbsp;<input type="text" id="listpagestart" name="listpagestart" value="$thevalue[listpagestart]" size="4" maxlength="10" onkeyup="inputcheck(this);" />&nbsp;&nbsp;$alang[robot_to]:&nbsp;&nbsp;<input type="text" id="listpageend" name="listpageend" value="$thevalue[listpageend]" size="4" maxlength="10" onkeyup="inputcheck(this);" /> 
							<br />
							<span id="wildcard">$alang[wildcard_length]:&nbsp;&nbsp;<input type="text" id="wildcardlen" name="wildcardlen" value="$thevalue[wildcardlen]" size="3" maxlength="1" onkeyup="inputcheck(this);" /> $alang[wildcard_length_note]. </span>
							<div id="str_wc" style="color: #aaa; display: none"></div>
						</td>
					</tr>
					<tr id="tr_robot_debug">
						<td colspan="2" align="right">
							<input type="button" value="$alang[robot_debug_showlisturl]" onclick="debugsubmit(this, 'tr_robot_debug', 'showlisturl');">
							<input type="button" value="$alang[robot_debug_pinglisturl]" onclick="debugsubmit(this, 'tr_robot_debug', 'pinglisturl');">
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					$reverseorderstr
					<tr id="tr_encode">
						<th>$alang[robot_encode]</th>
						<td><input name="encode" type="text" id="encode" size="10" value="$thevalue[encode]" />
							<input type="button" value="$alang[robot_debug_auxiliary]" onclick="debugsubmit(this, 'tr_encode', 'charset');">
						</td>
					</tr>
					<tr id="tr_subjecturlrule">
						<th>$alang[robot_subjecturlrule]</th>
						<td><textarea id="subjecturlrule" name="subjecturlrule" style="width:75%;" rows="4">$thevalue[subjecturlrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturlrule', 'subjecturlrule');">
						<input type="button" value="$alang[robot_debug_auto_recognition]" onclick="$('subjecturlrule').value=''; debugsubmit(this, 'tr_subjecturlrule', 'subjecturlrule');"><br />
						<a href="javascript:;" onclick="$('subjecturlrule').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_subjecturlrule]</td>
					</tr>
					<tr id="tr_subjecturllinkrule">
						<th>$alang[robot_subjecturllinkrule]</th>
						<td><textarea id="subjecturllinkrule" name="subjecturllinkrule" style="width:75%;" rows="4">$thevalue[subjecturllinkrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturllinkrule', 'subjecturllinkrule');">
						<input type="button" value="$alang[robot_debug_auto_recognition]" onclick="$('subjecturllinkrule').value=''; debugsubmit(this, 'tr_subjecturllinkrule', 'subjecturllinkrule');"><br />
						<a href="javascript:;" onclick="$('subjecturllinkrule').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_subjecturllinkrule]</td>
					</tr>
					<tr id="tr_subjecturllinkcancel">
						<th>$alang[robot_debug_info_subjecturllinkcancel]</th>
						<td><textarea id="subjecturllinkcancel" name="subjecturllinkcancel" style="width:75%;" rows="4">$thevalue[subjecturllinkcancel]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturllinkcancel', 'subjecturllinkcancel');"></td>
					</tr>
					<tr id="tr_subjecturllinkfilter">
						<th>$alang[robot_debug_info_subjecturllinkfilter]</th>
						<td><textarea id="subjecturllinkfilter" name="subjecturllinkfilter" style="width:75%;" rows="4">$thevalue[subjecturllinkfilter]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturllinkfilter', 'subjecturllinkfilter');"></td>
					</tr>
					<tr id="tr_subjecturllinkpre">
						<th>$alang[robot_subjecturllinkpre]</th>
						<td><input name="subjecturllinkpre" type="text" id="subjecturllinkpre" size="60" value="$thevalue[subjecturllinkpre]" />
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturllinkpre', 'subjecturllinkpre');">
						<input type="button" value="$alang[robot_debug_auto_recognition]" onclick="$('subjecturllinkpre').value=''; debugsubmit(this, 'tr_subjecturllinkpre', 'subjecturllinkpre');"><br />
						<a href="javascript:;" onclick="$('subjecturllinkpre').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_subjecturllinkpre]</td>
					</tr>
					<tr id="tr_subjecturllinkpf">
						<th>$alang[robot_subjecturllinkpf]</th>
						<td><input name="subjecturllinkpf" type="text" id="subjecturllinkpf" size="60" value="$thevalue[subjecturllinkpf]" />
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjecturllinkpf', 'subjecturllinkpf');"></td>
					</tr>
				</table>
			</div>
			<div class="colorarea01">
				<h2>$alang[robot_message]</h2>
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tr id="tr_subjectrule">
						<th>$alang[robot_subjectrule]</th>
						<td><textarea id="subjectrule" name="subjectrule" style="width:75%;" rows="4">$thevalue[subjectrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjectrule', 'subjectrule');"></td>
					</tr>
					<tr id="tr_subjectfilter">
						<th>$alang[robot_subjectfilter]</th>
						<td><textarea id="subjectfilter" name="subjectfilter" style="width:75%;" rows="4">$thevalue[subjectfilter]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjectfilter', 'subjectfilter');"></td>
					</tr>
					<tr id="tr_subjectreplace_title">
						<th>$alang[robot_subjectreplace_title]</th>
						<td>
							<div id="td_subjectreplace_title"></div>
							<br />
							<input type="button" value="$alang[robot_debug_add]" onclick="addreplace('subjectreplace', '', '');">
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjectreplace_title', 'subjectreplace');">
							<script>$subjectreplace</script>
						</td>
					</tr>
					<tr id="tr_subjectkey">
						<th>$alang[robot_subjectkey]</th>
						<td><textarea id="subjectkey" name="subjectkey" style="width:75%;" rows="4">$thevalue[subjectkey]</textarea>
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjectkey', 'subjectkey');"></td>
					</tr>
					<tr id="tr_subjectkeycancel">
						<th>$alang[robot_subjectkeycancel]</th>
						<td><textarea id="subjectkeycancel" name="subjectkeycancel" style="width:75%;" rows="4">$thevalue[subjectkeycancel]</textarea>
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_subjectkeycancel', 'subjectkeycancel');"></td>
					</tr>
EOF;
		$output .= label(array('type'=>'radio', 'alang'=>'robot_subjectallowrepeat', 'name'=>'subjectallowrepeat', 'options'=>$subjectallowrepeatarr, 'value'=>$thevalue['subjectallowrepeat']));
		$output .= <<<EOF
				</table>
			</div>
			<div class="colorarea02">
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tr id="tr_messagerule">
						<th>$alang[robot_messagerule]</th>
						<td><textarea id="messagerule" name="messagerule" style="width:75%;" rows="4">$thevalue[messagerule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagerule', 'messagerule');">
						<input type="button" value="$alang[robot_debug_auto_recognition]" onclick="$('messagerule').value=''; debugsubmit(this, 'tr_messagerule', 'messagerule');"><br />
						<a href="javascript:;" onclick="$('messagerule').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_messagerule]</td>
					</tr>
					<tr id="tr_messagefilter">
						<th>$alang[robot_messagefilter]</th>
						<td><textarea id="messagefilter" name="messagefilter" style="width:75%;" rows="4">$thevalue[messagefilter]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagefilter', 'messagefilter');"></td>
					</tr>
					<tr id="tr_messagereplace_title">
						<th>$alang[robot_messagereplace_title]</th>
						<td>
							<div id="td_messagereplace_title"></div>
							<br />
							<input type="button" value="$alang[robot_debug_add]" onclick="addreplace('messagereplace', '', '');">
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagereplace_title', 'messagereplace');">
							<script>$messagereplace</script>
						</td>
					</tr>
					<tr id="tr_messagekey">
						<th>$alang[robot_messagekey]</th>
						<td><textarea id="messagekey" name="messagekey" style="width:75%;" rows="4">$thevalue[messagekey]</textarea>
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagekey', 'messagekey');"></td>
					</tr>
					<tr id="tr_messagekeycancel">
						<th>$alang[robot_messagekeycancel]</th>
						<td><textarea id="messagekeycancel" name="messagekeycancel" style="width:75%;" rows="4">$thevalue[messagekeycancel]</textarea>
							<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagekeycancel', 'messagekeycancel');"></td>
					</tr>
					<tr id="tr_messageformat">
						<th>$alang[robot_messageformat]</th>
						<td><input id="messageformat" name="messageformat" type="radio" value="1" $messageformat[1] />$alang[robot_messageformat_1]&nbsp;&nbsp;<input id="messageformat" name="messageformat" type="radio" value="0" $messageformat[0] />$alang[robot_messageformat_0]
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messageformat', 'messageformat');"></td>
					</tr>
					
EOF;
		$output .= label(array('type'=>'radio', 'alang'=>'robot_messagepagetype', 'name'=>'messagepagetype', 'options'=>$messagepagetypearr, 'value'=>$thevalue['messagepagetype']));
		$output .= <<<EOF
					<tr id="tr_messagepagerule">
						<th>$alang[robot_messagepagerule]</th>
						<td><textarea id="messagepagerule" name="messagepagerule" style="width:75%;" rows="4">$thevalue[messagepagerule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagepagerule', 'messagepagerule');"></td>
					</tr>
					<tr id="tr_messagepageurlrule">
						<th>$alang[robot_messagepageurlrule]</th>
						<td><textarea id="messagepageurlrule" name="messagepageurlrule" style="width:75%;" rows="4">$thevalue[messagepageurlrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagepageurlrule', 'messagepageurlrule');"></td>
					</tr>
					<tr id="tr_messagepageurllinkpre">
						<th>$alang[robot_messagepageurllinkpre]</th>
						<td><input name="messagepageurllinkpre" type="text" id="messagepageurllinkpre" size="60" value="$thevalue[messagepageurllinkpre]" />
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagepageurllinkpre', 'messagepageurllinkpre');">
						<input type="button" value="$alang[robot_debug_auto_recognition]" onclick="$('messagepageurllinkpre').value=''; debugsubmit(this, 'tr_messagepageurllinkpre', 'messagepageurllinkpre');"><br />
						<a href="javascript:;" onclick="$('messagepageurllinkpre').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_messagepageurllinkpre]</td>
					</tr>
					<tr id="tr_messagepageurllinkpf">
						<th>$alang[robot_messagepageurllinkpf]</th>
						<td><input name="messagepageurllinkpf" type="text" id="messagepageurllinkpf" size="60" value="$thevalue[messagepageurllinkpf]" />
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_messagepageurllinkpf', 'messagepageurllinkpf');"></td>
					</tr>
				</table>
			</div>
			<div class="colorarea02">
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tr id="tr_fromrule">
						<th>$alang[robot_fromrule]</th>
						<td><textarea id="fromrule" name="fromrule" style="width:75%;" rows="4">$thevalue[fromrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_fromrule', 'fromrule');"><br />
						$alang[robot_fromrule_info]</td>
					</tr>
					<tr id="tr_authorrule">
						<th>$alang[robot_authorrule]</th>
						<td><textarea id="authorrule" name="authorrule" style="width:75%;" rows="4">$thevalue[authorrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_authorrule', 'authorrule');"><br />
						$alang[robot_authorrule_info]</td>
					</tr>
				</table>
			</div>
			<div class="colorarea02">
				<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
					<tr id="tr_uidrule">
						<th>$alang[robot_uidrule]</th>
						<td><textarea id="uidrule" name="uidrule" style="width:75%;" rows="4">$thevalue[uidrule]</textarea>
						<input type="button" value="$alang[robot_debug]" onclick="debugsubmit(this, 'tr_uidrule', 'uidrule');"></td>
					</tr>

EOF;
		$output .= label(array('type'=>'radio', 'alang'=>'robot_savepic', 'name'=>'savepic', 'options'=>$savepicarr, 'value'=>$thevalue['savepic']));
		$output .= label(array('type'=>'radio', 'alang'=>'robot_saveflash', 'name'=>'saveflash', 'options'=>$saveflasharr, 'value'=>$thevalue['saveflash']));
		$output .= <<<EOF
					<tr id="tr_picurllinkpre">
						<th>$alang[robot_picurllinkpre]</th>
						<td><input name="picurllinkpre" type="text" id="picurllinkpre" size="60" value="$thevalue[picurllinkpre]" />
						<br />
						<a href="javascript:;" onclick="$('picurllinkpre').value='';">$alang[robot_debug_auto_recognition]</a> $alang[robot_debug_auto_picurllinkpre]</td>
					</tr>
				</table>
			</div>
			<div class="buttons">
				<input type="submit" name="thevaluesubmit" value="$alang[common_submit]" class="submit">
				<input type="reset" name="thevaluereset" value="$alang[common_reset]">
			</div>
				<input id="valuesubmit" name="valuesubmit" type="hidden" value="yes" />
				<input id="robotid" name="robotid" type="hidden" value="$thevalue[robotid]" />
				<input id="debugurl" name="debugurl" type="hidden" value="" />
				<input id="debugprocess" name="debugprocess" type="hidden" value="" />
		</form>
EOF;

	echo $output;
}

//IMPORT SHOW
if(is_array($importvalue) && $importvalue) {
	echo label(array('type'=>'form-start', 'name'=>'importform', 'action'=>$theurl));
	
	echo label(array('type'=>'div-start'));
	echo label(array('type'=>'title', 'alang'=>'robot_import_title'));
	echo label(array('type'=>'table-start'));

	echo label(array('type'=>'text', 'alang'=>'robot_import_text', 'width'=>'30%', 'text'=>'<textarea name="importtext" rows="20" cols="70"></textarea>', 'value'=>$importvalue['importtext']));
	echo label(array('type'=>'radio', 'alang'=>'robot_import_ignoreversion', 'name'=>'ignoreversion', 'options'=>array('0'=>$alang['robot_import_ignoreversion_0'],'1'=>$alang['robot_import_ignoreversion_1']), 'value'=>$importvalue['ignoreversion']));
	
	echo label(array('type'=>'table-end'));
	echo label(array('type'=>'div-end'));
	
	echo '<div class="buttons">';
	echo label(array('type'=>'button-submit', 'name'=>'importsubmit', 'value'=>$alang['common_submit_import']));
	echo label(array('type'=>'button-reset', 'name'=>'importreset', 'value'=>$alang['common_reset']));
	echo '</div>';
	echo label(array('type'=>'form-end'));
}

//FUNCTION
function showprogress($message, $title=0) {	
	if($title) {
		echo '<div class="progress">'.$message.'</div>';
	} else {
		echo $message.'<br>';
	}
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

/**
 * 正则规则
 */
function getregularstring($rule, $getstr) {
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	return $rule;
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

function pregmessagearray($messagetext, $rulearr, $mnum, $getpage=0, $getsubject=0, $msgurl='') {
	global $_SGLOBAL, $alang;
	
	if($getsubject) $mnum = $mnum+1;
	$msgarr = array(
		'subject' => '',
		'dateline' => '',
		'itemfrom' => '',
		'author' => '',
		'message' => '',
		'importcatid' => $rulearr['importcatid'],
		'importtype' => $rulearr['importtype'],
		'pagearr' => array(),
		'picarr' => array(),
		'flasharr' => array(),
		'patharr' => array()
	);
	$nextprogress = true;

	//文章标题识别
	if($getsubject && $messagetext && !empty($rulearr['subjectrule'])) {
		$subjectarr = pregmessage($messagetext, $rulearr['subjectrule'], 'subject');
		$msgarr['subject'] = $subjectarr[0];
	}
	//文章标题过滤
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectfilter'])) {
		$rule = convertrule($rulearr['subjectfilter']);
		$msgarr['subject'] = preg_replace("/($rule)/s", '', $msgarr['subject']);
	}
	//文章标题文字替换
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectreplace'])) {
		$rulearr['subjectreplace'] = explode("\n", $rulearr['subjectreplace']);
		$rulearr['subjectreplaceto'] = explode("\n", $rulearr['subjectreplaceto']);
		$msgarr['subject'] = stringreplace($rulearr['subjectreplace'], $rulearr['subjectreplaceto'], $msgarr['subject']);
	}
	//文章标题包含关键字
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectkey'])) {
		$rule = convertrule($rulearr['subjectkey']);
		$newsubject = preg_replace("/($rule)/s", '', $msgarr['subject']);
		if($newsubject == $msgarr['subject']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' '.$alang['robot_robot_subject_no_key']);
			$nextprogress = false;
			$msgarr['subject'] = '';
		}					
	}
	//文章标题关键字剔除过滤
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectkeycancel'])) {
		$rule = convertrule($rulearr['subjectkeycancel']);
		$newsubject = preg_replace("/($rule)/s", '', $msgarr['subject']);
		if($newsubject != $msgarr['subject']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' '.$alang['robot_robot_subject_key_cancel']);
			$nextprogress = false;
			$msgarr['subject'] = '';
		}				
	}
	$msgarr['subject'] = trim($msgarr['subject']);
	if($getsubject && $nextprogress && empty($msgarr['subject'])) {
		showprogress('['.$mnum.'] '.$alang['robot_robot_subject_null']);
		$nextprogress = false;
	}
	if($getsubject && $nextprogress && !$rulearr['subjectallowrepeat']) {
		$query = $_SGLOBAL['db']->query('SELECT COUNT(*) FROM '.tname('robotlog').' WHERE hash=\''.md5($msgarr['subject']).'\'');
		if($_SGLOBAL['db']->result($query, 0)) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' '.$alang['robot_robot_subject_exists']);
			$nextprogress = false;
		}
	}
	if($nextprogress && $getsubject && $msgarr['subject']) {
		showprogress('['.$mnum.'] [<b>'.$msgarr['subject'].'</b>] '.$alang['robot_robot_deal'].'<b>'.'<b>'.$alang['robot_robot_subject'].'</b>'.$alang['robot_robot_success']);
	}
	if(!$nextprogress) {
		$msgarr['subject'] = '';
	}
	
	//DATELINE
	if(empty($rulearr['defaultdateline'])) {
		$msgarr['dateline'] = $_SGLOBAL['timestamp'];
	} else {
		$msgarr['dateline'] = intval($rulearr['defaultdateline']);
	}
	
	//信息来源识别
	if($getsubject && $nextprogress && !empty($rulearr['fromrule'])) {
		if(preg_match("/\[from\]/", $rulearr['fromrule'])) {
			$fromarr = pregmessage($messagetext, $rulearr['fromrule'], 'from');
		} else {
			$fromarr[0] = $rulearr['fromrule'];
		}
		$msgarr['itemfrom'] = $fromarr[0];
		if($msgarr['itemfrom']) {
			showprogress('['.$mnum.'] [<b>'.$msgarr['itemfrom'].'</b>] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_itemfrom'].'</b>'.$alang['robot_robot_success']);
		} else {
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.'<b>'.$alang['robot_robot_itemfrom'].'</b>'.$alang['robot_robot_failed']);
		}
	}
	//作者识别
	if($getsubject && $nextprogress && !empty($rulearr['authorrule'])) {
		if(preg_match("/\[author\]/", $rulearr['authorrule'])) {
			$authorarr = pregmessage($messagetext, $rulearr['authorrule'], 'author');
		} else {
			$rulearr['authorrule'] = explode('|', $rulearr['authorrule']);
			$rulearr['authorrule'] = strim($rulearr['authorrule']);
			if(is_array($rulearr['authorrule'])) {
				foreach($rulearr['authorrule'] as $tmpkey => $tmpvalue) {
					if(empty($tmpvalue)) {
						unset($rulearr['authorrule'][$tmpkey]);
					}
				}
				$tmprand = 0;
				$tmprand = rand(0, count($rulearr['authorrule'])-1);
				$authorarr[0] = $rulearr['authorrule'][$tmprand];
			} else {
				$authorarr[0] = $rulearr['authorrule'];
			}
		}
		$msgarr['author'] = $authorarr[0];
		if($msgarr['author']) {
			showprogress('['.$mnum.'] [<b>'.$msgarr['author'].'</b>] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_author'].'</b>'.$alang['robot_robot_success']);
		} else {
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_author'].'</b>'.$alang['robot_robot_failed']);
		}
	}
	//发布者UID
	if($getsubject && $nextprogress && !empty($rulearr['uidrule'])) {
		$rulearr['uidrule'] = explode('|', $rulearr['uidrule']);
		$rulearr['uidrule'] = strim($rulearr['uidrule']);
		if(is_array($rulearr['uidrule'])) {
			foreach($rulearr['uidrule'] as $tmpkey => $tmpvalue) {
				if(empty($tmpvalue)) {
					unset($rulearr['uidrule'][$tmpkey]);
				}
			}
			$tmprand = 0;
			$tmprand = rand(0, count($rulearr['uidrule'])-1);
			$msgarr['uid'] = intval($rulearr['uidrule'][$tmprand]);
		} else {
			$msgarr['uid'] = intval($rulearr['uidrule']);
		}
	}
	
	//文章内容识别
	if($nextprogress && !empty($rulearr['messagerule'])) {
		if(empty($rulearr['messagerule'])) {
			$rsmessagearr = getrobotmessage($messagetext, $msgurl, 2);
			$messagearr[0] = $rsmessagearr['leachmessage'];
		} else {
			$messagearr = pregmessage($messagetext, $rulearr['messagerule'], 'message');
		}
		$msgarr['message'] = $messagearr[0];
	}
	//文章内容过滤
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagefilter'])) {
		$rule = convertrule($rulearr['messagefilter']);
		$msgarr['message'] = preg_replace("/($rule)/s", '', $msgarr['message']);
	}
	//文章内容文字替换
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagereplace'])) {
		$rulearr['messagereplace'] = explode("\n", $rulearr['messagereplace']);
		$rulearr['messagereplaceto'] = explode("\n", $rulearr['messagereplaceto']);
		$msgarr['message'] = stringreplace($rulearr['messagereplace'], $rulearr['messagereplaceto'], $msgarr['message']);
	}
	//文章内容包含关键字
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagekey'])) {
		$rule = convertrule($rulearr['messagekey']);
		$newmessage = preg_replace("/($rule)/s", '', $msgarr['message']);
		if($newmessage == $msgarr['message']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' '.$alang['robot_robot_message_no_key']);
			$nextprogress = false;
			$msgarr['message'] = '';
		}					
	}
	//文章内容关键字剔除过滤
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagekeycancel'])) {
		$rule = convertrule($rulearr['messagekeycancel']);
		$newmessage = preg_replace("/($rule)/s", '', $msgarr['message']);
		if(md5($newmessage) != md5($msgarr['message'])) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' '.$alang['robot_robot_message_key_cancel']);
			$nextprogress = false;
			$msgarr['message'] = '';
		}					
	}
	//文章内容格式化
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messageformat'])) {
		$rsmessagearr = getrobotmessage($msgarr['message'], $msgurl);
		$msgarr['message'] = $rsmessagearr['leachmessage'];
	}
	
	if($nextprogress) {
		if($msgarr['message']) {
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message'].'</b>'.$alang['robot_robot_success']);
		} else {
			$msgarr['subject'] = '';
			$nextprogress = false;
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_message'].'</b>'.$alang['robot_robot_failed']);
		}
	}
	
	//LOCAL PIC URL
	if($nextprogress && (!empty($rulearr['picurllinkpre']) || $rulearr['savepic'])) {
		preg_match_all("/\<img\s+.*?src=[\'\"]*([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)[\'\"\s\>]+/is", $msgarr['message'], $picurlarr);
		if(!empty($picurlarr[1])) $msgarr['picarr'] = sarray_unique($picurlarr[1]);
		if(!empty($rulearr['picurllinkpre'])) {
			foreach($msgarr['picarr'] as $pickey => $picurl) {
				if(strpos($picurl, '://') === false) {
					$msgarr['picarr'][$pickey] = $rulearr['picurllinkpre'].$picurl;
					$msgarr['message'] = str_replace($picurl, $rulearr['picurllinkpre'].$picurl, $msgarr['message']);
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($msgurl);
			foreach ($msgarr['picarr'] as $pickey => $picurl) {
				if(!empty($picurl)) {
					$url = parse_url($picurl);
					if(!empty($url['host'])){
						$msgarr['picarr'][$pickey] = $picurl;
					} else {
						$offset = strpos($picurl, '/');
						if(!is_bool($offset) && $offset == 0){
							$msgarr['picarr'][$pickey] = $posturl['scheme'].'://'.$posturl['host'].$picurl;
						} else {
							$msgarr['picarr'][$pickey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$picurl;
						}
					}
					$msgarr['message'] = str_replace($picurl, $msgarr['picarr'][$pickey], $msgarr['message']);
				}
			}
		}
		if($rulearr['savepic']) {
			$msgarr = saveurlarr($msgarr, 'picarr');
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_picarr'].'</b>'.$alang['robot_robot_success']);
		}
	}
	
	//LOCAL FLASH URL
	if($nextprogress && (!empty($rulearr['picurllinkpre']) || $rulearr['saveflash'])) {
		preg_match_all("/\<embed\s+.*?src=[\'\"]*([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|])[\'\"\s\>]+/is", $msgarr['message'], $flashurlarr);
		if(!empty($flashurlarr[1])) $msgarr['flasharr'] = sarray_unique($flashurlarr[1]);
		if(!empty($rulearr['picurllinkpre'])) {
			foreach($msgarr['flasharr'] as $flashkey => $flashurl) {
				if(strpos($flashurl, '://') === false) {
					$msgarr['flasharr'][$flashkey] = $rulearr['picurllinkpre'].$flashurl;
					$msgarr['message'] = str_replace($flashurl, $rulearr['picurllinkpre'].$flashurl, $msgarr['message']);
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($msgurl);
			foreach ($msgarr['flasharr'] as $flashkey => $flashurl) {
				if(!empty($flashurl)) {
					$url = parse_url($flashurl);
					if(!empty($url['host'])){
						$msgarr['flasharr'][$flashkey] = $flashurl;
					} else {
						$offset = strpos($flashurl, '/');
						if(!is_bool($offset) && $offset == 0){
							$msgarr['flasharr'][$flashkey] = $posturl['scheme'].'://'.$posturl['host'].$flashurl;
						} else {
							$msgarr['flasharr'][$flashkey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$flashurl;
						}
					}
					$msgarr['message'] = str_replace($flashurl, $msgarr['flasharr'][$flashkey], $msgarr['message']);
				}
			}
		}
		if($rulearr['saveflash']) {
			$msgarr = saveurlarr($msgarr, 'flasharr');
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_flasharr'].'</b>'.$alang['robot_robot_success']);
		}
	}

	//PAGE URL
	if($getpage && $nextprogress && !empty($rulearr['messagepagerule'])) {
		$messagepagearr = pregmessage($messagetext, $rulearr['messagepagerule'], 'pagearea');
		$messagepage = $messagepagearr[0];
		if($messagepage && !empty($rulearr['messagepageurlrule'])) {
			$msgarr['pagearr'] = pregmessage($messagepage, $rulearr['messagepageurlrule'], 'page', -1);
			$msgarr['pagearr'] = sarray_unique($msgarr['pagearr']);
		}
		if($msgarr['pagearr']) {
			if(!empty($rulearr['messagepageurllinkpre'])) {
				foreach($msgarr['pagearr'] as $pkey => $purl) {
					if(strpos($purl, '://') === false) {
						$msgarr['pagearr'][$pkey] = $rulearr['messagepageurllinkpre'].$purl;
					}
				}
			} else {
				$url = array();
				$posturl = parse_url($msgurl);
				foreach($msgarr['pagearr'] as $pkey => $purl) {
					if(!empty($purl)) {
						$url = parse_url($purl);
						if(!empty($url['host'])){
							$msgarr['pagearr'][$pkey] = $purl;
						} else {
							$offset = strpos($purl, '/');
							if(!is_bool($offset) && $offset == 0){
								$msgarr['pagearr'][$pkey] = $posturl['scheme'].'://'.$posturl['host'].$purl;
							} else {
								$msgarr['pagearr'][$pkey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$purl;
							}
						}
					}
				}
			}
			if(!empty($rulearr['messagepageurllinkpf'])) {
				foreach ($msgarr['pagearr'] as $pkey => $purl) {
					if(!empty($purl)) {
						$msgarr['pagearr'][$pkey] = $purl.$rulearr['messagepageurllinkpf'];
					}
				}
			}
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_pagearr'].'</b>'.$alang['robot_robot_success']);
		} else {
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_pagearr'].'</b>'.$alang['robot_robot_failed']);
		}
	}
	return $msgarr;
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

/**
 * 转义字符串防子ＪＳ出错
 */
function convertstr($str, $delimiter = "'") {
	return preg_quote($str, $delimiter);
}

/**
 * 获取或生成采集地址
 */
function cacherobotlist($type, $url, $robotid, $sarray=array(), $varname='newurlarr') {
	global $alang;
	
	$cachefile = S_ROOT.'./data/robot/'.$robotid.'_'.md5($url).'.php';
	if($type == 'get') {
		if(file_exists($cachefile)) {
			include_once($cachefile);
			showprogress($alang['robot_robot_cache_read'].' ('.srealpath($cachefile).')', 1);	//srealpath是格式化URL地址
			return $$varname;
		} else {
			return false;
		}
	} else {
		$wtext = arrayeval($sarray);
		if(!@$fp = fopen($cachefile, 'w')) {
			showprogress($alang['robot_robot_cache_write_failed'].' ('.srealpath($cachefile).')', 1);	//缓存无法写入
		} else {
			$text = "<?php\n\n";
			$text .= '$'.$varname.'=';
			$text .= $wtext;
			$text .= "\n\n?>";
			flock($fp, 2);
			fwrite($fp, $text);
			fclose($fp);
			showprogress($alang['robot_robot_cache_write_success'].' ('.srealpath($cachefile).')', 1);
		}
	}
	
}

function clearrobotcache($robotid) {
	
	$cachedir = S_ROOT.'./data/robot';
	if(is_dir($cachedir)) {
		$adir = dir($cachedir);
		while (false !== ($entry = $adir->read())) {
			if(preg_match("/^(".$robotid."_)/", $entry)) {
				$entry = $cachedir.'/'.$entry;
				@unlink($entry);
			}
		}
	}
}

function saveurlarr($msgarr, $varname) {
	global $_SGLOBAL;
	global $thevalue, $_SCONFIG;
	
	include_once(S_ROOT.'./function/upload.func.php');
	$isimage = 0;
	if($varname == 'picarr') {
		$isimage = 1;
	}
	if(!empty($msgarr[$varname]) && is_array($msgarr[$varname])) {
		foreach ($msgarr[$varname] as $ukey => $url) {
			if($isimage) {
				$patharr = saveremotefile($url, $_SCONFIG['thumbarray']['news']);
			} else {
				$patharr = saveremotefile($url, array(), 0);
			}
			$subject = strtolower(trim(substr($patharr['name'], 0, strrpos($patharr['name'], '.'))));
			$msgarr['patharr'][] = array(
					'uid' => $_SGLOBAL['supe_uid'],
					'dateline' => $_SGLOBAL['timestamp'],
					'catid' => $msgarr['importcatid'],
					'itemid' => 0,
					'filename' => saddslashes($patharr['name']),
					'subject' => trim(shtmlspecialchars($subject)),
					'attachtype' => $patharr['type'],
					'type' => 'news',
					'isimage' => (in_array($patharr['type'], array('jpg','jpeg','gif','png'))?1:0),
					'size' => $patharr['size'],
					'filepath' => $patharr['file'],
					'thumbpath' => $patharr['thumb'],
					'isavailable' => 1,
					'hash' => ''
				);
			if(!empty($patharr['file'])) {
				$msgarr['message'] = str_replace($url, A_URL.'/'.$patharr['file'], $msgarr['message']);
				$msgarr[$varname][$ukey] = str_replace($url, A_DIR.'/'.$patharr['file'], $msgarr[$varname][$ukey]);
			}
		}
	}
	return $msgarr;
}

function striptbr($text) {
	$text = preg_replace("/(\r\n|\r|\n)/s", '*', $text);
	$text = str_replace('**', '*', $text);
	return $text;
}

function printruledebug($infoarr) {
	global $alang;
	$rule = '';
	if(is_array($infoarr['code'])) {
		$infoarr['code'] = implode("\n", $infoarr['code']);
	}
	if(!empty($infoarr['code'])) {
		showprogress($alang['robot_debug_regional_source'], 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$infoarr['code'].'</textarea>');
	} else {
		showprogress($alang['robot_debug_not_content'], 1);
	}
	$rule = shtmlspecialchars(getregularstring($infoarr['rule'], 'from'));
	showprogress($alang['robot_debug_url'], 1);
	showprogress('<input type="text" style="width: 95%" value="'.$infoarr['url'].'">');
	showprogress($alang['robot_debug_regular'], 1);
	showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
	showprogress($alang['robot_debug_source_code'], 1);
	showprogress('<textarea style="width:95%;" rows="7">'.shtmlspecialchars($infoarr['source']).'</textarea>');
	exit();
}

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

//导出文件
function exportfile($array, $filename) {
	global $_SGLOBAL, $_SCONFIG;
	global $_SERVER;

	$array['version'] = strip_tags(S_VER);
	$time = sgmdate($_SGLOBAL['timestamp']);
	$exporttext = "# SupeSite Dump\r\n".
	"# Version: SupeSite ".S_VER."\r\n".
	"# Time: $time\r\n".
	"# From: $_SCONFIG[sitename] (".S_URL.")\r\n".
	"#\r\n".
	"# This file was BASE64 encoded\r\n".
	"#\r\n".
	"# SupeSite: http://www.supesite.com\r\n".
	"# Please visit our website for latest news about SupeSite\r\n".
	"# --------------------------------------------------------\r\n\r\n\r\n".
	wordwrap(base64_encode(serialize($array)), 50, "\r\n", 1);

	obclean();
	header('Content-Encoding: none');
	header('Content-Type: '.(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
	header('Content-Disposition: attachment; filename="'.$filename.'.txt"');
	header('Content-Length: '.strlen($exporttext));
	header('Pragma: no-cache');
	header('Expires: 0');

	echo $exporttext;
	exit;
}
?>