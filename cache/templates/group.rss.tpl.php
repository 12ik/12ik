<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
  <title><?php echo $IK_SITE['base'][site_title];?>: <?php echo $strGroup['groupname'];?>小组的讨论</title>
  <link><?php echo $IK_SITE['base'][site_url];?><?php echo ikurl('group','show',array('id'=>$strGroup['groupid']))?></link>
  <description><![CDATA[<?php echo $IK_SITE['base'][site_title];?> <?php echo $strGroup['groupname'];?>小组二日内的最新讨论话题]]></description>
  <language>zh_cn</language>
  <copyright>&amp;amp;copy; <?php echo $IK_SOFT['info'][year];?>, <?php echo $IK_SOFT['info'][copyright];?>.</copyright>
  <pubDate><?php echo date('Y-m-d H:i:s',$pubdate)?></pubDate>
	<?php foreach((array)$arrTopic as $key=>$item) {?>
    <item>
        <title><?php echo $item['title'];?><?php echo $IK_SITE['base'][site_title];?><?php echo $strGroup['groupname'];?>小组)</title>
        <link><?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?></link>
        <description><![CDATA[<?php echo $item['content'];?>]]></description>
        <content:encoded><![CDATA[<?php echo $item['content'];?>]]></content:encoded>
        <dc:creator><?php echo $item['username'];?></dc:creator>
        <pubDate><?php echo date('Y-m-d H:i:s',$item['addtime'])?></pubDate>
        <guid isPermaLink="true"><?php echo SITE_URL;?><?php echo ikurl('group','topic',array('id'=>$item['topicid']))?></guid>
   </item>
	<?php }?>
    </channel>
</rss>