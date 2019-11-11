<?php
	
	require 'PHPMailer/src/PHPMailer.php';


	include('config.php');


		$userID = $_REQUEST['userID'];
		$smsMessage = $_REQUEST['message'];
		$campaignSender = $_REQUEST['campaignSender'];
		$listIds = $_REQUEST['listIDs'];

		//echo $_REQUEST['listIDs'];
		$json = json_decode($_REQUEST['listIDs'], true);
		foreach ($json as $key => $value) {
			$a[] = $json[$value];
		}


		// Store Image first

		//echo "select id from campaigns where user_id='".$userID."'";

		$sql = mysql_query("select id from campaigns where user_id=".$userID." order by id DESC");
		$res = mysql_fetch_array($sql);
		$campaignID = $res['id']+1;


		$allNumbers = array();
		$sql = mysql_query("select * from contacts where list_id in (".implode(',',$a).")");

		while($row = mysql_fetch_array($sql)){
			$allNumbers[] = $row['mobile'];
		}

		$mobile_numbers = implode(',',$allNumbers);

		//<img src='http://localhost/react-website-php/images'".$file."'>

		//print_r($a);
		//echo "select * from contacts where list_id in (".implode(',',$a).")";
		
		$sql = mysql_query("select * from contacts where list_id in (".implode(',',$a).")");

		//echo "insert into campaigns (`campaign_name`,`user_id`,`list_id`) values('".$campaignName."',".$userID.",'".implode(',',$a)."')";
		$campSql = mysql_query("insert into campaigns (`campaign_name`,`campaign_data`,`user_id`,`list_id`,`campaign_type`) values('".$campaignSender."','".$smsMessage."',".$userID.",'".implode(',',$a)."',1)");
		$insertId = mysql_insert_id();


		// Authorisation details.
		$username = "ashuarena@gmail.com";
		$hash = "3278f3a07d1640c4eec9c443529734a9edd7a52ba1d0d8662e83758ffacb2c82";
	
		// Config variables. Consult http://api.textlocal.in/docs for more info.
		$test = "0";
	
		// Data for text message. This is the text message data.
		$sender = "TXTLCL"; // This is who the message appears to be from.
		$numbers = $mobile_numbers; // A single number or a comma-seperated list of numbers
		$message = $smsMessage;
		// 612 chars or less
		// A single number or a comma-seperated list of numbers
		$message = urlencode($message);
		$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		//echo $result;
		//$status = json_decode($result,true);

		// echo $status['status'];
		// echo $status['cost'];
		// echo $status['num_messages'];
		// echo $status['balance'];
		//echo '<pre>' . print_r($status, true) . '</pre>';

		curl_close($ch);

		header('Access-Control-Allow-Origin: http://localhost:8085');
		echo $result;
		

?>