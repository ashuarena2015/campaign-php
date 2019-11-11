<?php
	
	$name = $_POST['name2'];
	$user_email = $_POST['mail2'];
	$receive_email = "ashutestemail@gmail.com";
	$phone = $_POST['phone'];
	$comment = $_POST['comment'];
	$subject = "Keep in touch - Form";
	$headers = "MIME-Version: 1.0" . "\r\n"; // To display HTML content in email inbox
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; //To display HTML content in email inbox
	$headers .= 'From: <test123@sognaresoft.com>' . "\r\n"; // Will be display in `From`
	$headers .= 'Cc: ashutestemail@gmail.com' . "\r\n"; // CC Emails

	$message = "<html>
					<head>
					<title>Keep in touch - Form</title>
					</head>
					<body>
						<p>Enquiry Details</p>
						Name:" .$name. "<br>
						Email: ".$user_email." <br>
						Phone: ".$phone."<br>
						Message: ".$comment."<br>
					</body>
				</html>";

	mail($receive_email,$subject,$message,$headers);
	if(mail) {
		$emailSentMsg = "Enquiry sent Successfully!";
	}else {
		$emailSentMsg = "Something went wrong. Try again.";
	}

?>