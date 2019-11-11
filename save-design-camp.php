	<?php

	include('config.php');

	header('Access-Control-Allow-Origin: *');

	$data = array();

	
	//$decodedData = json_decode($_REQUEST['data'],true);
	//$decodedPage = json_decode($_REQUEST['page'],true);

	
	

	$campaignName = $_REQUEST['campaignName'];
	$campData = $_REQUEST['data'];
	$campPage = $_REQUEST['page'];
	$userID = $_REQUEST['userId'];
	$campID = $_REQUEST['campaignID'];

	// $sql = mysql_query("select id from campaigns where user_id=".$userID." order by id DESC");
	// $res = mysql_fetch_array($sql);
	// $campaignID = $res['id']+1;

	// echo "insert into campaigns (`campaign_name`,`campaign_data`,`user_id`,`list_id`,`campaign_type`,`campaign_date`) values('".$campaignName."','".mysql_real_escape_string($campData)."',".$userID.",'',2,'".date('Y-d-m')."')";

	// die('Ashutosh');
	if(!$campID){
		$campSql = mysql_query("insert into campaigns (`campaign_name`,`campaign_data`,`user_id`,`list_id`,`campaign_type`,`campaign_date`) values('".$campaignName."','".mysql_real_escape_string($campData)."',".$userID.",'',2,'".date('Y-d-m')."')");

		$insertId = mysql_insert_id();

		// Create preview page
		define('UPLOAD_DIR', 'user-design-campaigns/');
		$myfile = fopen(UPLOAD_DIR .$insertId.'-designCamp.html', "w") or die("Unable to open file!");
		$textToWrite = $campData;
		fwrite($myfile, $textToWrite);
		fclose($myfile);
		$query =  "insert into campaigns (`campaign_name`,`campaign_data`,`user_id`,`list_id`,`campaign_type`,`campaign_date`) values('".$campaignName."','content',".$userID.",'',2,'".date('Y-d-m')."')";

	}else{
		$campSql = mysql_query("update campaigns set campaign_data='".mysql_real_escape_string($campData)."' where id=".$campID."");
		$insertId = $campID;

		// Update preview page
		define('UPLOAD_DIR', 'user-design-campaigns/');
		$myfile = fopen(UPLOAD_DIR .$campID.'-designCamp.html', "w") or die("Unable to open file!");
		$textToWrite = $campData;
		fwrite($myfile, $textToWrite);
		fclose($myfile);
		$query =  "update campaigns set campaign_data='content' where id=".$campID."";
	}
	
	if($insertId > 0){
		$data[] = array('campaignID' => $insertId,'campaignSave' => 1, 'query'=> $query);
		echo $_GET['callback'] . '(' . json_encode($data) . ')';
	}

?>