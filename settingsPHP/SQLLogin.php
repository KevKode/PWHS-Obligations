<?php

$db_host = "localhost";
$db_username = "jeffers_root";
$db_password = "admingo";
$db_name = "jeffers_capstone";

$connection=mysqli_connect($db_host, $db_username, $db_password, $db_name);


function QueryGetRows($connect, $Query)
{
	$result = $connect->query($Query);
	$allRows = array();
	
	if(!$result)
	{
		$allRows['error'] = $connect->error;
		return $allRows;
	}
	
	$row = $result->fetch_row();
	
	while($row)
	{
		array_push($allRows, $row);
		$row = $result->fetch_row();
	}
	
	return $allRows;
}
?>