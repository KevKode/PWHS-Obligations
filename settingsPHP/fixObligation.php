<?php
	include "SQLLogin.php";
	
	$Uid = $_POST['uid'];
	$id=$_POST['id'];
	$gradYear=$_POST["gradYear"];
	$activity=$_POST["activity"];
	$type=$_POST["type"];
	$itemNum=$_POST["itemNum"];
	$cost=$_POST["cost"];
	$description=$_POST["description"];
	$email=$_POST["email"];

	
	$Query="UPDATE Obligations SET `StudentID`='$id', `GradYear`='$gradYear', `Cost`='$cost', `Activity`='$activity', `TypeId`='$type', `ItemNumber`='$itemNum', `Description`='$description' WHERE `ID`='$Uid'";
	$result=$connection->query($Query);
	
?>