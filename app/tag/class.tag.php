<?php
defined('IN_IK') or die('Access Denied.');
class tag extends IKApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//添加多个标签 
	function addTag($objname,$idname,$objid,$tags){
	
		if($objname != '' && $idname != '' && $objid!='' && $tags!=''){
			//$tags = str_replace ( '，', ',', $tags );
			$tag = preg_replace('/\s+/', ',',  $tags );//修正用空格 分割 tag标签
			$arrTag = explode(',', $tag);
			foreach($arrTag as $item){
				$tagname = t($item); 
				if(strlen($tagname) < '32' && $tagname != ''){
					$uptime = time();
					$tagcount = $this->db->once_num_rows("select * from ".dbprefix."tag where tagname='".$tagname."'");
					
					if($tagcount == '0'){
						
						$this->db->query("INSERT INTO ".dbprefix."tag (`tagname`,`uptime`) VALUES ('".$tagname."','".$uptime."')");
						$tagid = $this->db->insert_id(); 
						
						$tagIndexCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_index where ".$idname."='".$objid."' and tagid='".$tagid."'");
						if($tagIndexCount == '0'){
							$this->db->query("INSERT INTO ".dbprefix."tag_".$objname."_index (`".$idname."`,`tagid`) VALUES ('".$objid."','".$tagid."')");
						}
						$tagIdCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_index where tagid='".$tagid."'");
						$this->db->query("update ".dbprefix."tag set `count_".$objname."`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagid."'");
					}else{
						$tagData = $this->db->once_fetch_assoc("select * from ".dbprefix."tag where tagname='".$tagname."'");
						
						$tagIndexCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_index where ".$idname."='".$objid."' and tagid='".$tagData['tagid']."'");
						if($tagIndexCount == '0'){
							$this->db->query("INSERT INTO ".dbprefix."tag_".$objname."_index (`".$idname."`,`tagid`) VALUES ('".$objid."','".$tagData['tagid']."')");
						}
						$tagIdCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_index where tagid='".$tagData['tagid']."'");
						$this->db->query("update ".dbprefix."tag set `count_".$objname."`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagData['tagid']."'");
					}
					
				}
			}
		}
	}
	
	//通过topic获取tag
	function getObjTagByObjid($objname,$idname,$objid){
		$arrTagIndex = $this->db->fetch_all_assoc("select * from ".dbprefix."tag_".$objname."_index where ".$idname."='$objid'");
		
		if(is_array($arrTagIndex)){
		foreach($arrTagIndex as $item){
			$arrTag[] = $this->getOneTag($item['tagid']);
		}
		}
		
		return $arrTag;
		
	}
	//根据tagid 获取相关topicid
	function getObjidByTagid($objname, $idname, $tagid)
	{
		$arrObjid = $this->db->fetch_all_assoc("select ".$idname." from ".dbprefix."tag_".$objname."_index where tagid='$tagid'");
		if(is_array($arrObjid)){
			return $arrObjid ;
		}
	}
	//通过topic删除tag
	function delObjTagByObjid($objname,$idname,$objid)
	{
		$arrTagIndex = $this->db->fetch_all_assoc("select * from ".dbprefix."tag_".$objname."_index where ".$idname."='$objid'");
		if(is_array($arrTagIndex))
		{
			foreach($arrTagIndex as $item){
				$this->delete('tag',array('tagid'=>$item['tagid']));
			}
			//删除索引 tag_obj_index 表
			$this->delete('tag_'.$objname.'_index',array($idname=>$item[$idname]));
		}		
	}
	
	//通过tagid获得tagname
	function getOneTag($tagid){
		$tagData = $this->db->once_fetch_assoc("select * from ".dbprefix."tag where tagid='$tagid'");
		
		return $tagData;
	}
	
	//通过tagname获取tagid
	function getTagId($tagname){
		$strTag = $this->db->once_fetch_assoc("select tagid from ".dbprefix."tag where `tagname`='$tagname'");
		
		return $strTag['tagid'];
	}

	
}