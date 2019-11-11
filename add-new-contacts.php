<?php
	
	include('config.php');
		
	
	//echo $_REQUEST['contact_csv'];

	$userID = $_REQUEST['userID'];
	$listID = $_REQUEST['listID'];
	$emails = $_REQUEST['contact_csv'];

	$emailJson = json_decode($emails);

	//echo '<pre>' . print_r($json, true) . '</pre>';


	foreach ($emailJson as $key => $value) {		
		//echo "insert into contacts(`list_id`,`email`,`name`) values('".$listID."','".$value[0]."','".$value[1]."')";

		$email = $value[0];
		$name = $value[1];
		$getMobile = explode(";",$value[2]);
		$mobile = $getMobile[0];



		// Check email and list id before inserting

		$check = mysql_query("select * from contacts where list_id=".$listID." and email='".$email."'");
		$rows = mysql_num_rows($check);


		$affectedRows = 0;

		if($rows < 1) {
			$sql = mysql_query("insert into contacts(`list_id`,`email`,`mobile`,`name`) values('".$listID."','".$email."','".$mobile."','".$name."')");
			$insertId = mysql_insert_id();
		}

		$affectedRows ++;

	}


	header('Access-Control-Allow-Origin: http://localhost:8085');
	echo $affectedRows;

?>