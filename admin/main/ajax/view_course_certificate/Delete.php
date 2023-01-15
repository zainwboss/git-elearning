<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$cs_id = mysqli_real_escape_string($connection, $_POST['cs_id']);

$sql = "SELECT * FROM tbl_course_cer_setting WHERE cs_id ='$cs_id' ";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

if ($row['setting_type'] == 1) {
    $file = "../../../../images/" . $row['image_file'];
    unlink($file);
}

$sql_delete = "DELETE FROM tbl_course_cer_setting WHERE cs_id ='$cs_id'";
$rs_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

if ($rs_delete) {

    $list_order = 0;
    $sql_list = "SELECT * FROM tbl_course_cer_setting WHERE course_id ='$course_id' ORDER BY list_order ASC";
    $rs_list  = mysqli_query($connection, $sql_list) or die($connection->error);
    while ($row_list  = mysqli_fetch_array($rs_list)) {
        $list_order++;
        $sql_update = "UPDATE tbl_course_cer_setting SET list_order = '$list_order' WHERE cs_id='{$row_list['cs_id']}'";
        $rs_update = mysqli_query($connection, $sql_update) or die($connection->error);
    }

    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
