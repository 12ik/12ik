<?php 
defined('IN_IK') or die('Access Denied.');
 
class mail extends IKApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//发送邮件
	function postMail($sendmail,$subject,$content){

		global $IK_SITE;
	
		$options = fileRead('data/mail_options.php');
		date_default_timezone_set('Asia/Shanghai');
		require_once core.'/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer();

		//邮件配置
		$mail->CharSet = "UTF-8";
		$mail->IsSMTP(); 
		$mail->SMTPDebug  	= 1;
		$mail->SMTPAuth   	= true;           
		$mail->Host       		= $options['mailhost']; 
		$mail->Port       		= $options['mailport']; 
		$mail->Username   	= $options['mailuser']; 
		$mail->Password   	= $options['mailpwd']; 

		//POST过来的信息
		$frommail		= $options['mailuser'];
		$fromname	= $IK_SITE['base']['site_title'];
		$replymail		= $options['mailuser'];
		$replyname	= $IK_SITE['base']['site_title'];
		$sendname	= '';

		if(empty($frommail) || empty($subject) || empty($content) || empty($sendmail)){
			return '0';
		}else{

			//邮件发送
			$mail->SetFrom($frommail, $fromname);
			$mail->AddReplyTo($replymail,$replyname);
			$mail->Subject    = $subject;
			$mail->AltBody    = "要查看邮件，请使用HTML兼容的电子邮件阅读器!"; 
			//$mail->MsgHTML(eregi_replace("[\]",'',$content));
			$mail->MsgHTML(strtr($content,'[\]',''));
			$mail->AddAddress($sendmail, $sendname);
			$mail->Send();
			
			return '1';
			
		}
	}
	
	
	//析构函数
	public function __destruct(){
		
	}

}