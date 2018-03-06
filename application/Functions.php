<?php

class Functions extends CWebUser
{


	
	public static function _sendEmail($from,$to,$subject,$pesan,$fromname='')
	{
		$url=Yii::app()->getBasePath();
		require_once($url."/../../phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$send = '';
		try {
			$mail->IsSMTP();       
			$mail->Host = 'smtp.sendgrid.net';
			$mail->Port = '2525';
			$mail->SMTPAuth = true;
			$mail->Username = 'mifx-crm.com';
			$mail->Password = 'r4h451453k4l1';
			if(strlen($fromname) > 0)
			{
				$mail->SetFrom($from,$fromname);
			}else{
				$mail->SetFrom($from);
			}
			
			$mail->isHtml();
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $pesan;
			$mail->Send();
			$send = 'Sent';
		}catch (phpmailerException $e) {
			$send = $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			$send = $e->getMessage(); //Boring error messages from anything else!
		}	

		return $send;
	}


}
