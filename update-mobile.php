<?php
	include('config.php');

		$userID = $_REQUEST['user_id'];
		$newMobile = $_REQUEST['newMobile'];
		$otp = $_REQUEST['otp'];
		$sql = mysql_query("update users set mobile='".$newMobile."' where id=".$userID." and mobile_verify_otp=".$otp."");
		$updateRow = mysql_affected_rows();

		if($updateRow > 0) {
			echo json_encode(array('status' => 1));
		}else {
			echo json_encode(array('status' => 0));
		}
		

		header('Access-Control-Allow-Origin: http://localhost:8085');
		
		

?>