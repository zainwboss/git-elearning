<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$exam_head_id = mysqli_real_escape_string($connection, $_POST['exam_head_id']);
$exam_id = mysqli_real_escape_string($connection, $_POST['exam_id']);
$choice_id = mysqli_real_escape_string($connection, $_POST['choice_id']);

$sql = "UPDATE tbl_exam_answer SET choice_id = '$choice_id',choice_datetime = now() WHERE exam_head_id='$exam_head_id' AND exam_id='$exam_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
