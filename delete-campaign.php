<?php
	
		include('config.php');

		$campID = $_REQUEST['camp_id'];

		$sql = mysql_query("delete from campaigns where id=".$campID."");
		$updateRow = mysql_affected_rows();

		header('Access-Control-Allow-Origin: http://localhost:8085');

		if($updateRow > 0) {
			echo json_encode(array('status' => 1));
		}else {
			echo json_encode(array('status' => 0));
		}
		
		
		

?>