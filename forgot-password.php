<?php

	include('config.php');

		$email = $_REQUEST['email'];
		$mob = $_REQUEST['mobile'];
		
		// echo "select password from users where email='".$email."' and mobile='".$mob."'";
		$sql = mysql_query("select password from users where email='".$email."' and mobile='".$mob."'");
		$row = mysql_fetch_array($sql);
		$res = mysql_num_rows($sql);

		//echo $row['passowrd'];
		

		if($res > 0){
			
			// Authorisation details.
			$username = "ashuarena@gmail.com";
			$hash = "3278f3a07d1640c4eec9c443529734a9edd7a52ba1d0d8662e83758ffacb2c82";
		
			// Config variables. Consult http://api.textlocal.in/docs for more info.
			$test = "0";
		
			// Data for text message. This is the text message data.
			$sender = "TXTLCL"; // This is who the message appears to be from.
			$numbers = $mob; // A single number or a comma-seperated list of numbers
			$message = "Your password is ".$row['password'];
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
			
			if($status == 'success'){	
				$result = array('status' => $status, 'msg' => 'Your password has been sent on your mobile number.');
			}else{
				$result = array('status' => 'failure', 'msg' => 'Your password has been failed to sent on your mobile number. Please try again');
			}

			curl_close($ch);

		}else {

		}
		

		header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($result);

?>