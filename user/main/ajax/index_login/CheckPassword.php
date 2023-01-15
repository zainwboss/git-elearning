<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$current_password = mysqli_real_escape_string($connection, md5($_POST['current_password']));

echo json_encode($current_password);
mysqli_close($connection);
