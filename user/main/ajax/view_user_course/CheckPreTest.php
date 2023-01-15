<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
$now = date('Y-m-d');

if (!empty($user_id)) { //เช็ค user_id

    $course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
    $sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    if ($rs->num_rows > 0) { //เช็คหลักสูตร
        if ($row['course_finish_date'] >= $now || $row['course_finish_date'] == '') {  // เช็คคอร์สหมดเวลาโชว์

            $sql_chk_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND exam_count='1'";
            $rs_chk_eh = mysqli_query($connection, $sql_chk_eh) or die($connection->error);
            $row_chk_eh = mysqli_fetch_array($rs_chk_eh);
            if ($rs_chk_eh->num_rows == 0) { //เช็คมีการทำ pre รึยัง 
                $arr['result'] = 1; //ยังไม่มีการเริ่มทำข้อสอบ pre
            } else {
                if ($row_chk_eh['finish_datetime'] != '') { //เช็คทำ pre เสร็จรึยัง
                    $sql_cp = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND exam_count!='1' AND pass_status ='1'";
                    $rs_cp = mysqli_query($connection, $sql_cp) or die($connection->error);
                    if ($rs_cp->num_rows == 0) { //เช็คมีการทำข้อสอบผ่านรึยัง
                        $arr['result'] = 2; //ทำข้อสอบหลังเรียนยังไม่ผ่าน
                    } else {
                        $arr['result'] = 3;  //ทำข้อสอบหลังเรียนผ่านแล้ว
                    }
                } else {
                    $arr['result'] = 1;  //ยังทำข้อสอบ pre ไม่เสร็จ
                }
            }
        } else {
            $arr['result'] = 4; //หลักสูตรเกินเวลาที่กำหนด
        }
    } else {
        $arr['result'] = 8; //ไม่พบหลักสูตร
    }
} else {
    $arr['result'] = 9; //ไม่พบ user
}
echo json_encode($arr);
mysqli_close($connection);
