<?php
	
	require 'PHPMailer/src/PHPMailer.php';


	include('config.php');


		$userID = $_REQUEST['userID'];
		$img = $_REQUEST['image'];
		$campaignName = $_REQUEST['campaignName'];
		$campaignText = $_REQUEST['campaignContent'];
		$listIds = $_REQUEST['listIDs'];

		//echo $_REQUEST['listIDs'];
		$json = json_decode($_REQUEST['listIDs'], true);
		//print_r($json);
		foreach ($json as $key => $value) {
			$a[] = $json[$value];
		}


		// Store Image first

		//echo "select id from campaigns where user_id='".$userID."'";

		$sql = mysql_query("select id from campaigns where user_id=".$userID." order by id DESC");
		$res = mysql_fetch_array($sql);
		$campaignID = $res['id']+1;

		define('UPLOAD_DIR', 'images/');

		$format = explode('base64',$img);
		$format = $format[0];
		$extention = explode('data:image/',$format);
		$extention = explode(';',$extention[1]);

		if($format == 'data:image/jpeg;'){
			$getBaseFormat = str_replace('data:image/jpeg;base64,', '', $img);
		}
		else if($format == 'data:image/png;'){
			$getBaseFormat = str_replace('data:image/png;base64,', '', $img);
		}
		else if($format == 'data:image/gif;'){
			$getBaseFormat = str_replace('data:image/gif;base64,', '', $img);
		}
		else if($format == 'data:image/jpg;'){
			$getBaseFormat = str_replace('data:image/jpg;base64,', '', $img);
		}
		else {
			//echo "Image format is not correct!";
		}

		if($getBaseFormat){
			$img = str_replace(' ', '+', $getBaseFormat);
			$data = base64_decode($img);
			$file = UPLOAD_DIR . $campaignID."_".$userID . '.png';
			$success = file_put_contents($file, $data);
			$msg = $success ? 1 : 0;
		}


		$allEmails = array();
		$sql = mysql_query("select * from contacts where list_id in (".implode(',',$a).")");

		
		if(!$file){
			$sendingImg = $img;
		}else{
			$sendingImg = $file;
		}
		
		$campSql = mysql_query("insert into campaigns (`campaign_name`,`campaign_data`,`user_id`,`list_id`,`campaign_type`,`campaign_text`,`campaign_date`) values('".$campaignName."','".$sendingImg."',".$userID.",'".implode(',',$a)."',0,'".$campaignText."',".date('DD-MM-YYYY').")");
		$insertId = mysql_insert_id();


		while($row = mysql_fetch_array($sql)){
			$allEmails[] = $row['email'];
		}

		// print_r($allEmails);
		
		$receive_email = implode(',',$allEmails);
		$subject = $campaignName;
		$headers = "MIME-Version: 1.0" . "\r\n"; // To display HTML content in email inbox
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; //To display HTML content in email inbox
		$headers .= 'From: <info@ideaweaver.in>' . "\r\n"; // Will be display in `From`
		$headers .= 'Cc: ashuarena@gmail.com' . "\r\n"; // CC Emails
		$message = "<html>
						<head>
						<title>'".$campaignName."'</title>
						</head>
						<body>
							
							<table class='react-msg-mail-content' align='center' style='border:1px solid #ccc; padding:30px;'>
								<tr>
									<td><img src='http://ideaweaver.in/campaign-php-ws/".$sendingImg."'/></td>
								</tr>
								<tr>
									<td></td>
								</tr>
							</table>
						</body>
					</html>";
		mail($receive_email,$subject,$message,$headers);
		if(mail) {
			$emailSentMsg = 1;
		}else {
			$sql = mysql_query("delete from campaigns where id=".$insertId."");
			$emailSentMsg = 0;
		}
		// header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($emailSentMsg);	
?>