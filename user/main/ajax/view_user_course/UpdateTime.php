<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
if (!empty($user_id)) { //เช็ค user_id

    $course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
    $sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    if ($rs->num_rows > 0) { //เช็คหลักสูตร

        $hours = mysqli_real_escape_string($connection, $_POST['h']);
        $minutes = mysqli_real_escape_string($connection, $_POST['m']);
        $seconds = mysqli_real_escape_string($connection, $_POST['s']);
        $study_time = $hours * 3600 + $minutes * 60 + $seconds;

        $sql_cr = "UPDATE tbl_course_register  SET study_time='$study_time' WHERE course_id ='$course_id' AND user_id ='$user_id'";
        $rs_cr  = mysqli_query($connection, $sql_cr) or die($connection->error);

        if ($rs_cr) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 2;
        }
    } else {
        $arr['result'] = 8;
    }
} else {
    $arr['result'] = 9;
}
echo json_encode($arr);
mysqli_close($connection);
