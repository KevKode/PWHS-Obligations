<?php
	include "SQLLogin.php";
	
	$id=$_POST['id'];
	$gradYear=$_POST["gradYear"];
	$teacher=$_POST["teacheremail"];
	$activity=$_POST["activity"];
	$type=$_POST["type"];
	$itemNum=$_POST["itemNum"];
	$cost=$_POST["cost"];
	$description=$_POST["description"];
	$email=$_POST["email"];
	
	$date = date("Y-m-d");
	
	$Query="INSERT INTO Obligations (`StudentID`, `Teacher`, `GradYear`, `Cost`, `Activity`, `CreateDate`, `TypeId`, `ItemNumber`, `Description`) VALUES ('$id', '$teacher', '$gradYear', '$cost', '$activity', '$date', '$type', '$itemNum', '$description')";
	$result=$connection->query($Query);
	
	$msg = "You have recived an obligation from ".$_SESSION['name']." for ".$type." at a cost of $".$cost.". Please visit the PWHS Obligations Website at http://www.nathanhyer.com/Capstone/Web2/BUILD/login.php and login with your school credentials for more information."; 
	$msg = wordwrap($msg, 100);
	mail($email,"(PWHS) You have recived an obligation from ".$_SESSION['name'],$msg);
?>