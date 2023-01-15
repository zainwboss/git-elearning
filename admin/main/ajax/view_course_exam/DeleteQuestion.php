<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$question_id = mysqli_real_escape_string($connection, $_POST['question_id']);

// ลบคำตอบ
$sql2 = "SELECT choice_image FROM tbl_choice WHERE question_id='$question_id'";
$rs2 = mysqli_query($connection, $sql2) or die($connection->error);
while ($row2 = mysqli_fetch_array($rs2)) {
    $path = "../../../../images/" . $row2['choice_image'];
    unlink($path);
}
$sql_delete1 = "DELETE FROM tbl_choice WHERE question_id='$question_id'";
$rs_delete1 = mysqli_query($connection, $sql_delete1) or die($connection->error);

if ($rs_delete1) {
    //ลบคำถาม
    $sql = "SELECT * FROM tbl_question WHERE question_id='$question_id'";
    $rs = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    $path = "../../../../images/" . $row['question_image'];
    unlink($path);

    $sql_delete2 = "DELETE FROM tbl_question WHERE question_id ='$question_id'";
    $rs_delete2 = mysqli_query($connection, $sql_delete2) or die($connection->error);

    if ($rs_delete2) {

        // set list_Order ใหม่
        $sql_list = "SELECT * FROM tbl_question WHERE course_id='{$row['course_id']}' ORDER BY list_order ASC";
        $rs_list = mysqli_query($connection, $sql_list) or die($connection->error);
        $list_order = 0;
        while ($row_list = mysqli_fetch_array($rs_list)) {
            $list_order++;
            $sql_set = "UPDATE tbl_question SET list_order ='$list_order' WHERE question_id='{$row_list['question_id']}'";
            $rs_set  = mysqli_query($connection, $sql_set) or die($connection->error);
        }
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);
mysqli_close($connection);
