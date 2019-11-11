<?php
	
	include('config.php');
		
	
	//echo $_REQUEST['contact_csv'];

	$userID = $_REQUEST['userID'];
	$listName = $_REQUEST['list_name'];

	$sql = mysql_query("insert into contact_lists(`list_name`,`user_id`) values('".$listName."','".$userID."')");
	$insertId = mysql_insert_id();

	

	header('Access-Control-Allow-Origin: http://localhost:8085');
	echo $insertId;

?>