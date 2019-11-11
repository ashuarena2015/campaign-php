	<?php

	include('config.php');


		$userID = $_REQUEST['userId'];
		
		$data = array();

		$sql  = mysql_query("select * from image_gallery where user_id=".$userID."");
		while($row = mysql_fetch_array($sql)){
			$image = $row['image'];
			$data[] = array("image" => $image,);
		}
		
		header('Access-Control-Allow-Origin: http://localhost:8085');

		//echo json_encode($data);

		echo $_GET['callback'] . '(' . json_encode($data) . ')';
?>