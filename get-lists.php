<?php
	
	include('config.php');
		$sql = mysql_query("select * from contact_lists where user_id=".$_REQUEST['userID']."");
		$getId = mysql_num_rows($sql);
		$data = array();

		if($getId > 0){
			
			while($row = mysql_fetch_array($sql)){
				$data[] = $row;
			}

	 	}else {
	 		$data[] = 0;
	 	}	

	 	header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($data);	
?>