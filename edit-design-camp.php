	<?php

	include('config.php');

	$data = array();

	
	$campID = $_REQUEST['campaignID'];

	$campSql = mysql_query("select campaign_data from campaigns where id=".$campID."");
	$campFetch = mysql_fetch_array($campSql);
	$campData = $campFetch['campaign_data'];


	

	$data = array();
	
	header('Access-Control-Allow-Origin: http://localhost:8085');
	
	if($campData){
		$data[] = $campData;
		echo $_GET['callback'] . '(' . json_encode($campData) . ')';
	}

?>