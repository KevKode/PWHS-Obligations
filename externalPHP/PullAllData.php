<?php session_start();
require "../settingsPHP/SQLLogin.php";

$_SESSION['PermissionLevel']; // 0: Student. 1: Teacher. 2: Admin
if(isset($_SESSION['PermissionLevel']))
{
	$permissionLevel = $_SESSION['PermissionLevel'];
	$Query = "SELECT Obligations.`ID`, Obligations.`StudentID`, Obligations.`Teacher`, Obligations.`GradYear`, Obligations.`Cost`, Obligations.`Activity`, Obligations.`CreateDate`, Obligations.`ReturnDate`, Obligations.`TypeId`, Obligations.`OtherSpecification`, Obligations.`ItemNumber`, Obligations.`Description`, Obligations.`ReturnTypeId`, ObligationTypes.`Title`, ObligationReturnTypes.`Title`, Student_Definitions.`FirstName`, Student_Definitions.`LastName`, Teachers.`FirstName`, Teachers.`LastName`, Obligations.`PartPay` ". 
		"FROM Obligations INNER JOIN ObligationTypes ON Obligations.`TypeId` = ObligationTypes.`ID` ".
		"INNER JOIN ObligationReturnTypes ON Obligations.`ReturnTypeId` = ObligationReturnTypes.`ID` ".
		"INNER JOIN Student_Definitions ON Obligations.`StudentID` = Student_Definitions.`IDNumber` ".
		"INNER JOIN Teachers ON Teachers.`Email` = Obligations.`Teacher` WHERE ";
		
		/*
		0: ID
		1: StudentID
		2: TeacherEmail
		3: GradYear
		4: Cost
		5: Activity
		6: CreateDate
		7: ReturnDate
		8: TypeId
		9: Other Specification
		10: ItemNumber
		11: Description
		12: ReturnTypeId
		13: ObligationTypeTitle
		14: ObligationReturnTypeTitle
		15: Student First Name
		16: Student Last Name
		17: Teacher First Name
		18: Teacher Last Name
		19: Partial Payment
		*/
		
	switch($permissionLevel)
	{
		case 0:
			$Query .= "`StudentID` = '" . $_SESSION['login'] . "'";
		break;
		case 1:
			$Query .= "`Teacher` = '" . $_SESSION['login'] . "'";
		break;
		case 2:
			$Query .= "1";
		break;
	}
	
	$Query .= " ORDER BY `ID`";
	$result = $connection->query($Query) or die($connection->error);
	
	$row = $result->fetch_row();
	$allResults = array();
	
	while($row)
	{
		array_push($allResults, $row);
		$row = $result->fetch_row();
	}
	
	echo json_encode($allResults);
}
else
	echo json_encode(array());
	
?>