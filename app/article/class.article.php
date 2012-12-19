<?php 
defined('IN_IK') or die('Access Denied.');
class article extends IKApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//根据userid获取所有分类
	function getAllArticle(){
		$arr =  $this->findAll('article_spacenews');
		return $arr;
	}
	
	
}
