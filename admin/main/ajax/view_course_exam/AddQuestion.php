<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$question_id = getRandomID(10, "tbl_question", "question_id");
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$list_order = mysqli_real_escape_string($connection, $_POST['count_btn']);

$sql = "INSERT INTO tbl_question SET 
                 course_id = '$course_id'
                ,question_id = '$question_id' 
                ,list_order = '$list_order' 
        ";
$rs = mysqli_query($connection, $sql) or die($connection->error);

if ($rs) {
    $arr['question_id'] = $question_id;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
