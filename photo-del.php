<?php
include("database.php");

$id_company 	= (isset($_GET['id_company'])) ? trim($_GET['id_company']) : '';

$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `company` WHERE `id_company`= '$id_company'"));

unlink("upload/" .$dat['photo']);

$rst_d = mysqli_query( $con, "UPDATE `company` SET `photo`='' WHERE `id_company` = '$id_company' " );

print "<script>self.location='a-company.php';</script>";
?>
