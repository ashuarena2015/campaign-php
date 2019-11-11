<?php
	
	require 'PHPMailer/src/PHPMailer.php';


	include('config.php');


		$userID = $_REQUEST['userID'];
		$campaignName = $_REQUEST['campaignName'];
		$campaignDesignID = $_REQUEST['campaignDesignID'];
		$listIds = $_REQUEST['listIDs'];

		//print_r($_REQUEST);
		//die('aa');

		//echo $_REQUEST['listIDs'];
		$json = json_decode($_REQUEST['listIDs'], true);
		//print_r($json);
		foreach ($json as $key => $value) {
			$a[] = $json[$value];
		}


		//echo "select * from contacts where list_id in (".implode(',',$a).")";
		$allEmails = array();
		$sql = mysql_query("select * from contacts where list_id in (".implode(',',$a).")");

		//echo "insert into campaigns (`campaign_name`,`user_id`,`list_id`) values('".$campaignName."',".$userID.",'".implode(',',$a)."')";
		//echo "select * from campaigns where id=".$campaignDesignID."";

		$campNameCheck = mysql_query("select campaign_name from campaigns where id=".$campaignDesignID."");
		$campNameCheckData = mysql_fetch_array($campNameCheck);

		$campNamePrev = $campNameCheckData['campaign_name'];

		if($campNamePrev!=$campaignName){
			echo "update campaigns set campaign_name='".$campaignName."' and list_id='".implode(',',$a)."' where id=".$campaignDesignID."";
			$campNameUpdate = mysql_query("update campaigns set campaign_name='".$campaignName."' and list_id='".implode(',',$a)."' where id=".$campaignDesignID."");
		}else {
			echo "update campaigns set list_id='".implode(',',$a)."' where id=".$campaignDesignID."";
			$campNameUpdate = mysql_query("update campaigns set list_id='".implode(',',$a)."' where id=".$campaignDesignID."");
		}




		$campSql = mysql_query("select * from campaigns where id=".$campaignDesignID."");
		while($dataCampSql = mysql_fetch_array($campSql)){
			$designCampCode = $dataCampSql['campaign_data'];
		}

		while($row = mysql_fetch_array($sql)){
			$allEmails[] = $row['email'];
		}
		//print_r($allEmails);
		
		$receive_email = implode(',',$allEmails);
		$subject = $campaignName;
		$headers = "MIME-Version: 1.0" . "\r\n"; // To display HTML content in email inbox
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; //To display HTML content in email inbox
		$headers .= 'From: <info@ideaweaver.in>' . "\r\n"; // Will be display in `From`
		$headers .= 'Cc: ashuarena@gmail.com' . "\r\n"; // CC Emails

		$message = $designCampCode;
		mail($receive_email,$subject,$message,$headers);
		if(mail) {
			$emailSentMsg = 1;
		}else {
			$emailSentMsg = 0;
		}
		header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($emailSentMsg);	
?>