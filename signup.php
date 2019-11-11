<?php
	
	include('config.php');

	//echo "insert into users(`name`,`email`,`password`) values('".$_REQUEST['fullname']."','".$_REQUEST['email']."','".$_REQUEST['password']."')";


	$checkSql = mysql_query("select email from users where email='".$_REQUEST['email']."'");
	$checkRes = mysql_num_rows($checkSql);

	//echo $checkRes;

	if($checkRes < 1) {
		$sql = mysql_query("insert into users(name,email,password) values('".$_REQUEST['fullname']."','".$_REQUEST['email']."','".$_REQUEST['password']."')");
		$insertId = mysql_insert_id();
		 if($insertId > 0){
		 	$msg->success = "You have registered successfully!";
		 }
	}else {
		$msg->error = "Email already exist, please try with different email.";
	}

	 echo json_encode($msg);

?>