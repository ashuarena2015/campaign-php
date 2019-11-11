<?php
	
	include('config.php');

		//echo "select * from users where email='".$_REQUEST['email']."' and password='".$_REQUEST['password']."'";



		$data = array();

		$sql = mysql_query("select * from users where email='".$_REQUEST['email']."'");
		$getId = mysql_num_rows($sql);
		

	 	if($getId < 1){
	 		$insert = mysql_query("insert into users (`name`, `email`, `password`) values('".$_REQUEST['name']."','".$_REQUEST['email']."','".$_REQUEST['password']."')");
	 		$insertId = mysql_insert_id();
	 		
	 	}

	 	if($insertId > 0){
 			$data[] = array('email' => $_REQUEST['email'], 'user_id' => $insertId );
 		}else {
 			$data[] = array('error' => 'failure' );
 		}


	 	header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($data);	
?>