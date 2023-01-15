<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $rs_user = mysqli_query($connection, $sql_user);
    $row_user = mysqli_fetch_array($rs_user);

    $arr['change_password_status'] =  $row_user['change_password_status'];
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
