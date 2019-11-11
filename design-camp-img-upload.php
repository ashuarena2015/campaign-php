<?php

header('Access-Control-Allow-Origin: http://localhost:8085');
	include('config.php');

	if(isset($_FILES["file"]["type"])){
		$msg = array();
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg"))
			&& in_array($file_extension, $validextensions)) {
			if ($_FILES["file"]["error"] > 0){
				echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			}else{
				$sql = mysql_query("select id from image_gallery where user_id=".$_REQUEST['user_id']." order by id DESC");
				$row = mysql_fetch_array($sql);
				$getLastId = $row['id']+1;

				$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = "design-camp-images/".$_REQUEST['user_id']."_".$getLastId."_".$_FILES['file']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				
				
				

				$sql = mysql_query("insert into image_gallery (`image`, `user_id`) values('".$_REQUEST['user_id']."_".$getLastId."_".$_FILES["file"]["name"]."',".$_REQUEST['user_id'].")");	



				$msg[] = array('status' =>1, 'image' => $_FILES["file"]["name"]);
				// echo json_encode($msg);
				echo json_encode($msg);


			}
		}else{
			$msg[] = array('status' =>0, 'image' => $_FILES["file"]["name"]);
			echo json_encode($msg);
		}
	}
?>
