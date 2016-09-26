<?php 

	require "../settingsPHP/SQLLogin.php";
	$id = $_POST['index'];
	$up = $_POST['type'];
	$ReturnDate = date("Y-m-d");
	$Query = "UPDATE Obligations SET `ReturnTypeId`='$up', `ReturnDate`='$ReturnDate' WHERE `ID`='$id'";

	$connection->query($Query);
	echo json_encode("DONE");
?>