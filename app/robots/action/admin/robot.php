<?php

$theurl = SITE_URL."index.php?app=robots&ac=admin";
include_once('robot.func.php');

switch ($ts) {
	
	case "" :

		// 采集处理
		@ini_set ( 'max_execution_time', 2000 ); // 设置超时时间
		$robotid = $_GET['robotid'];
		empty ( $_GET ['lpage'] ) ? $lpage = 0 : $lpage = $_GET ['lpage']; // 列表页的页数
		empty ( $_GET ['mpage'] ) ? $mpage = 0 : $mpage = $_GET ['mpage']; // 页面的分页数
		empty ( $_GET ['mnum'] ) ? $mnum = 0 : $mnum = $_GET ['mnum']; // 当前页面分页数
		empty ( $_GET ['status'] ) ? $status = 0 : $status = $_GET ['status']; // 当次采集个数
		
		//ONE VIEW FOR UPDATE
		$thevalue = aac('robots')->find('robots',array('robotid'=>$robotid));
		if($thevalue) {
			showprogress('<font color=green>采集机器人开始工作</font>',1);
		} else {
			qiMsg('指定的采集机器人不存在.');
		}
		
		$listurlarr = $listurlarr2 = array (); // 初始采集页面数组
		// 对采集数组进行整理
		$thevalue ['listurl_manual'] = $thevalue ['listurl_auto'] = '';	
	
		//定义 new
		if ($thevalue ['listurltype'] == 'new') {
			$thevalue ['listurl'] = unserialize ( $thevalue ['listurl'] );
			$thevalue ['listurl_manual'] = $thevalue ['listurl'] ['manual'];
			$thevalue ['listurl_auto'] = $thevalue ['listurl'] ['auto'];
		}
		


		$urlorder = 0;
		if (! empty ( $thevalue ['listurl_auto'] )) {
			$thevalue ['autotype'] = ! empty ( $thevalue ['autotype'] ) && intval ( $thevalue ['autotype'] ) == 2 ? 2 : 1;
			$thevalue ['listpagestart'] = ! empty ( $thevalue ['autotype'] ) && $thevalue ['autotype'] == 1 ? intval ( $thevalue ['listpagestart'] ) : ord ( $thevalue ['listpagestart'] );
			$thevalue ['listpageend'] = ! empty ( $thevalue ['autotype'] ) && $thevalue ['autotype'] == 1 ? intval ( $thevalue ['listpageend'] ) : ord ( $thevalue ['listpageend'] );
			$thevalue ['wildcardlen'] = ! empty ( $thevalue ['wildcardlen'] ) ? intval ( $thevalue ['wildcardlen'] ) : 0;
			if ($thevalue ['listpagestart'] > $thevalue ['listpageend']) {
				$urlorder = $thevalue ['listpagestart'];
				$thevalue ['listpagestart'] = $thevalue ['listpageend'];
				$thevalue ['listpageend'] = $urlorder;
				$urlorder = 1;
			}
			for($i = $thevalue ['listpagestart']; $i <= $thevalue ['listpageend']; $i ++) {
				$strreplace = $i;
				if (! empty ( $thevalue ['wildcardlen'] ) && $thevalue ['autotype'] == 1) {
					$strreplace = str_pad ( $i, $thevalue ['wildcardlen'], 0, STR_PAD_LEFT );
				} elseif ($thevalue ['autotype'] == 2) {
					$strreplace = chr ( $i );
				}
				if ($thevalue ['autotype'] == 1 || ($thevalue ['autotype'] == 2 && preg_match ( "/[a-z]/i", $strreplace ))) {
					$listurlarr2 [] = preg_replace ( "/\[page\]/", $strreplace, $thevalue ['listurl_auto'] );
				}
			}
			if ($urlorder == 1)
				krsort ( $listurlarr2 );
		}
		if (! empty ( $thevalue ['listurl_manual'] )) {
			$listurlarr = $thevalue ['listurl_manual'];
		}
		if ($urlorder == 0) {
			$listurlarr = array_merge ( $listurlarr, $listurlarr2 );
		} else {
			$listurlarr = array_merge ( $listurlarr2, $listurlarr );
		}
		
		if (! empty ( $listurlarr )) {
			// LIST CACHE
			$listcache = false;
		
			// GET LIST TEXT
			$listtext = '';
			if ($lpage < count ( $listurlarr )) {
				$lurl = trim ( $listurlarr [$lpage] );
				// 显示采集地址
				showprogress ( '处理索引列表页面 <a href="' . $lurl . '" target="_blank">' . $lurl . '</a> 开始' );
				if (empty ( $_GET ['clearcache'] )) {
					$newurlarr = cacherobotlist ( 'get', $lurl, $_GET ['robotid'] ); // 获取采集列表缓存
				} else {
					$newurlarr = array ();
				}
				if ($newurlarr) {
					$listcache = true;
				} else {
					$lurl = encodeconvert ( $thevalue ['encode'], $lurl, 1 );
					$listtext = geturlfile ( $lurl ); // 获取索引列表
					$newurlarr = array ();
				}
			} else {
				showprogress ('处理索引列表页面结束' );
			}
		 
			// GET SUBJECT URL LIST
			$subjecturl = array ();
			if (! $listcache && ! empty ( $listtext )) {
				showprogress ('处理索引列表页面内容结束' );
				// 列表区域识别
				if (empty ( $thevalue ['subjecturlrule'] )) {
					$subjecturlarr [0] = $listtext; // $listtext 网页源码
				} else {
					$subjecturlarr = pregmessage ( $listtext, $thevalue ['subjecturlrule'], 'list' ); // 解析列表区域
				}
				$subjecturl = $subjecturlarr [0];
			}
			if (! $listcache && ! empty ( $subjecturl )) {
				showprogress ( '处理处理索引列表页面 <b style="color:green">链接区域成功</b>' );
				// 文章链接URL识别
				$urlarr = array ();
				if (empty ( $thevalue ['subjecturllinkrule'] )) {
					$subjecturl = preg_replace ( array (
							"/[\n\r]+/",
							"/\<\/a\>/i",
							"/\<a/i"
					), array (
							'',
							"</a>\n",
							"\n<a"
					), $subjecturl );
					preg_match_all ( "/\<a.+href=('|\"|)?([^\s\<\>]*)(\\1)([\s].*)?\>(.*)\<\/a\>/i", $subjecturl, $ahreftemp );
					$urlarr = sarray_unique ( $ahreftemp [2] ); // 去重
				} else {
					$urlarr = pregmessage ( $subjecturl, $thevalue ['subjecturllinkrule'], 'url', - 1 ); // 解析上步过虑后的结果
				}
		
				if (! empty ( $urlarr )) {
					showprogress ( '处理处理索引列表页面 <b style="color:green">链接成功</b>' );
					// 文章链接URL剔除
					if (! empty ( $thevalue ['subjecturllinkcancel'] )) {
						$tmparr = array ();
						$rule = '(' . convertrule ( $thevalue ['subjecturllinkcancel'] ) . ')';
						foreach ( $urlarr as $tmpvalue ) {
							if (! preg_match ( "/$rule/i", $tmpvalue )) {
								$tmparr [] = $tmpvalue;
							}
						}
						$urlarr = $tmparr;
					}
					// 文章链接URL过滤
					if (! empty ( $thevalue ['subjecturllinkfilter'] )) {
						$tmparr = array ();
						$rule = '(' . convertrule ( $thevalue ['subjecturllinkfilter'] ) . ')';
						foreach ( $urlarr as $tmpvalue ) {
							$tmparr [] = trim ( preg_replace ( "/$rule/s", '', $tmpvalue ) );
						}
						$urlarr = $tmparr;
					}
					// 整理完整的文章页地址
					// 文章链接URL补充前缀
					if (! empty ( $thevalue ['subjecturllinkpre'] )) {
						foreach ( $urlarr as $tmpkey => $tmpvalue ) {
							if (! empty ( $tmpvalue )) {
								if (strpos ( $tmpvalue, '://' ) === false) {
									$urlarr [$tmpkey] = $thevalue ['subjecturllinkpre'] . $tmpvalue;
								} elseif (strpos ( $tmpvalue, '://' ) > 10) {
									$urlarr [$tmpkey] = $thevalue ['subjecturllinkpre'] . $tmpvalue;
								}
							}
						}
					} else {
						$url = array ();
						$posturl = parse_url ( $lurl );
						foreach ( $urlarr as $tmpkey => $tmpvalue ) {
							if (! empty ( $tmpvalue )) {
								$url = parse_url ( $tmpvalue );
								if (! empty ( $url ['host'] )) {
									$urlarr [$tmpkey] = $tmpvalue;
								} else {
									$offset = strpos ( $tmpvalue, '/' );
									if (! is_bool ( $offset ) && $offset == 0) {
										$urlarr [$tmpkey] = $posturl ['scheme'] . '://' . $posturl ['host'] . $tmpvalue;
									} else {
										$urlarr [$tmpkey] = substr ( $lurl, 0, strrpos ( $lurl, '/' ) ) . '/' . $tmpvalue;
									}
								}
							}
						}
					}
					// 文章链接URL补充后缀
					if (! empty ( $thevalue ['subjecturllinkpf'] )) {
						foreach ( $urlarr as $tmpkey => $tmpvalue ) {
							if (! empty ( $tmpvalue )) {
								$urlarr [$tmpkey] = $tmpvalue . $thevalue ['subjecturllinkpf'];
							}
						}
					}
					$newurlarr = sarray_unique ( $urlarr ); // 过滤重复的值，并修整数组
					if ($thevalue ['reverseorder']) {
						krsort ( $newurlarr );
						$newurlarr = array_merge ( array (), $newurlarr ); // 利用合并的方式重新编排数组键名
					}
				}
			}
	
			if (! empty ( $newurlarr )) {
				$thevalue ['pernum'] = empty ( $thevalue ['pernum'] ) ? 5 : $thevalue ['pernum'];
				$thevalue ['allnum'] = empty ( $thevalue ['allnum'] ) ? 65535 : $thevalue ['allnum'];
				if (! $listcache)
					cacherobotlist ( 'make', $lurl, $_GET ['robotid'], $newurlarr ); // 生成文章列表数列表URL地址
			
				while ( true ) { // 死循环采集文章
					$nextpage = false;
					if ($mpage >= count ( $newurlarr )) { // 文章列表页数是否大于单个索引页整理出来的文章列表总数
						$lpage ++; // 索引页累加1跳到下 一个索引页执行
						// 判断是否超过索引列表了，如果越界了，则退出死循环
						if ($lpage < count ( $listurlarr )) {
							$mpage = 0;
							// LIST NUM
							showprogress ('当前索引页面文章采集完毕，进入下一个索引页面');
							$jumptourl = $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&clearcache=1&status=' . $status;
							showprogress ( '<a href="' . $jumptourl . '">'.'<b>正在采集下一个文章列表...</b></a>', 1 );
							jumpurl ( $jumptourl, 1 );
						} else {
							break;
						}
					} else {
						// 判断是否该跳到下一页执行了
						if ($mpage % $thevalue ['pernum'] == $thevalue ['pernum'] - 1) {
							$nextpage = true;
						}
						$msgurl = $newurlarr [$mpage]; // 采集文章的url
		
						$gotonext = true;
		
						// PAGE
						// 对文章分页的采集处理
						if (! empty ( $_GET ['pageurl'] )) {
							$pagekey = $_GET ['pagekey'];
							$pageurl = $_GET ['pageurl'];
							$itemid = $_GET ['itemid'];
							$pageurl = encodeconvert ( $thevalue ['encode'], $pageurl, 1 );
							$messagemsgtext = geturlfile ( $pageurl );
							$msgmsgarr = pregmessagearray ( $messagemsgtext, $thevalue, $mnum, 1, 0, $pageurl );
							if (! empty ( $msgmsgarr ['message'] ))
								$itemid = messageaddtodb ( $msgmsgarr, $_GET ['robotid'], $itemid );
							if (empty ( $msgmsgarr ['pagearr'] [0] )) {
								$gotonext = false;
								$_GET ['pagekey'] = $_GET ['pageurl'] = '';
							} else {
								$pageurl = $msgmsgarr ['pagearr'] [0];
								showprogress ( '[' . $mnum . '] ' . '[' . $pagekey . '] 处理<b>文章分页页面</b>完成', 1 );
								$pagekey ++;
								include_once template ( 'admin/tpl/footer.htm', 1 );
								jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '&itemid=' . $itemid . '&pagekey=' . $pagekey . '&pageurl=' . rawurlencode ( $pageurl ), 1 );
							}
						} elseif (! empty ( $_GET ['pagekey'] )) {
							$pagekey = $_GET ['pagekey'];
							$itemid = $_GET ['itemid'];
							$pagearr = cacherobotlist ( 'get', $msgurl, $_GET ['robotid'], array (), 'pagearr' );
							if (empty ( $pagearr [$pagekey - 1] )) {
								$gotonext = false;
								$_GET ['pagekey'] = '';
							} else {
								$pageurl = $pagearr [$pagekey - 1];
								$pageurl = encodeconvert ( $thevalue ['encode'], $pageurl, 1 );
								$messagemsgtext = geturlfile ( $pageurl );
								$msgmsgarr = pregmessagearray ( $messagemsgtext, $thevalue, $mnum, 0, 0, $pageurl );
								if (! empty ( $msgmsgarr ['message'] ))
									$itemid = messageaddtodb ( $msgmsgarr, $_GET ['robotid'], $itemid );
								showprogress ( '[' . $mnum . '] ' . '[' . $pagekey . '] 处理文章分页页面成功', 1 );
								$pagekey ++;
								include_once template ( 'admin/tpl/footer.htm', 1 );
								jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '&itemid=' . $itemid . '&pagekey=' . $pagekey, 1 );
							}
						}
		
						// MESSAGE
						if ($gotonext) {
							$msgurl = encodeconvert ( $thevalue ['encode'], $msgurl, 1 );
							$messagetext = geturlfile ( $msgurl ); // 获取指定URL地址的文章内容
						} else {
							$messagetext = '';
						}
						if (! empty ( $messagetext )) {
							showprogress ( '<font color=green> 处理内容  <a href="' . $msgurl . '" target="_blank">' . $msgurl . '</a> ' . '成功</font>', 1 );
								
							// 采集次数累加1并结整采集程序
							if (empty ( $status )) {
								$times = $_SGLOBAL ['timestamp'];
								$db->query("update ".dbprefix."robots set `lasttime`='$times',`robotnum`='robotnum+1' where `robotid`='$robotid'");
								$status = 1;
							}
								
							$msgarr = pregmessagearray ( $messagetext, $thevalue, $mnum, 1, 1, $msgurl ); // 解析文章内容
							if (! empty ( $msgarr ['subject'] ) && ! empty ( $msgarr ['message'] )) {
								// 插入到库中
								$itemid = messageaddtodb ( $msgarr, $_GET ['robotid'], 0 );
								$mnum ++;
							} else {
								$mnum ++;
							}
							
							
								
							// 对文章列表页的处理
							if (! empty ( $msgarr ['pagearr'] ) && $thevalue ['messagepagetype'] == 'page') {
								cacherobotlist ( 'make', $msgurl, $_GET ['robotid'], $msgarr ['pagearr'], 'pagearr' );
								
								jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '&itemid=' . $itemid . '&pagekey=1', 1 );
							} elseif (! empty ( $msgarr ['pagearr'] ) && $thevalue ['messagepagetype'] == 'next') {
								$pageurl = $msgarr ['pagearr'] [0];
								//include_once template ( 'admin/tpl/footer.htm', 1 );
								jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '&itemid=' . $itemid . '&pagekey=1&pageurl=' . rawurlencode ( $pageurl ), 1 );
							}
								
							// ALL NUM
							// 判断采集总数是否超过了允许的采集总数
							if ($mnum >= $thevalue ['allnum']) {
								showprogress ('采集文章总数目已经达到最大限制'. ' (' . $mnum . ') ' . '结束', 1 );
								$lpage = count ( $listurlarr ) + 1;
								//include_once template ( 'admin/tpl/footer.htm', 1 );
								jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum, 1 );
							}
		
						} elseif ($gotonext) {
							showprogress ( '处理<b>内容 (<a href="' . $msgurl . '" target="_blank">' . $msgurl . '</a>) ' . '</b>失败', 1 );
						}
					}
					$mpage ++;
					if ($nextpage) {
						// PER NUM
						showprogress ( '单次采集数目达到最大限制，进入下一个采集操作' . ' (' . $thevalue ['pernum'] . ')', 1 );
						showprogress ( '<a href="' . $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '"><b>' . '正在采集下一个文章列表...' . "</b></a>", 1 );
						//include_once template ( 'admin/tpl/footer.htm', 1 );
						jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status, 1 );
					}
				}
			} else {
				$lpage ++;
				if ($lpage < count ( $listurlarr )) {
					$mpage = 0;
					// LIST NUM
					showprogress ( '当前索引页面文章采集完毕，进入下一个索引页面' );
					showprogress ( '<a href="' . $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status . '"><b>' . '正在采集下一个文章列表...' . "</b></a>", 1 );
					//include_once template ( 'admin/tpl/footer.htm', 1 );
					jumpurl ( $theurl . '&mg=robot&robotid=' . $_GET ['robotid'] . '&lpage=' . $lpage . '&mpage=' . $mpage . '&mnum=' . $mnum . '&status=' . $status, 1 );
				}
			} 
		} else {
			showprogress ( '无法链接到指定的URL地址', 1 );
		}
		
		showprogress ( '<a href="' . CPURL . '?action=robotmessages&robotid=' . $_GET ['robotid'] . '">' . '采集完成，点击此处查看采集结果' . '</a>', 1 );
		$listarr = array ();
		$thevalue = array ();
		$importvalue = array ();
				
		break;

}

                                                          


