<?php
	
	include('config.php');

		//echo "select * from contact_lists as cl INNER JOIN contacts as cn where cl.id=cn.list_id and cl.user_id='".$_REQUEST['userID']."' and cn.list_id='".$_REQUEST['listID']."'";

		$sql = mysql_query("select * from contact_lists as cl INNER JOIN contacts as cn where cl.id=cn.list_id and cl.user_id='".$_REQUEST['userID']."' and cn.list_id='".$_REQUEST['listID']."'");
		$getId = mysql_num_rows($sql);

		$data = array();

		if($getId > 0){
			
			while($row = mysql_fetch_array($sql)){
				$data[] = $row;
			}

	 	}else {
	 		$data[] = 0;
	 	}	

	 	header('Access-Control-Allow-Origin: http://localhost:8085');

		echo json_encode($data);	
?>