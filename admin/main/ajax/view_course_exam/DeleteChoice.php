<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$choice_id = mysqli_real_escape_string($connection, $_POST['choice_id']);

// ลบ choice
$sql = "SELECT choice_image FROM tbl_choice WHERE choice_id='$choice_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);
$path = "../../../../images/" . $row['choice_image'];
unlink($path);

$sql_delete = "DELETE FROM tbl_choice WHERE choice_id ='$choice_id'";
$rs_delete = mysqli_query($connection, $sql_delete) or die($connection->error);


if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
mysqli_close($connection);
