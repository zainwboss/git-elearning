<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

$sql = "SELECT * FROM tbl_course WHERE course_id = '$course_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

if ($row['active_status'] == 1) {
    $status = 0;
} else {
    $status = 1;
}

$arr['status'] = $status;

$sql_update = "UPDATE tbl_course SET 
				active_status = '$status'
				WHERE course_id = '$course_id'";

if (mysqli_query($connection, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
