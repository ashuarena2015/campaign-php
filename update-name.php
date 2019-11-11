<?php
	
	include('config.php');

		$userID = $_REQUEST['user_id'];
		$newName = $_REQUEST['newName'];

		$sql = mysql_query("update users set name='".$newName."' where id=".$userID."");
		$updateRow = mysql_affected_rows();

		header('Access-Control-Allow-Origin: http://localhost:8085');

		if($updateRow > 0) {
			echo json_encode(array('status' => 1));
		}else {
			echo json_encode(array('status' => 0));
		}
		
		
		

?>