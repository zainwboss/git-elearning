<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
    $rs_admin = mysqli_query($connection, $sql_admin);
    $row_admin = mysqli_fetch_array($rs_admin);

    $arr['change_password_status'] = $row_admin['change_password_status'];
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
