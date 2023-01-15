<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$certificate_type = mysqli_real_escape_string($connection, $_POST['certificate_type']);

$sql = "UPDATE tbl_course SET certificate_type = '$certificate_type' WHERE course_id='$course_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
