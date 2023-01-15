<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$user_id = $_SESSION['user_id'];
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$exam_head_id = mysqli_real_escape_string($connection, $_POST['exam_head_id']);

if (!empty($user_id)) { //เช็ค user_id

    $sql_c = "SELECT *FROM tbl_course WHERE course_id='$course_id' ";
    $rs_c  = mysqli_query($connection, $sql_c) or die($connection->error);
    $row_c = mysqli_fetch_array($rs_c);
    if ($rs_c->num_rows > 0) { //เช็คหลักสูตร

        //ดึงหมดเวลาทำข้อสอบมาเช็ค
        $sql_date_eh = "SELECT * FROM tbl_exam_head  WHERE exam_head_id='$exam_head_id'";
        $rs_date_eh  = mysqli_query($connection, $sql_date_eh) or die($connection->error);
        $row_date_eh = mysqli_fetch_array($rs_date_eh);

        $sql_ans = "SELECT a.*,b.question_id FROM tbl_exam_answer a 
          JOIN tbl_exam b ON a.exam_id=b.exam_id
          WHERE a.exam_head_id='$exam_head_id'";
        $rs_ans  = mysqli_query($connection, $sql_ans) or die($connection->error);

        $correct_amount = 0;
        while ($row_ans = mysqli_fetch_assoc($rs_ans)) {

            $sql_q = "SELECT correct_choice_id FROM tbl_question WHERE question_id='{$row_ans['question_id']}'";
            $rs_q  = mysqli_query($connection, $sql_q) or die($connection->error);
            $row_q = mysqli_fetch_assoc($rs_q);

            $condition = "";
            //เช็คการโกงสคริปเวลา เวลาที่บันทึกคำตอบกับเวลาที่ทำข้อสอบ
            if ($row_ans['choice_datetime'] > $row_date_eh['expire_datetime']) {
                $correct_status = 0;
                $condition = ",choice_id = NULL";
            } else {
                //เช็คคำตอบที่ถูก
                if ($row_q['correct_choice_id'] == $row_ans['choice_id']) {
                    $correct_status = 1;
                    $correct_amount++;
                } else {
                    $correct_status = 0;
                }
            }

            $sql = "UPDATE tbl_exam_answer SET correct_status='$correct_status' $condition WHERE exam_head_id='$exam_head_id' AND exam_id='{$row_ans['exam_id']}'";
            $rs  = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
        }

        $tmp_percent = ($correct_amount / $rs_ans->num_rows) * 100;
        if ($tmp_percent >= $row_c["pass_percent"]) {
            $pass_status = 1;

            $sql_cr = "UPDATE tbl_course_register SET finish_datetime = now(),finish_exam_head_id = '$exam_head_id' WHERE course_id='$course_id' AND user_id='$user_id'";
            $rs_cr = mysqli_query($connection, $sql_cr) or die($connection->error);
        } else {
            $pass_status = 0;
        }

        $sql_eh = "UPDATE tbl_exam_head SET finish_datetime = now(),correct_amount='$correct_amount' ,pass_status='$pass_status' $condition2 WHERE exam_head_id='$exam_head_id'";
        $rs_eh  = mysqli_query($connection, $sql_eh) or die($connection->error);
        $row_eh = mysqli_fetch_array($rs_eh);

        $arr['result'] = 1;
    } else {
        $arr['result'] = 8; //ไม่พบหลักสูตร
    }
} else {
    $arr['result'] = 9; //ไม่พบ user
}

echo json_encode($arr);
mysqli_close($connection);
