<?php
require "../settingsPHP/SQLLogin.php";

$Target = $_POST['id'];
$Ammount = $_POST['amt'];

$Query = "UPDATE Obligations SET `PartPay` = '$Ammount' WHERE `ID`='$Target'";

$connection->query($Query);
var_dump($connection);

?>