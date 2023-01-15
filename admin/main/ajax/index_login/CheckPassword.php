<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$current_password = mysqli_real_escape_string($connection, $_POST['current_password']);

$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_assoc($rs);

$password = md5($current_password);
$secure_text = $row['secure_text'];
$secure_point = $row['secure_point'];
$secure = substr_replace($password, $secure_text, $secure_point, 0);
$current_password = md5($secure);

echo json_encode($current_password);
mysqli_close($connection);
