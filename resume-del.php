<?php
include("database.php");

$id_user 	= (isset($_GET['id_user'])) ? trim($_GET['id_user']) : '';

$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `resume` FROM `user` WHERE `id_user`= '$id_user'"));

unlink("upload/" .$dat['resume']);

$rst_d = mysqli_query( $con, "UPDATE `user` SET `resume`='' WHERE `id_user` = '$id_user' " );

print "<script>self.location='profile.php';</script>";
?>
