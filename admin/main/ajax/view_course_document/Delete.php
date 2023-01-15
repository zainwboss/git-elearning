<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$doc_id = mysqli_real_escape_string($connection, $_POST['doc_id']);

$sql = "SELECT doc_path FROM tbl_course_document WHERE doc_id ='$doc_id' ";
$rs = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($rs);

if ($row['doc_type'] != '6') {
    $file = "../../../../images/" . $row['doc_path'];
    unlink($file);
}

$sql_delete = "DELETE FROM tbl_course_document WHERE doc_id ='$doc_id'";
$rs_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

if ($rs_delete) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
