<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$question_id = mysqli_real_escape_string($connection, $_POST['question_id']);
$list_order = mysqli_real_escape_string($connection, $_POST['count_choice']);

$sql = "INSERT INTO tbl_choice SET question_id ='$question_id', list_order = '$list_order'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$choice_id = mysqli_insert_id($connection);

if ($rs) {
    $arr['choice_id'] = $choice_id;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
mysqli_close($connection);
