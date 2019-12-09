<?php
	
	include('config.php');

		$data = array();

		$checkCamp = mysql_query("select * from campaigns where user_id=".$_REQUEST['user_id']."");
		$checkData = mysql_num_rows($checkCamp);

		if($checkData > 0){
			$sql = mysql_query("select *,SUM(campaigns.campaign_type = '0') AS imageCamp,SUM(campaigns.campaign_type = '1') AS smsCamp,SUM(campaigns.campaign_type = '2') AS designCamp from users INNER JOIN campaigns on users.id=campaigns.user_id where users.email='".$_REQUEST['email']."'");
			while($row = mysql_fetch_array($sql)){
				$data[] = $row;
			}

	 	}else {
	 		$sql = mysql_query("select * from users where email='".$_REQUEST['email']."'");
			while($row = mysql_fetch_array($sql)){
				$data[] = $row;
			}
	 	}	

		echo json_encode($data);	
?>