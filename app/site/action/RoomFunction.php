<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
//排序
function sortMod($mod)
{
		$strMods = array();
		foreach($mod as $key => $item)
		{
			$item = explode('-',$item); // $item[0]  表名 $item[1] 数据id
			//公告栏
			if($item[0]=='bulletin')
			{
				$tables = aac('site')->find('site_bulletin', array('bulletinid'=>$item[1], 'isarchive'=>'0'));
				if(!empty($tables))
				{
					$str = $tables['content'];
					preg_match_all ( '/\[(url)=([http|https|ftp]+:\/\/[a-zA-Z0-9\.\-\?\=\_\&amp;\/\'\`\%\:\@\^\+\,\.]+)\]([^\[]+)(\[\/url\])/is', 
					$str, $content);
					foreach($content[2] as $c1)
					{
						$str = str_replace ( "[url={$c1}]", '<a href="'.$c1.'" target="_blank">', $str);
						$str = str_replace ( "[/url]", '</a>', $str);
					}
					
					$strMods[$key]['table']  =  'bulletin';
					$strMods[$key]['itemid'] = $item[1];
					$strMods[$key]['title']  = $tables['title'];
					$strMods[$key]['settingurl'] = '<a href="#" rel="'.SITE_URL.tsUrl('site','bulletin',array('ts'=>'settings','bulletinid'=>$item[1])).'" class="a_lnk_mod_setting">设置</a>';
					$strMods[$key]['action']  = '<a href="'.SITE_URL.tsUrl('site','bulletin',array('ts'=>'update','bulletinid'=>$item[1])).'">修改</a>';	
					$strMods[$key]['content'] = $str;
				}
			}
			//日记
			if($item[0]=='notes')
			{
				$tables = aac('site')->find('site_notes', array('notesid'=>$item[1],'isarchive'=>'0')); 
				if(!empty($tables))
				{
					$display_number = $tables['display_number'];
					$strMods[$key]['table']  =  'notes';
					$strMods[$key]['itemid'] = $item[1];
					$strMods[$key]['title']  = $tables['title'];
					$strMods[$key]['settingurl'] = '<a href="#" rel="'.SITE_URL.tsUrl('site','notes',array('ts'=>'settings','notesid'=>$item[1])).'" class="a_lnk_mod_setting">设置</a>';								
					$strMods[$key]['list'] = '<a href="'.SITE_URL.tsUrl('site','notes',array('ts'=>'list','notesid'=>$item[1])).'">全部</a>';
					$strMods[$key]['action']  = '<a href="'.SITE_URL.tsUrl('site','notes',array('ts'=>'create','notesid'=>$item[1])).'">添加新日记</a>';	
					$strMods[$key]['content'] = aac('site')->findAll('site_notes_content',
								array('notesid'=>$item[1]),'addtime desc', '','0,'.$display_number.'');
					//图片问题							
				}
			}
			//论坛
			if($item[0]=='forum')
			{
				$tables = aac('site')->find('site_forum', array('forumid'=>$item[1], 'isarchive'=>'0'));
				if(!empty($tables))
				{
					$display_number = $tables['display_number'];
					$strMods[$key]['table']  = $item[0];
					$strMods[$key]['itemid'] = $item[1];
					$strMods[$key]['title']  = $tables['title'];
					$strMods[$key]['settingurl'] = '<a href="#" rel="'.SITE_URL.tsUrl('site','forum',array('ts'=>'settings',
					'forumid'=>$item[1])).'" class="a_lnk_mod_setting">设置</a>';									
					$strMods[$key]['list'] = '<a href="'.SITE_URL.tsUrl('site','forum',
							array('ts'=>'list','forumid'=>$item[1])).'">全部</a>';
							
					$strMods[$key]['action']  = '<a href="'.SITE_URL.tsUrl('site','forum',
							array('ts'=>'create','forumid'=>$item[1])).'">发言</a>';	
							
					$strMods[$key]['content'] = aac('site')->findAll('site_forum_discuss',
							array('forumid'=>$item[1]),'istop desc,addtime desc', '','0,'.$display_number.'');				
				}
					
			}
			//个人相册
			if($item[0]=='photos')
			{
				$tables = aac('site')->find('site_photos', array('photosid'=>$item[1], 'isarchive'=>'0'));
				if(!empty($tables))
				{
					$display_number = $tables['display_number'];
					$strMods[$key]['table']  = $item[0];
					$strMods[$key]['itemid'] = $item[1];
					$strMods[$key]['title']  = $tables['title'];
					$strMods[$key]['settingurl'] = '<a href="#" rel="'.SITE_URL.tsUrl('site','photos',array('ts'=>'settings',
					'photosid'=>$item[1])).'" class="a_lnk_mod_setting">设置</a>';									
					$strMods[$key]['list'] = '<a href="'.SITE_URL.tsUrl('site','photos',
							array('ts'=>'list','photosid'=>$item[1])).'">全部</a>';
							
					$strMods[$key]['action']  = '<a href="'.SITE_URL.tsUrl('site','photos',
							array('ts'=>'upload','photosid'=>$item[1])).'">添加照片</a>';	
							
					$strMods[$key]['content'] = aac('site')->findAll('site_photos_pic',
							array('photosid'=>$item[1]),'addtime desc', '','0,'.$display_number.'');				
				}
					
			}			
			
		}
		return $strMods;	
}
	 
