<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$group_name = mysqli_real_escape_string($connection, $_POST['group_name']);
$group_color = mysqli_real_escape_string($connection, $_POST['group_color']);

$sql = "INSERT INTO tbl_group SET group_name = '$group_name',group_color = '$group_color'";

$rs = mysqli_query($connection, $sql);

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
