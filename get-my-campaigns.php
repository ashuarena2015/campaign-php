<?php
	
	include('config.php');

		// echo "select * from contact_lists where user_id='".$_REQUEST['userID']."'";
		// die();

		$sql = mysql_query("select * from campaigns where user_id='".$_REQUEST['userID']."'");
		$getId = mysql_num_rows($sql);

		$data = array();

		if($getId > 0){
			
			while($row = mysql_fetch_array($sql)){
				$data[] = $row;
			}

	 	}else {
	 		$data[] = 0;
	 	}	

		echo json_encode($data);	
?>