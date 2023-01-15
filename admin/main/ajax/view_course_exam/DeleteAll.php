<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

$sql_q = "SELECT * FROM tbl_question WHERE course_id='$course_id' ORDER BY list_order ASC";
$rs_q = mysqli_query($connection, $sql_q) or die($connection->error);
while ($row_q = mysqli_fetch_array($rs_q)) {

    // ลบคำตอบ
    $sql_c = "SELECT choice_image FROM tbl_choice WHERE question_id='{$row_q['question_id']}' ORDER BY list_order ASC";
    $rs_c = mysqli_query($connection, $sql_c) or die($connection->error);
    while ($row_c = mysqli_fetch_array($rs_c)) {
        $path = "../../../../images/" . $row_c['choice_image'];
        unlink($path);

        $sql_delete1 = "DELETE FROM tbl_choice WHERE choice_id='{$row_c['choice_id']}'";
        $rs_delete1 = mysqli_query($connection, $sql_delete1) or die($connection->error);
    }

    //ลบคำถาม
    $path = "../../../../images/" . $row_q['question_image'];
    unlink($path);

    $sql_delete2 = "DELETE FROM tbl_question WHERE question_id ='{$row_q['question_id']}'";
    $rs_delete2 = mysqli_query($connection, $sql_delete2) or die($connection->error);
}

$arr['result'] = 1;

echo json_encode($arr);
mysqli_close($connection);
