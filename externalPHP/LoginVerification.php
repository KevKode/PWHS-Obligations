<?php
session_start();
require "../settingsPHP/SQLLogin.php";

$Return = array();

$User = $_POST['Username'];
$Pass = md5($_POST['Password']);

$Query = "SELECT `IDNumber` FROM Student_Definitions WHERE `IDNumber`='$User' AND `Password`='$Pass'";

$rows = QueryGetRows($connection, $Query);

if($rows['error'])
{
	$Return['result'] = "Fail";
	$Return['reason'] = "StudentError: " + $rows['error'];
}
else
{
	foreach($rows as $Row)
	{
		$_SESSION['PermissionLevel'] = 0;
		$_SESSION['login'] = $User;
		$Return['result'] = "Success";
	}
	unset($Row);

	$Query = "SELECT `Email`, `isAdmin`, `FirstName`, `LastName` FROM Teachers WHERE `Email`='$User' AND `password`='$Pass'";

	$rows = QueryGetRows($connection, $Query);

	if($rows['error'])
	{
		$Return['result'] = "Fail";
		$Return['reason'] = "TeacherError: " + $rows['error'];
	}
	else
	{
		foreach($rows as $Row)
		{
			$_SESSION['PermissionLevel'] = ($Row[1] == 1 ? 2 : 1);
			$_SESSION['name'] = $Row[3] . ", " . $Row[2];
			$_SESSION['login'] = $User;
			$_SESSION['email'] = $Row[0];
			$Return['result'] = "Success";
		}
		unset($Row);

		if(!isset($Return['result']))
		{
			$Return['result'] = "Fail";
			$Return['reason'] = "NoUser";
		}
	}
}
echo json_encode($Return);
?>