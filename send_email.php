<?php

class email {
	function send_email($to, $from, $cc, $subject, $body) {
		$body = str_replace("\n","<br>",$body);
		require_once("../includes/PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
		$to = explode(",",$to);
		for($i=0; $i<sizeof($to);$i++) {
			$mail->AddAddress($to[$i]);	
		}
		$cc = explode(",",$cc);
		for($i=0; $i<sizeof($cc);$i++) {
			$mail->AddCC($cc[$i]);	
		}
		$from = explode(",",$from);
		for($i=0; $i<sizeof($from);$i++) {
			$mail->From = $from[$i];	//from
			$mail->FromName = $from[$i];//from	
		}

		try {
			//Server settings
			$mail->SMTPDebug = 'true';
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'mail3.pricon.ph';                      //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'issinfoservice@pricon.ph';             //SMTP username
			$mail->Password   = 'EYGEKFwlzuDfNufG2DGk';                 //SMTP password
			$mail->SMTPSecure = 'ssl';            						//Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		
			//Recipients
			$mail->From = $from;
			$mail->setFrom('issinfoservice@pricon.ph', 'Employee Leave File System');
			// $mail->addBCC('jgsulit@pricon.ph');
		
			//Content
			$mail->Subject = $subject;
			$mail->Body= $body;

			if(!$mail->Send()){
			   $msg = "Message could not be sent.";
			   $msg .= "Mailer Error: " . $mail->ErrorInfo ."\n";
			   exit;
			} else {
				$msg = "Message has been sent!";
			}
			return $msg; 

		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
?>