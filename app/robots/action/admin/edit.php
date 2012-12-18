<?php

switch ($ts) {
	
	case "" :
		$robotid = $_GET ['robotid'];
		$thevalue = $arrRobot = aac ( 'robots' )->find ( 'robots', array (
				'robotid' => $robotid 
		) );
		//获取资讯分类 //暂时只有管理员uid指定
		$arrChannel = aac('article')->findAll('article_channels');
		$arrSelect = '';//初始化下拉列表
		$arrCatename = array();
		foreach ($arrChannel as $key=>$item)
		{
			$arrCatename = aac('article')->find('article_categories',array('type'=>$item['nameid']));
			if($thevalue['importcatid']==$arrCatename['catid'])
			{
				$ischecked = "selected";
			}else{
				$ischecked = "";
			}
			$arrSelect .='<optgroup label="'.$item['name'].'">';
			$arrSelect .='<option '.$ischecked.' value="'.$arrCatename['type'].'_'.$arrCatename['catid'].'" >'.$arrCatename['name'].'</option>';
			$arrSelect .='</optgroup>';
		}
		if ($thevalue) {
			//先初始化url
			$thevalue ['listurl_manual'] = $thevalue ['listurl_auto'] = '';
			if($thevalue ['listurltype'] == 'new') {
				$thevalue ['listurl'] = unserialize ( $thevalue ['listurl'] );
				$thevalue ['listurl_manual'] = $thevalue ['listurl'] ['manual'];
				$thevalue ['listurl_auto'] = $thevalue ['listurl'] ['auto'];
			}
			$thevalue ['listurl'] = '';
			$thevalue ['defaultdateline'] = sgmdate ( $thevalue ['defaultdateline'] );
			if (! empty ( $thevalue ['listurl_manual'] )) {
				foreach ( $thevalue ['listurl_manual'] as $tmpkey => $tmpvalue ) {
					$tmpvalue = trim ( $tmpvalue );
					if (! empty ( $tmpvalue )) {

						$thevalue['listurl'] .= '<div id="url_s'.$tmpkey.'">';
						$thevalue['listurl'] .= $tmpvalue;
						$thevalue['listurl'] .= ' <a href="javascript:;" onclick="$(this).parent().remove();">删除</a>
						<input id="listurl_manual[]" type="text" name="listurl_manual[]" size="5" style="display: none;" value="'.$tmpvalue.'"/></div>';
											
					}
				}
			}
			$thevalue ['listurl_manual'] = $thevalue ['listurl'];
			$thevalue ['subjectreplace'] = explode ( "\n", $thevalue ['subjectreplace'] );
			$thevalue ['subjectreplaceto'] = explode ( "\n", $thevalue ['subjectreplaceto'] );
			$thevalue ['messagereplace'] = explode ( "\n", $thevalue ['messagereplace'] );
			$thevalue ['messagereplaceto'] = explode ( "\n", $thevalue ['messagereplaceto'] );

			/*
			 * if ($_GET ['op'] == 'copy') { // 复制采集器的初始值 $thevalue ['robotid']
			 * = 0; }
			 */
		
		} else {
			qiMsg ( "配置不存在" );
		}
		include template ( 'admin/add' );
		break;

}
