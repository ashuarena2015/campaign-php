<?php
	
	require 'PHPMailer/src/PHPMailer.php';


	include('config.php');

		$userID = $_REQUEST['user_id'];
		$currMobile = $_REQUEST['currMobile'];
		$newMobile = $_REQUEST['newMobile'];
		
		$sql = mysql_query("select * from users where id=".$userID."");
		$res = mysql_fetch_array($sql);
		$num = mysql_num_rows($sql);

		$otp = mt_rand(1000,9999);

		if($newMobile === $res['mobile']){
			echo json_encode(array('status' => 'exist'));
		} else {
			if($num > 0) {
				//echo "update users set mobile_verify_otp=".$otp." where id=".$userID."";
				$sql = mysql_query("update users set mobile_verify_otp=".$otp." where id=".$userID."");
	
	
				//echo "select `mobile_verify_otp` from users where id=".$userID." and mobile=".$newMobile."";
				$check = mysql_query("select `mobile_verify_otp` from users where id=".$userID."");
				$num2 = mysql_num_rows($check);
				$checkRow = mysql_fetch_array($check);
				if($num2 > 0 && $checkRow['mobile_verify_otp'] > 0){
					
					// Authorisation details.
					$username = "ashuarena@gmail.com";
					$hash = "3278f3a07d1640c4eec9c443529734a9edd7a52ba1d0d8662e83758ffacb2c82";
				
					// Config variables. Consult http://api.textlocal.in/docs for more info.
					$test = "0";
				
					// Data for text message. This is the text message data.
					$sender = "TXTLCL"; // This is who the message appears to be from.
					$numbers = $newMobile; // A single number or a comma-seperated list of numbers
					$message = $otp." is your 4 digit OTP to verify your number. If you are not requested, then please ignore.";
					// 612 chars or less
					// A single number or a comma-seperated list of numbers
					$message = urlencode($message);
					$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
					$ch = curl_init('http://api.textlocal.in/send/?');
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch); // This is the result from the API
	
					$resultDecode = json_decode($result,true);
					$status = $resultDecode['status'];
	
					curl_close($ch);
	
				}
	
			}
			echo json_encode(array('status' => $status));
		}
		

		

		// header('Access-Control-Allow-Origin: http://localhost:8085');
		

?>