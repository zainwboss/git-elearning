<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
$exam_head_id = getRandomID(10, "tbl_exam_head", "exam_head_id");
$register_id = getRandomID(10, "tbl_course_register", "register_id");

if (!empty($user_id)) {

    $course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
    $sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    if ($rs->num_rows > 0) { //เช็คหลักสูตร

        $sql_chk_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' ORDER BY create_datetime ASC";
        $rs_chk_eh = mysqli_query($connection, $sql_chk_eh) or die($connection->error);
        if ($rs_chk_eh->num_rows == 0) { //เช็คเป็น 1=pre หรือ >=2 post

            //pre จะ insert ข้อสอบเข้าไป
            $exam_count = 1;

            if ($row["shuffle_exam"] == "1") { //สลับข้อสอบ
                if ($row["random_exam"] == "1") { //สุ่มข้อสอบ
                    $sql_q = "SELECT q.* FROM tbl_question q  WHERE q.course_id = '$course_id' ORDER BY RAND() LIMIT {$row["random_amount"]}";
                } else {
                    $sql_q = "SELECT q.* FROM tbl_question q WHERE q.course_id = '$course_id' ORDER BY RAND()";
                }
            } else {
                $sql_q = "SELECT q.* FROM tbl_question q WHERE q.course_id = '$course_id' ORDER BY q.list_order ASC";
            }

            $rs_q = mysqli_query($connection, $sql_q);
            $list_order = 0;
            while ($row_q = mysqli_fetch_array($rs_q)) {
                $list_order++;

                $exam_id = getRandomID(10, "tbl_exam", "exam_id");
                $sql_ie = "INSERT INTO tbl_exam SET 
                        exam_id = '$exam_id' 
                        ,course_id = '$course_id' 
                        ,user_id = '$user_id'
                        ,list_order = '$list_order'  
                        ,question_id = '{$row_q['question_id']}'";
                $rs_ie = mysqli_query($connection, $sql_ie) or die($connection->error);

                $sql_ic = "INSERT INTO tbl_exam_answer SET 
                     exam_head_id = '$exam_head_id' 
                    ,exam_id = '$exam_id' ";
                $rs_ic = mysqli_query($connection, $sql_ic) or die($connection->error);
            }

            $sql_cr = "INSERT INTO tbl_course_register SET 
                         register_id = '$register_id' 
                        ,course_id = '$course_id' 
                        ,user_id = '$user_id'
                        ,register_datetime = now()";
            $rs_cr = mysqli_query($connection, $sql_cr) or die($connection->error);
        } else {
            //post ไม่ต้อง insert exam ใช้ข้อสอบชุดเดิมได้เลย
            $exam_count = $rs_chk_eh->num_rows + 1;

            $sql_e = "SELECT * FROM tbl_exam  WHERE course_id = '$course_id' AND user_id = '$user_id' ORDER BY list_order ASC";
            $rs_e = mysqli_query($connection, $sql_e);

            while ($row_e = mysqli_fetch_array($rs_e)) {
                $sql_ic = "INSERT INTO tbl_exam_answer SET 
                         exam_head_id = '$exam_head_id' 
                        ,exam_id = '{$row_e['exam_id']}'";
                $rs_ic = mysqli_query($connection, $sql_ic) or die($connection->error);
            }
        }

        $expire_datetime = date('Y-m-d H:i:s', strtotime('+' . $row['exam_time'] . ' minutes'));
        $sql_eh = "INSERT INTO tbl_exam_head SET 
                    exam_head_id = '$exam_head_id' 
                    ,course_id = '$course_id' 
                    ,user_id = '$user_id'
                    ,start_datetime = now()
                    ,expire_datetime = '$expire_datetime'
                    ,exam_count='$exam_count'";

        $rs_eh = mysqli_query($connection, $sql_eh) or die($connection->error);


        if ($rs_eh) {

            $arr['exam_head_id'] = $exam_head_id;
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 8;
    }
} else {
    $arr['result'] = 9;
}
echo json_encode($arr);
mysqli_close($connection);
