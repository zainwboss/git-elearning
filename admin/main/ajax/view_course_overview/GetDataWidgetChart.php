<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$data = [];
// พนักงานที่มีสิทธิ์อบรม
$sql = "SELECT COUNT(user_id) AS all_user FROM tbl_user WHERE active_status='1' 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

// พนักงานที่ยังไมไ่ด้ลงทะเบียนอบรม
$sql1 = "SELECT COUNT(user_id) AS count1 FROM tbl_user WHERE active_status='1' 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))
        AND user_id NOT IN(SELECT user_id FROM tbl_course_register WHERE course_id ='$course_id')";
$rs1  = mysqli_query($connection, $sql1) or die($connection->error);
$row1 = mysqli_fetch_array($rs1);

$labels1 = $row1['count1'];
$series1 = ($labels1 / $row['all_user']) * 100;

// พนักงานที่ลงทะเบียนอบรมแล้ว
$labels2 = $row['all_user'] - $row1['count1'];
$series2 = ($labels2 / $row['all_user']) * 100;

// พนักงานที่ผ่านการอบรมแล้ว
$sql3 = "SELECT COUNT(user_id) AS count3 FROM tbl_user WHERE active_status='1' 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))
        AND user_id IN(SELECT user_id FROM tbl_course_register WHERE course_id ='$course_id' AND finish_datetime IS NOT NULL)";
$rs3  = mysqli_query($connection, $sql3) or die($connection->error);
$row3 = mysqli_fetch_array($rs3);

$labels3 = $row3['count3'];
$series3 = ($labels3 / $labels2) * 100;

array_push($data, ["labels" => $labels2 . ' คน', "series" =>  $series2]);
array_push($data, ["labels" => $labels1  . ' คน', "series" =>  $series1]);
array_push($data, ["labels" => $labels3 . ' คน', "series" =>  $series3]);

echo json_encode($data);
mysqli_close($connection);
