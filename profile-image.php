<?php
	
	include('config.php');


		$img = $_REQUEST['profile-image'];
		$userID = $_REQUEST['user-id'];

		
		define('UPLOAD_DIR', 'images/');

		$format = explode('base64',$img);
		$format = $format[0];
		$extention = explode('data:image/',$format);
		$extention = explode(';',$extention[1]);


		if($format == 'data:image/jpeg;'){
			$getBaseFormat = str_replace('data:image/jpeg;base64,', '', $img);
		}
		else if($format == 'data:image/png;'){
			$getBaseFormat = str_replace('data:image/png;base64,', '', $img);
		}
		else if($format == 'data:image/gif;'){
			$getBaseFormat = str_replace('data:image/gif;base64,', '', $img);
		}
		else if($format == 'data:image/jpg;'){
			$getBaseFormat = str_replace('data:image/jpg;base64,', '', $img);
		}
		else {
			//echo "Image format is not correct!";
		}


		if($getBaseFormat){
			$img = str_replace(' ', '+', $getBaseFormat);
			$data = base64_decode($img);
			$file = UPLOAD_DIR . $userID."_".uniqid() . '.png';
			$success = file_put_contents($file, $data);
			$msg = $success ? 1 : 0;
		}

		if($msg > 0) {
			mysql_query("UPDATE users set profile_img='".$file."' where id='".$userID."'");
		}

		header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($msg);

		
?>