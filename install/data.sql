DROP TABLE IF EXISTS `ik_site`,`ik_site_theme`,`ik_site_room`,`ik_note`, `ik_note_cate`, `ik_note_comment`, `ik_area`, `ik_article`, `ik_article_cate`, `ik_article_comment`, `ik_attach`, `ik_event`, `ik_event_comment`, `ik_event_group_index`, `ik_event_type`, `ik_event_users`, `ik_feed`, `ik_group`, `ik_group_cates`, `ik_group_cates_index`, `ik_group_links`, `ik_group_options`, `ik_group_topics`, `ik_group_topics_collects`, `ik_group_topics_comments`, `ik_group_topics_type`, `ik_group_users`, `ik_home_info`, `ik_mail_options`, `ik_message`, `ik_photo`, `ik_photo_album`, `ik_photo_comment`, `ik_photo_options`, `ik_search_key`, `ik_system_options`, `ik_tag`, `ik_tag_site_index`, `ik_tag_note_index`, `ik_tag_article_index`, `ik_tag_group_index`, `ik_tag_topic_index`, `ik_tag_user_index`, `ik_user`, `ik_user_follow`, `ik_user_info`, `ik_user_invites`, `ik_user_options`, `ik_user_role`, `ik_user_scores`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `12ik`
--


--
-- 表的结构 `ik_site`
--

CREATE TABLE IF NOT EXISTS `ik_site` (
  `siteid` int(11) NOT NULL AUTO_INCREMENT COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sitename` char(64) NOT NULL DEFAULT '' COMMENT '小站名称',
  `sitedesc` text NOT NULL COMMENT '小站描述',
  `iconpath` char(32) NOT NULL DEFAULT '' COMMENT '小站图标路径',
  `siteicon` char(64) NOT NULL DEFAULT '' COMMENT '小站图标', 
  `imgpos` char(64) NOT NULL DEFAULT '' COMMENT '截取图片坐标',     
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '展示数',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `isaction` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许互动 1默认不允许',  
  `istheme` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有自定义风格',
  `issetting` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否第一次访问',
  `isfollow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注小站的广播更新 0默认关注 1不关注',      
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 推荐 0 不推荐',       
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_site_follow`
--

CREATE TABLE IF NOT EXISTS `ik_site_follow` (
  `followid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `follow_siteid` int(11) NOT NULL DEFAULT '0' COMMENT '被关注的小站ID',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`followid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关注的小站';

--
-- 转存表中的数据 `ik_site_follow`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_site_theme`
--

CREATE TABLE IF NOT EXISTS `ik_site_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '风格ID',
  `theme_id` int(11) NOT NULL DEFAULT '0' COMMENT '模板ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `background_ver` int(11) NOT NULL DEFAULT '0' COMMENT '版本ID',
  `background_pos` char(32) DEFAULT '' COMMENT '背景位置',
  `background_repeat` char(32) DEFAULT '' COMMENT '背景重复',
  `background_cancel` char(32) DEFAULT '' COMMENT '是否显示背景图',
  `background_color` char(32) DEFAULT '' COMMENT '背景颜色',
  `banner_color` char(32) DEFAULT '' COMMENT '顶部横幅背景',
  `tab_color` char(32) DEFAULT '' COMMENT '顶部标签背景',
  `tab_link_color` char(32) DEFAULT '' COMMENT '顶部标签文字颜色',
  `link_color` char(32) DEFAULT '' COMMENT '页面链接颜色',
  `biz_theme` char(32) DEFAULT '' COMMENT 'biz模板',
  `bg_fixed` char(32) DEFAULT '' COMMENT '背景固定或滚动',
  `logo_color` char(32) DEFAULT '' COMMENT 'logo颜色',
  `banner_transparent` char(32) DEFAULT '' COMMENT '背景透明', 
  `background_path` char(32)  DEFAULT '' COMMENT '背景图路径',
  `background_image` char(64)  DEFAULT '' COMMENT '背景图',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- 表的结构 `ik_site_archive`
--

CREATE TABLE IF NOT EXISTS `ik_site_archive` (
  `archiveid` int(11) NOT NULL AUTO_INCREMENT COMMENT '存档ID',
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `widgetid` int(11) NOT NULL DEFAULT '0' COMMENT '组件内容ID',
  `widgetname` char(64) NOT NULL DEFAULT '' COMMENT '组件别名',  
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间', 
  PRIMARY KEY (`archiveid`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `ik_site_room`
--

CREATE TABLE IF NOT EXISTS `ik_site_room` (
  `roomid` int(11) NOT NULL AUTO_INCREMENT COMMENT '房间ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `count_widget` int(11) NOT NULL DEFAULT '0' COMMENT '组件数量',  
  `name` char(64) NOT NULL DEFAULT '未命名房间' COMMENT '房间名称',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`roomid`),
  KEY `userid` (`userid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `ik_site_room_navorder`
--

CREATE TABLE IF NOT EXISTS `ik_site_room_navorder` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT COMMENT '排序ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `ordertext` char(64) NOT NULL DEFAULT '0' COMMENT '导航序列',
  PRIMARY KEY (`orderid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `ik_site_bulletin`
--

CREATE TABLE IF NOT EXISTS `ik_site_bulletin` (
  `bulletinid` int(11) NOT NULL AUTO_INCREMENT COMMENT '公告ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '应用名',
  `content` text NOT NULL DEFAULT '' COMMENT '内容',    
  `isarchive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有存档',
  `addtime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`bulletinid`),
  KEY `userid` (`userid`),
  KEY `siteid` (`siteid`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `ik_site_forum`
--

CREATE TABLE IF NOT EXISTS `ik_site_forum` (
  `forumid` int(11) NOT NULL AUTO_INCREMENT COMMENT '论坛ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '应用名',
  `isarchive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有存档',
  `display_number` int(11) NOT NULL DEFAULT '10' COMMENT '显示个数',       
  `addtime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`forumid`),
  KEY `siteid` (`siteid`),
  KEY `userid` (`userid`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------
--
-- 表的结构 `ik_site_photos`
--
CREATE TABLE IF NOT EXISTS `ik_site_photos` (
  `photosid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '应用名',
  `isarchive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有存档',
  `layout_type` char(64) NOT NULL DEFAULT 'A' COMMENT '显示方式',   
  `order` char(64) NOT NULL DEFAULT 'false' COMMENT '显示顺序',   
  `display_raw` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示原图 0可看 1不可看',    
  `need_watermark` tinyint(1) NOT NULL DEFAULT '0' COMMENT '照片水印 0加水印 1不加',       
  `display_number` int(11) NOT NULL DEFAULT '25' COMMENT '显示个数',       
  `addtime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`photosid`),
  KEY `siteid` (`siteid`),
  KEY `userid` (`userid`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- 表的结构 `ik_site_photos_pic`
--

CREATE TABLE IF NOT EXISTS `ik_site_photos_pic` (
  `photoid` int(11) NOT NULL AUTO_INCREMENT,
  `photosid` int(11) NOT NULL DEFAULT '0' COMMENT '相册ID',
  `userid` int(11) NOT NULL DEFAULT '0',
  `photoname` char(64) NOT NULL DEFAULT '',
  `phototype` char(32) NOT NULL DEFAULT '',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图片路径',
  `photourl` char(120) NOT NULL DEFAULT '',
  `photosize` char(32) NOT NULL DEFAULT '',
  `photodesc` char(120) NOT NULL DEFAULT '',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不推荐1推荐',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`photoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `ik_site_forum_discuss`
--
CREATE TABLE IF NOT EXISTS `ik_site_forum_discuss` (
  `discussid` int(11) NOT NULL AUTO_INCREMENT COMMENT '讨论ID',
  `forumid` int(11) NOT NULL DEFAULT '0' COMMENT '论坛ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL DEFAULT '' COMMENT '内容',  
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '帖子展示数',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许评论',
  `isposts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖子',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',  
  PRIMARY KEY (`discussid`),
  KEY `forumid` (`forumid`),
  KEY `userid` (`userid`)  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `ik_site_notes`
--

CREATE TABLE IF NOT EXISTS `ik_site_notes` (
  `notesid` int(11) NOT NULL AUTO_INCREMENT COMMENT '日记ID',
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '应用名',
  `isarchive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有存档',
  `display_number` int(11) NOT NULL DEFAULT '2' COMMENT '显示个数',      
  `addtime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`notesid`),
  KEY `siteid` (`siteid`),
  KEY `userid` (`userid`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- 表的结构 `ik_site_notes_content`
--

CREATE TABLE IF NOT EXISTS `ik_site_notes_content` (
  `contentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '内容ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  
  `notesid` int(11) NOT NULL DEFAULT '0' COMMENT '日记ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '日记标题',
  `content` text NOT NULL DEFAULT '' COMMENT '日记内容',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',      
  `addtime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`contentid`),
  KEY `siteid` (`notesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- 表的结构 `ik_site_note_photo`
--

CREATE TABLE IF NOT EXISTS `ik_site_note_photo` (
  `photoid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'photoid',
  `seqid` int(11) NOT NULL DEFAULT '0' COMMENT 'seqid',
  `noteid` int(11) NOT NULL DEFAULT '0' COMMENT '日记ID',
  `userid` int(11) NOT NULL DEFAULT '0',
  `photoname` char(64) NOT NULL DEFAULT '',
  `phototype` char(32) NOT NULL DEFAULT '',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图片路径',
  `photourl` char(120) NOT NULL DEFAULT '',
  `photosize` char(32) NOT NULL DEFAULT '',
  `photodesc` char(120) NOT NULL DEFAULT '',
  `align` char(32) NOT NULL DEFAULT 'center' COMMENT '图片对齐方式',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不推荐1推荐',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`photoid`),
  KEY `noteid` (`noteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 ik_site_note_photo`
--
-- --------------------------------------------------------

--
-- 表的结构 `ik_site_discuss_comment`
--

CREATE TABLE IF NOT EXISTS `ik_site_discuss_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `discussid` int(11) NOT NULL DEFAULT '0' COMMENT '论坛讨论ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`discussid`),
  KEY `discussid` (`discussid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小站评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_site_discuss_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_site_note_comment`
--

CREATE TABLE IF NOT EXISTS `ik_site_note_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `noteid` int(11) NOT NULL DEFAULT '0' COMMENT '论坛讨论ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`noteid`),
  KEY `noteid` (`noteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小站评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_site_note_comment`
--
-- --------------------------------------------------------
--
-- 表的结构 `ik_site_room_widget`
--

CREATE TABLE IF NOT EXISTS `ik_site_room_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `leftmod`   text NOT NULL COMMENT '排序',
  `rightmod`   text NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='房间组件排序' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- 表的结构 `ik_site_widget`
--

CREATE TABLE IF NOT EXISTS `ik_site_widget` (
  `widgetid` int(11) NOT NULL AUTO_INCREMENT COMMENT '组件ID',
  `widgetname` char(64) NOT NULL DEFAULT '' COMMENT '组件名',
  `othername` char(64) NOT NULL DEFAULT '' COMMENT '别名',
  `widgetdesc` text NOT NULL COMMENT '组件介绍',
  PRIMARY KEY (`widgetid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ik_site_widget`
--

INSERT INTO `ik_site_widget` (`widgetid`, `widgetname`,  `othername`, `widgetdesc`) VALUES
(1, '公告栏',  'bulletin', '贴通知的地方，甚至是通缉令');
INSERT INTO `ik_site_widget` (`widgetid`, `widgetname`,  `othername`, `widgetdesc`) VALUES
(2, '日记本',  'notes', '难得的一个你能专心码字的好地方');
INSERT INTO `ik_site_widget` (`widgetid`, `widgetname`,  `othername`, `widgetdesc`) VALUES
(3, '论坛',  'forum', '方便别人在这里坐而论道');
INSERT INTO `ik_site_widget` (`widgetid`, `widgetname`,  `othername`, `widgetdesc`) VALUES
(4, '相册',  'photos', '专供小站拥有者和管理者贴图');

-- --------------------------------------------------------
--
-- 表的结构 `ik_area`
--

CREATE TABLE IF NOT EXISTS `ik_area` (
  `areaid` int(11) NOT NULL AUTO_INCREMENT,
  `areaname` varchar(32) NOT NULL DEFAULT '',
  `zm` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `referid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`areaid`),
  KEY `referid` (`referid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='本地化' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_area`
--
INSERT INTO `ik_area` (`areaid`, `areaname`, `zm`, `referid`) VALUES
(1,'广东','G','0'),
(2,'北京','B','0'),
(3,'上海','S','0'),
(4,'江苏','J','0'),
(5,'浙江','Z','0'),
(6,'山东','S','0'),
(7,'四川','S','0'),
(8,'湖北','H','0'),
(9,'福建','F','0'),
(10,'河南','H','0'),
(11,'辽宁','L','0'),
(12,'陕西','S','0'),
(13,'湖南','H','0'),
(14,'河北','H','0'),
(15,'安徽','A','0'),
(16,'黑龙江','H','0'),
(17,'重庆','C','0'),
(18,'天津','T','0'),
(19,'广西','G','0'),
(20,'山西','S','0'),
(21,'江西','J','0'),
(22,'吉林','J','0'),
(23,'云南','Y','0'),
(24,'内蒙古','N','0'),
(25,'贵州','G','0'),
(26,'甘肃','G','0'),
(27,'新疆','X','0'),
(28,'海南','H','0'),
(29,'宁夏','N','0'),
(30,'青海','Q','0'),
(31,'西藏','X','0'),
(32,'香港','X','0'),
(33,'澳门','A','0'),
(34,'台湾','T','0'),
(35,'钓鱼岛','D','0');


-- --------------------------------------------------------

--
-- 表的结构 `ik_note`
--

CREATE TABLE IF NOT EXISTS `ik_note` (
  `noteid` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '展示数',
  `isphoto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片',
  `isattach` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有附件',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`noteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_note`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_note_cate`
--

CREATE TABLE IF NOT EXISTS `ik_note_cate` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `catename` char(16) NOT NULL DEFAULT '' COMMENT '分类名称',
  `orderid` int(11) NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`cateid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ik_note_cate`
--

INSERT INTO `ik_note_cate` (`cateid`, `catename`, `orderid`) VALUES
(1, '默认分类', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ik_note_comment`
--

CREATE TABLE IF NOT EXISTS `ik_note_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `noteid` int(11) NOT NULL DEFAULT '0' COMMENT '日志ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '评论内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`commentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志评论' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `ik_attach`
--

CREATE TABLE IF NOT EXISTS `ik_attach` (
  `attachid` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `attachname` char(64) NOT NULL COMMENT '附件名字',
  `attachtype` char(32) NOT NULL DEFAULT '' COMMENT '附件类型',
  `attachurl` char(64) NOT NULL DEFAULT '' COMMENT '附件url',
  `attachsize` char(32) NOT NULL DEFAULT '' COMMENT '附件大小',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`attachid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_attach`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_event`
--

CREATE TABLE IF NOT EXISTS `ik_event` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '活动类型ID',
  `title` char(120) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `time_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `time_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图片路劲',
  `poster` char(16) NOT NULL DEFAULT '' COMMENT '海报图片',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '县区ID',
  `address` char(120) NOT NULL DEFAULT '' COMMENT '详细地址',
  `count_userdo` int(11) NOT NULL DEFAULT '0' COMMENT '统计参加的',
  `count_userwish` int(11) NOT NULL DEFAULT '0' COMMENT '统计感兴趣的',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐0默认1推荐',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`eventid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_event`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_event_comment`
--

CREATE TABLE IF NOT EXISTS `ik_event_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `eventid` (`eventid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题回复/评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_event_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_event_group_index`
--

CREATE TABLE IF NOT EXISTS `ik_event_group_index` (
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  UNIQUE KEY `eventid_2` (`eventid`,`groupid`),
  KEY `eventid` (`eventid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动小组索引表';

--
-- 转存表中的数据 `ik_event_group_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_event_type`
--

CREATE TABLE IF NOT EXISTS `ik_event_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT COMMENT '类型ID',
  `typename` varchar(64) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='话题类型' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ik_event_type`
--

INSERT INTO `ik_event_type` (`typeid`, `typename`) VALUES
(1, '音乐/演出'),
(2, '展览'),
(3, '电影'),
(4, '讲座/沙龙'),
(5, '戏剧/曲艺'),
(6, '生活/聚会'),
(7, '体育'),
(8, '旅行'),
(9, '公益'),
(10, '其他');

-- --------------------------------------------------------

--
-- 表的结构 `ik_event_users`
--

CREATE TABLE IF NOT EXISTS `ik_event_users` (
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0加入，1感兴趣',
  `isorganizer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是组织者:0不是1是',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  KEY `eventid` (`eventid`,`status`),
  KEY `userid` (`userid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动用户';

--
-- 转存表中的数据 `ik_event_users`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_feed`
--

CREATE TABLE IF NOT EXISTS `ik_feed` (
  `feedid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `template` varchar(1024) NOT NULL DEFAULT '' COMMENT '动态模板',
  `data` varchar(1024) NOT NULL DEFAULT '' COMMENT '动态数据',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`feedid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='全站动态' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_feed`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group`
--

CREATE TABLE IF NOT EXISTS `ik_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT COMMENT '小组ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupname` char(32) NOT NULL DEFAULT '' COMMENT '群组名字',
  `groupname_en` char(32) NOT NULL DEFAULT '' COMMENT '小组英文名称',
  `groupdesc` text NOT NULL COMMENT '小组介绍',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图标路径',
  `groupicon` char(32) DEFAULT '' COMMENT '小组图标',
  `count_topic` int(11) NOT NULL DEFAULT '0' COMMENT '帖子统计',
  `count_topic_today` int(11) NOT NULL DEFAULT '0' COMMENT '统计今天发帖',
  `count_user` int(11) NOT NULL DEFAULT '0' COMMENT '小组成员数',
  `joinway` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加入方式',
  `role_leader` char(32) NOT NULL DEFAULT '组长' COMMENT '组长角色名称',
  `role_admin` char(32) NOT NULL DEFAULT '管理员' COMMENT '管理员角色名称',
  `role_user` char(32) NOT NULL DEFAULT '成员' COMMENT '成员角色名称',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否公开或者私密',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `ispost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许会员发帖',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`groupid`),
  KEY `userid` (`userid`),
  KEY `isshow` (`isshow`),
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_group`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_cates`
--

CREATE TABLE IF NOT EXISTS `ik_group_cates` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `catename` char(32) NOT NULL DEFAULT '' COMMENT '分类名字',
  `catereferid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `count_group` int(11) NOT NULL DEFAULT '0' COMMENT '群组个数',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`cateid`),
  KEY `referid` (`catereferid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_group_cates`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_cates_index`
--

CREATE TABLE IF NOT EXISTS `ik_group_cates_index` (
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  UNIQUE KEY `groupid_2` (`groupid`,`cateid`),
  KEY `groupid` (`groupid`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组分类索引';

--
-- 转存表中的数据 `ik_group_cates_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_links`
--

CREATE TABLE IF NOT EXISTS `ik_group_links` (
  `groupid` int(11) NOT NULL DEFAULT '0',
  `linkid` int(11) NOT NULL DEFAULT '0',
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_group_links`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_options`
--

CREATE TABLE IF NOT EXISTS `ik_group_options` (
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置';

--
-- 转存表中的数据 `ik_group_options`
--

INSERT INTO `ik_group_options` (`optionname`, `optionvalue`) VALUES
('appname', '小组'),
('appdesc', '爱客小组'),
('iscreate', '0'),
('isaudit', '0');

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics`
--

CREATE TABLE IF NOT EXISTS `ik_group_topics` (
  `topicid` int(11) NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子分类ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(64) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '帖子展示数',
  `count_attach` int(11) NOT NULL DEFAULT '0' COMMENT '统计附件',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许评论',
  `isphoto` tinyint(1) NOT NULL DEFAULT '0',
  `isattach` tinyint(1) NOT NULL DEFAULT '0',
  `isnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否通知',
  `isposts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖子',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`topicid`),
  KEY `groupid` (`groupid`),
  KEY `userid` (`userid`),
  KEY `title` (`title`),
  KEY `groupid_2` (`groupid`,`isshow`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组话题' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_group_topics`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_collects`
--

CREATE TABLE IF NOT EXISTS `ik_group_topics_collects` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `topicid` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '收藏时间',
  UNIQUE KEY `userid_2` (`userid`,`topicid`),
  KEY `userid` (`userid`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子收藏';

--
-- 转存表中的数据 `ik_group_topics_collects`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_comments`
--

CREATE TABLE IF NOT EXISTS `ik_group_topics_comments` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `topicid` int(11) NOT NULL DEFAULT '0' COMMENT '话题ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题回复/评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_group_topics_comments`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_type`
--

CREATE TABLE IF NOT EXISTS `ik_group_topics_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子分类ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `typename` char(32) NOT NULL DEFAULT '' COMMENT '帖子分类名称',
  `count_topic` int(11) NOT NULL DEFAULT '0' COMMENT '统计帖子',
  PRIMARY KEY (`typeid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子分类' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_group_topics_type`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_group_users`
--

CREATE TABLE IF NOT EXISTS `ik_group_users` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '群组ID',
  `isadmin` int(11) NOT NULL DEFAULT '0' COMMENT '是否管理员',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '加入时间',
  UNIQUE KEY `userid_2` (`userid`,`groupid`),
  KEY `userid` (`userid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='群组和用户对应关系';

--
-- 转存表中的数据 `ik_group_users`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_home_info`
--

CREATE TABLE IF NOT EXISTS `ik_home_info` (
  `infoid` int(11) NOT NULL AUTO_INCREMENT,
  `infokey` char(32) NOT NULL DEFAULT '',
  `infocontent` text NOT NULL,
  PRIMARY KEY (`infoid`),
  UNIQUE KEY `infokey` (`infokey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ik_home_info`
--

INSERT INTO `ik_home_info` (`infoid`, `infokey`, `infocontent`) VALUES
(1, 'about', '<h2>爱客网（12IK.COM）</h2>
<p  style="margin:5px 0px">爱客网是开放、多元的泛科技兴趣社区，并提供负责任、有智趣的科技内容。你可以在这里：</p> 
<ul style="margin:5px 0px">
<li style="list-style: disc inside none;">依兴趣关注不同的小站和小组，阅读有意思的科技内容；</li> 
<li style="list-style: disc inside none;">在"爱客问答"里提出困惑你的科技问题，或提供靠谱的答案；</li> 
<li style="list-style: disc inside none;">关注各个门类和领域的爱客达人，加入兴趣小组讨论，分享智趣话题。</li> 
</ul>      
<p  style="margin:5px 0px">爱客网的创始人是小麦，他是一位IT爱好者；热衷于PHP和前端开发，经过不懈的努力和追求；他在不断的完善爱客网；为广大爱好互联网科技者提供点点贡献。</p>
<p  style="margin:5px 0px">爱客网(12IK)社区将不断完善社区系统的建设，以简单和高扩展的形式为用户提供各种不同功能的社区应用，爱客网(12IK)开源社区将不断满足用户对社区建设和运营等方面的需求。</p>
<p  style="margin:5px 0px">爱客网是一个非盈利性个人网站， 它是在不违背社会主义道德底线的公益网站！它有着和其他社区同仁一样的激情！</p>
<p  style="margin:5px 0px">官方网站：<a href="http://www.12ik.com/">http://www.12ik.com</a></p>'),
(2, 'contact', '<p>Email:160780470#qq.com(#换@)</p>\r\n<p>QQ:160780470</p>\r\n<p>Location:北京</p>'),
(3, 'agreement', '<p>1、爱客网(12IK)开源社区免费开源</p>\r\n<p>2、你可以免费使用爱客网(12IK)开源社区</p>\r\n<p>3、你可以在爱客网(12IK)开源社区基础上进行二次开发和修改</p>\r\n<p>4、你可以拿爱客网(12IK)开源社区建设你的商业运营网站</p>\r\n\r\n<p>5、在爱客网(12IK)开源社区未进行商业运作之前，爱客网(12IK)开源社区(小麦)将拥有对爱客网(12IK)开源社区的所有权，任何个人，公司和组织不得以任何形式和目的侵犯爱客网(12IK)开源社区的版权和著作权</p>\r\n<p>6、爱客网(12IK)开源社区拥有对此协议的修改和不断完善。</p>'),
(4, 'privacy', '<p>爱客网(12IK)开源社区（12ik.com）以此声明对本站用户隐私保护的许诺。爱客网(12IK)开源社区的隐私声明正在不断改进中，随着本站服务范围的扩大，会随时更新隐私声明。我们欢迎你随时查看隐私声明。</p>');

-- --------------------------------------------------------

--
-- 表的结构 `ik_mail_options`
--

CREATE TABLE IF NOT EXISTS `ik_mail_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `ik_mail_options`
--

INSERT INTO `ik_mail_options` (`optionid`, `optionname`, `optionvalue`) VALUES
(1, 'appname', '邮件'),
(2, 'appdesc', '爱客网(12IK)开源社区邮件'),
(3, 'isenable', '0'),
(4, 'mailhost', 'smtp.qq.com'),
(5, 'mailport', '25'),
(6, 'mailuser', 'user@qq.com'),
(7, 'mailpwd', '123456');

-- --------------------------------------------------------

--
-- 表的结构 `ik_message`
--

CREATE TABLE IF NOT EXISTS `ik_message` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '发送用户ID',
  `touserid` int(11) NOT NULL DEFAULT '0' COMMENT '接收消息的用户ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',  
  `content` text NOT NULL COMMENT '内容',
  `isread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `isspam` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否垃圾邮件',  
  `isinbox` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在收件箱显示',  
  `isoutbox` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在发件箱显示',  
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`messageid`),
  KEY `touserid` (`touserid`,`isread`),
  KEY `userid` (`userid`,`touserid`,`isread`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短消息表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_message`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_photo`
--

CREATE TABLE IF NOT EXISTS `ik_photo` (
  `photoid` int(11) NOT NULL AUTO_INCREMENT,
  `albumid` int(11) NOT NULL DEFAULT '0' COMMENT '相册ID',
  `userid` int(11) NOT NULL DEFAULT '0',
  `photoname` char(64) NOT NULL DEFAULT '',
  `phototype` char(32) NOT NULL DEFAULT '',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图片路径',
  `photourl` char(120) NOT NULL DEFAULT '',
  `photosize` char(32) NOT NULL DEFAULT '',
  `photodesc` char(120) NOT NULL DEFAULT '',
  `hash` char(16) NOT NULL DEFAULT '',  
  `count_view` int(11) NOT NULL DEFAULT '0',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不推荐1推荐',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`photoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_photo`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_photo_album`
--

CREATE TABLE IF NOT EXISTS `ik_photo_album` (
  `albumid` int(11) NOT NULL AUTO_INCREMENT COMMENT '相册ID',
  `userid` int(11) NOT NULL DEFAULT '0',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '相册路径',
  `albumface` char(64) NOT NULL DEFAULT '' COMMENT '相册封面',
  `albumname` char(64) NOT NULL DEFAULT '',
  `albumdesc` varchar(400) NOT NULL DEFAULT '' COMMENT '相册介绍',
  `count_photo` int(11) NOT NULL DEFAULT '0',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`albumid`),
  KEY `userid` (`userid`),
  KEY `isrecommend` (`isrecommend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='相册' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_photo_album`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_photo_comment`
--

CREATE TABLE IF NOT EXISTS `ik_photo_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `photoid` int(11) NOT NULL DEFAULT '0' COMMENT '相册ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`photoid`),
  KEY `photoid` (`photoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片回复/评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_photo_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_photo_options`
--

CREATE TABLE IF NOT EXISTS `ik_photo_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(16) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ik_photo_options`
--

INSERT INTO `ik_photo_options` (`optionid`, `optionname`, `optionvalue`) VALUES
(1, 'appname', '相册'),
(2, 'appdesc', '相册APP');

-- --------------------------------------------------------

--
-- 表的结构 `ik_search_key`
--

CREATE TABLE IF NOT EXISTS `ik_search_key` (
  `keyid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `keyword` char(32) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索关键词' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_search_key`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_system_options`
--

CREATE TABLE IF NOT EXISTS `ik_system_options` (
  `optionname` char(32) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理配置';

--
-- 转存表中的数据 `ik_system_options`
--

INSERT INTO `ik_system_options` (`optionname`, `optionvalue`) VALUES
('site_title', '爱客网(12IK)开源社区'),
('site_subtitle', '又一个爱客网(12IK)开源社区'),
('site_url', 'http://localhost/12ik/'),
('site_email', 'admin@admin.com'),
('site_icp', '正在备案中'),
('isface', '0'),
('site_key', '12ik'),
('site_desc', '又一个爱客网(12IK)开源社区'),
('site_theme', 'white'),
('site_urltype', '1'),
('isgzip', '0'),
('timezone', 'Asia/Hong_Kong'),
('isinvite', '0'),
('charset', 'UTF-8'),
('thumbwidth', '400'),
('thumbheight', '300'),
('attachmentdir', 'uploadfile/attachments/'),
('attachmentdirtype', 'month');

-- --------------------------------------------------------

--
-- 表的结构 `ik_tag`
--

CREATE TABLE IF NOT EXISTS `ik_tag` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` char(16) NOT NULL DEFAULT '',
  `count_user` int(11) NOT NULL DEFAULT '0',
  `count_group` int(11) NOT NULL DEFAULT '0',
  `count_topic` int(11) NOT NULL DEFAULT '0',
  `count_bang` int(11) NOT NULL DEFAULT '0',
  `count_article` int(11) NOT NULL DEFAULT '0',
  `count_note` int(11) NOT NULL DEFAULT '0',
  `count_site` int(11) NOT NULL DEFAULT '0',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`tagid`),
  UNIQUE KEY `tagname` (`tagname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_tag`
--

-- --------------------------------------------------------
--
-- 表的结构 `ik_tag_site_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_site_index` (
  `siteid` int(11) NOT NULL DEFAULT '0' COMMENT '小站ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `siteid_2` (`siteid`,`tagid`),
  KEY `siteid` (`siteid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_site_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_note_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_note_index` (
  `noteid` int(11) NOT NULL DEFAULT '0' COMMENT '日志ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `noteid_2` (`noteid`,`tagid`),
  KEY `noteid` (`noteid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_note_index`
--


-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_article_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_article_index` (
  `articleid` int(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `articleid_2` (`articleid`,`tagid`),
  KEY `articleid` (`articleid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_article_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_group_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_group_index` (
  `groupid` int(11) NOT NULL DEFAULT '0',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `groupid_2` (`groupid`,`tagid`),
  KEY `groupid` (`groupid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_group_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_topic_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_topic_index` (
  `topicid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `topicid_2` (`topicid`,`tagid`),
  KEY `topicid` (`topicid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_topic_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_user_index`
--

CREATE TABLE IF NOT EXISTS `ik_tag_user_index` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `userid_2` (`userid`,`tagid`),
  KEY `userid` (`userid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_user_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_user`
--

CREATE TABLE IF NOT EXISTS `ik_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `salt` char(32) NOT NULL DEFAULT '' COMMENT '加点盐',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '用户email',
  `resetpwd` char(32) NOT NULL DEFAULT '' COMMENT '重设密码',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pwd` (`pwd`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_user`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_user_follow`
--

CREATE TABLE IF NOT EXISTS `ik_user_follow` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `userid_follow` int(11) NOT NULL DEFAULT '0' COMMENT '被关注的用户ID',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  UNIQUE KEY `userid_2` (`userid`,`userid_follow`),
  KEY `userid` (`userid`),
  KEY `userid_follow` (`userid_follow`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关注跟随';

--
-- 转存表中的数据 `ik_user_follow`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_user_info`
--

CREATE TABLE IF NOT EXISTS `ik_user_info` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `fuserid` int(11) NOT NULL DEFAULT '0' COMMENT '来自邀请用户',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` char(32) NOT NULL DEFAULT '',
  `doname` char(32) NOT NULL DEFAULT '',  
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `phone` char(16) NOT NULL DEFAULT '' COMMENT '电话号码',
  `roleid` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '区县ID',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '头像路径',
  `face` char(64) NOT NULL DEFAULT '' COMMENT '会员头像',
  `signed` char(64) NOT NULL DEFAULT '' COMMENT '签名',
  `blog` char(32) NOT NULL DEFAULT '' COMMENT '博客',
  `about` char(255) NOT NULL DEFAULT '' COMMENT '关于我',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT '登陆IP',
  `address` char(64) NOT NULL DEFAULT '',
  `qq_openid` char(32) NOT NULL DEFAULT '',
  `qq_access_token` char(32) NOT NULL DEFAULT '' COMMENT 'access_token',
  `count_score` int(11) NOT NULL DEFAULT '0' COMMENT '统计积分',
  `count_follow` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户跟随的',
  `count_followed` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户被跟随的',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是管理员',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用：0启用1禁用',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未验证1验证',
  `verifycode` char(11) NOT NULL DEFAULT '' COMMENT '验证码',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) DEFAULT '0' COMMENT '登陆时间',
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `userid` (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `qq_openid` (`qq_openid`),
  KEY `fuserid` (`fuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户';

--
-- 转存表中的数据 `ik_user_info`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_user_invites`
--

CREATE TABLE IF NOT EXISTS `ik_user_invites` (
  `inviteid` int(11) NOT NULL AUTO_INCREMENT,
  `invitecode` char(32) NOT NULL DEFAULT '' COMMENT '邀请码',
  `isused` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`inviteid`),
  KEY `isused` (`isused`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户邀请码' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_user_invites`
--

-- --------------------------------------------------------

--
-- 表的结构 `ik_user_invited`
--

CREATE TABLE IF NOT EXISTS `ik_user_invited` (
  `invitedid` int(11) NOT NULL AUTO_INCREMENT,
  `invitemail` char(64) NOT NULL DEFAULT '' COMMENT '被邀请人的email',
  `saltmail` char(64) NOT NULL DEFAULT '' COMMENT '加密email',  
  `userid` int(1) NOT NULL DEFAULT '0' COMMENT '邀请人id',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '邀请时间',
  PRIMARY KEY (`invitedid`),
  KEY `isused` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邀请用户' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_user_invited`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_user_options`
--

CREATE TABLE IF NOT EXISTS `ik_user_options` (
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置';

--
-- 转存表中的数据 `ik_user_options`
--

INSERT INTO `ik_user_options` (`optionname`, `optionvalue`) VALUES
('appname', '用户'),
('appdesc', '用户中心'),
('isenable', '0'),
('isvalidate', '0'),
('isrewrite', '0'),
('isauthcode', '0'),
('isgroup', '');

-- --------------------------------------------------------

--
-- 表的结构 `ik_user_role`
--

CREATE TABLE IF NOT EXISTS `ik_user_role` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `rolename` char(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  PRIMARY KEY (`roleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ik_user_role`
--

INSERT INTO `ik_user_role` (`roleid`, `rolename`) VALUES
(1, '列兵'),
(2, '下士'),
(3, '中士'),
(4, '上士'),
(5, '三级准尉'),
(6, '二级准尉'),
(7, '一级准尉'),
(8, '少尉'),
(9, '中尉'),
(10, '上尉'),
(11, '少校'),
(12, '中校'),
(13, '上校'),
(14, '准将'),
(15, '少将'),
(16, '中将'),
(17, '上将');

-- --------------------------------------------------------

--
-- 表的结构 `ik_user_scores`
--

CREATE TABLE IF NOT EXISTS `ik_user_scores` (
  `scoreid` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `scorename` char(64) NOT NULL DEFAULT '' COMMENT '积分说明',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '得分',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '积分时间',
  PRIMARY KEY (`scoreid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_user_scores`
--
-- --------------------------------------------------------

--
-- 表的结构 'ik_robots'
--
CREATE TABLE IF NOT EXISTS `ik_robots` (
  robotid smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  uid mediumint(8) unsigned NOT NULL default '0',
  dateline int(10) unsigned NOT NULL default '0',
  lasttime int(10) unsigned NOT NULL default '0',
  importcatid smallint(6) unsigned NOT NULL default '0',
  importtype varchar(10) NOT NULL default '',
  robotnum smallint(6) unsigned NOT NULL default '0',
  listurltype varchar(10) NOT NULL default '',
  listurl text NOT NULL,
  listpagestart smallint(6) unsigned NOT NULL default '0',
  listpageend smallint(6) unsigned NOT NULL default '0',
  reverseorder tinyint(1) NOT NULL default '1',
  allnum smallint(6) unsigned NOT NULL default '0',
  pernum smallint(6) unsigned NOT NULL default '0',
  savepic tinyint(1) NOT NULL default '0',
  encode varchar(20) NOT NULL default '',
  picurllinkpre text NOT NULL,
  saveflash tinyint(1) NOT NULL default '0',
  subjecturlrule text NOT NULL,
  subjecturllinkrule text NOT NULL,
  subjecturllinkpre text NOT NULL,
  subjectrule text NOT NULL,
  subjectfilter text NOT NULL,
  subjectreplace text NOT NULL,
  subjectreplaceto text NOT NULL,
  subjectkey text NOT NULL,
  subjectallowrepeat tinyint(1) NOT NULL default '0',
  datelinerule text NOT NULL,
  fromrule text NOT NULL,
  authorrule text NOT NULL,
  messagerule text NOT NULL,
  messagefilter text NOT NULL,
  messagepagetype varchar(10) NOT NULL default '',
  messagepagerule text NOT NULL,
  messagepageurlrule text NOT NULL,
  messagepageurllinkpre text NOT NULL,
  messagereplace text NOT NULL,
  messagereplaceto text NOT NULL,
  autotype tinyint(1) NOT NULL default '0',
  wildcardlen tinyint(1) NOT NULL default '0',
  subjecturllinkcancel text NOT NULL,
  subjecturllinkfilter text NOT NULL,
  subjecturllinkpf text NOT NULL,
  subjectkeycancel text NOT NULL,
  messagekey text NOT NULL,
  messagekeycancel text NOT NULL,
  messageformat tinyint(1) NOT NULL default '0',
  messagepageurllinkpf text NOT NULL,
  uidrule text NOT NULL,
  defaultdateline int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (robotid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='采集器' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
DROP TABLE IF EXISTS ik_robotlog;
CREATE TABLE ik_robotlog (
  hash  char(32) NOT NULL default '',
  PRIMARY KEY (hash)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='采集器日志' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- 表的结构 'ik_article_categories'
--
DROP TABLE IF EXISTS ik_article_categories;
CREATE TABLE ik_article_categories (
  catid smallint(6) unsigned NOT NULL auto_increment,
  upid smallint(6) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  note text NOT NULL,
  `type` varchar(30) NOT NULL default '',
  ischannel tinyint(1) NOT NULL default '0',
  displayorder mediumint(6) unsigned NOT NULL default '0',
  tpl varchar(80) NOT NULL default '',
  viewtpl varchar(80) NOT NULL default '',
  thumb varchar(150) NOT NULL default '',
  image varchar(150) NOT NULL default '',
  haveattach tinyint(1) NOT NULL default '0',
  bbsmodel tinyint(1) NOT NULL default '0',
  bbsurltype varchar(15) NOT NULL default '',
  blockmodel tinyint(1) NOT NULL default '1',
  blockparameter text NOT NULL,
  blocktext text NOT NULL,
  url varchar(255) NOT NULL default '',
  subcatid text NOT NULL,
  htmlpath varchar(80) NOT NULL default '',
  domain varchar(50) NOT NULL default '',
  perpage smallint(6)  NOT NULL default '0',
  prehtml varchar(20) NOT NULL,
  PRIMARY KEY  (catid),
  KEY `type` (`type`),
  KEY upid (upid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章分类';
-- --------------------------------------------------------

INSERT INTO `ik_article_categories` (`name`, `type`) VALUES
('互联网络','news'),
('明星娱乐','news');
-- --------------------------------------------------------

--
-- 表的结构 'ik_article_channels'
--
DROP TABLE IF EXISTS ik_article_channels;
CREATE TABLE ik_article_channels (
  nameid char(30) NOT NULL default '',
  `name` char(50) NOT NULL default '',
  url char(200) NOT NULL default '',
  tpl char(50) NOT NULL default '',
  categorytpl char(50) NOT NULL default '',
  viewtpl char(50) NOT NULL default '',
  `type` char(20) NOT NULL default '',
  path char(30) NOT NULL default '',
  domain char(50) NOT NULL default '',
  upnameid char(30) NOT NULL default '',
  displayorder smallint(3) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  allowpost text NOT NULL,
  allowview text NOT NULL,
  allowcomment text NOT NULL,
  allowgetattach text NOT NULL,
  allowpostattach text NOT NULL,
  allowmanage text NOT NULL,
  PRIMARY KEY  (nameid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章频道';
-- --------------------------------------------------------
--
-- 表的结构 'ik_article_spaceitems'
--

DROP TABLE IF EXISTS ik_article_spaceitems;
CREATE TABLE ik_article_spaceitems (
  itemid mediumint(8) unsigned NOT NULL auto_increment,
  catid smallint(6) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0',
  tid mediumint(8) unsigned NOT NULL default '0',
  username char(15) NOT NULL default '',
  itemtypeid mediumint(8) unsigned NOT NULL default '0',
  `type` char(30) NOT NULL default '',
  subtype char(10) NOT NULL default '',
  `subject` char(80) NOT NULL default '',
  dateline int(10) unsigned NOT NULL default '0',
  lastpost int(10) unsigned NOT NULL default '0',
  viewnum mediumint(8) unsigned NOT NULL default '0',
  replynum mediumint(8) unsigned NOT NULL default '0',
  digest tinyint(1) NOT NULL default '0',
  top tinyint(1) NOT NULL default '0',
  allowreply tinyint(1) NOT NULL default '1',
  `hash` char(16) NOT NULL default '',
  haveattach tinyint(1) NOT NULL default '0',
  grade tinyint(1) NOT NULL default '0',
  gid mediumint(8) unsigned NOT NULL default '0',
  gdigest tinyint(1) NOT NULL default '0',
  `password` char(10) NOT NULL default '',
  `styletitle` char(11) NOT NULL default '',
  picid mediumint(8) unsigned NOT NULL default '0',
  fromtype char(10) NOT NULL default 'adminpost',
  fromid mediumint(8) unsigned NOT NULL default '0',
  hot mediumint(8) unsigned NOT NULL default '0',
  click_1 smallint(6) unsigned NOT NULL default '0',
  click_2 smallint(6) unsigned NOT NULL default '0',
  click_3 smallint(6) unsigned NOT NULL default '0',
  click_4 smallint(6) unsigned NOT NULL default '0',
  click_5 smallint(6) unsigned NOT NULL default '0',
  click_6 smallint(6) unsigned NOT NULL default '0',
  click_7 smallint(6) unsigned NOT NULL default '0',
  click_8 smallint(6) unsigned NOT NULL default '0',
  click_9 smallint(6) unsigned NOT NULL default '0',
  click_10 smallint(6) unsigned NOT NULL default '0',
  click_11 smallint(6) unsigned NOT NULL default '0',
  click_12 smallint(6) unsigned NOT NULL default '0',
  click_13 smallint(6) unsigned NOT NULL default '0',
  click_14 smallint(6) unsigned NOT NULL default '0',
  click_15 smallint(6) unsigned NOT NULL default '0',
  click_16 smallint(6) unsigned NOT NULL default '0',
  click_17 smallint(6) unsigned NOT NULL default '0',
  click_18 smallint(6) unsigned NOT NULL default '0',
  click_19 smallint(6) unsigned NOT NULL default '0',
  click_20 smallint(6) unsigned NOT NULL default '0',
  click_21 smallint(6) unsigned NOT NULL default '0',
  click_22 smallint(6) unsigned NOT NULL default '0',
  click_23 smallint(6) unsigned NOT NULL default '0',
  click_24 smallint(6) unsigned NOT NULL default '0',
  click_25 smallint(6) unsigned NOT NULL default '0',
  click_26 smallint(6) unsigned NOT NULL default '0',
  click_27 smallint(6) unsigned NOT NULL default '0',
  click_28 smallint(6) unsigned NOT NULL default '0',
  click_29 smallint(6) unsigned NOT NULL default '0',
  click_30 smallint(6) unsigned NOT NULL default '0',
  click_31 smallint(6) unsigned NOT NULL default '0',
  click_32 smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (itemid),
  KEY `uid` (uid,`type`,top,dateline),
  KEY catid (catid,dateline),
  KEY `type` (`type`),
  KEY gid (gid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='信息表';

-- --------------------------------------------------------

--
-- 表的结构 'ik_article_spacenews'
--

DROP TABLE IF EXISTS ik_article_spacenews;
CREATE TABLE ik_article_spacenews (
  nid mediumint(8) unsigned NOT NULL auto_increment,
  itemid mediumint(8) unsigned NOT NULL default '0',
  message text NOT NULL,
  relativetags text NOT NULL,
  postip varchar(15) NOT NULL default '',
  relativeitemids varchar(255) NOT NULL default '',
  customfieldid smallint(6) unsigned NOT NULL default '0',
  customfieldtext text NOT NULL,
  includetags text NOT NULL,
  newsauthor varchar(20) NOT NULL default '',
  newsfrom varchar(50) NOT NULL default '',
  newsfromurl varchar(150) NOT NULL default '',
  newsurl varchar(255) NOT NULL default '',
  pageorder smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (nid),
  KEY itemid (itemid, pageorder, nid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章内容表';

DROP TABLE IF EXISTS ik_attachments;
CREATE TABLE ik_attachments (
  aid mediumint(8) unsigned NOT NULL auto_increment,
  isavailable tinyint(1) NOT NULL default '0',
  `type` char(30) NOT NULL default '',
  itemid mediumint(8) unsigned NOT NULL default '0',
  catid smallint(6) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0',
  dateline int(10) unsigned NOT NULL default '0',
  filename char(150) NOT NULL default '',
  `subject` char(80) NOT NULL default '',
  attachtype char(10) NOT NULL default '',
  isimage tinyint(1) NOT NULL default '0',
  size int(10) unsigned NOT NULL default '0',
  filepath char(200) NOT NULL default '',
  thumbpath char(200) NOT NULL default '',
  downloads mediumint(8) unsigned NOT NULL default '0',
  `hash` char(16) NOT NULL default '',
  PRIMARY KEY  (aid),
  KEY `hash` (`hash`),
  KEY itemid (itemid),
  KEY uid (uid,`type`,dateline),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';