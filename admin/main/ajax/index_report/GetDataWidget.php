<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$filter_date = mysqli_real_escape_string($connection, $_POST['filter_date']);

$condition1 = "";
$condition2 = "";
$condition3 = "";
if (!empty($filter_date)) {
        $startDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[0])));
        $endDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[1])));

        $condition1 = "AND (course_start_date BETWEEN '$startDate' AND '$endDate')";
        $condition2 = "AND (DATE(create_datetime) BETWEEN '$startDate' AND '$endDate')";
        $condition3 = "AND (DATE(start_datetime) BETWEEN '$startDate' AND '$endDate')";
}

// หลักสูตรทั้งหมด
$sql_box1 = "SELECT * FROM tbl_course WHERE active_status='1' $condition1";
$rs_box1 =  mysqli_query($connection, $sql_box1) or die($connection->error);

// พนักงานทั้งหมด
$sql_box2 = "SELECT * FROM tbl_user WHERE active_status='1' $condition2";
$rs_box2 =  mysqli_query($connection, $sql_box2) or die($connection->error);

// ยังไม่ได้เข้าเรียน
$sql_box3 = "SELECT DISTINCT(user_id) FROM tbl_exam_head WHERE exam_count ='1' AND finish_datetime IS NOT NULL $condition3";
$rs_box3 =  mysqli_query($connection, $sql_box3) or die($connection->error);


$arr['box1'] = $rs_box1->num_rows;
$arr['box2'] = $rs_box2->num_rows;
$arr['box3'] =  $rs_box3->num_rows;
$arr['box4'] = ($rs_box2->num_rows -  $rs_box3->num_rows);

echo json_encode($arr);
mysqli_close($connection);
