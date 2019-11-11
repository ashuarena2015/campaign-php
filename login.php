<?php
	
	include('config.php');

		$data = array();

		$sql = mysql_query("select * from users where email='".$_REQUEST['email']."' and password='".$_REQUEST['password']."'");
		$getId = mysql_num_rows($sql);
		if($getId > 0){
			$row = mysql_fetch_array($sql);
			$data[] = array('email' => $row['email'], 'user_id' => $row['id'] );
	 	}else {
	 		$data[] = array('error' => "Invalid login credential, please try again.");
	 	}	

		echo json_encode($data);	
?>