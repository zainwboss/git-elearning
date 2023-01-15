<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$exam_head_id = mysqli_real_escape_string($connection, $_POST['exam_head_id']);

$sql2 = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id'";
$rs2  = mysqli_query($connection, $sql2) or die($connection->error);
$total_record = mysqli_num_rows($rs2);
$total_exam = ceil($total_record / 20);

?>
<!-- จำนวนข้อสอบต่อชุด -->
<input type="hidden" id="total_exam" name="total_exam" value="<?php echo $total_exam ?>">

<div class="d-flex flex-wrap align-items-center mb-5 mb-lg-10">
    <?php
    for ($i = 1; $i <= $total_exam; $i++) {
        $start = ($i - 1) * 20;

        $sql_chk = "SELECT * FROM tbl_exam a 
        LEFT JOIN tbl_exam_answer b ON a.exam_id = b.exam_id
        WHERE a.course_id='$course_id' AND a.user_id = '$user_id' AND b.exam_head_id ='$exam_head_id'
        ORDER BY a.list_order ASC LIMIT $start,20 ";
        $rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
        $status_finish = 0;
        while ($row_chk = mysqli_fetch_assoc($rs_chk)) {
            if ($row_chk['choice_id'] == '') {
                $status_finish = 1;
            }
        }

        $s_index = (($i - 1) * 20) + 1;
        if ($i == $total_exam) {
            $e_index = $total_record;
        } else {
            $e_index = $i * 20;
        }
    ?>
        <button type="button" class="btn  btn-sm btn-hover-rise me-5 my-3 w-80px <?php echo ($status_finish == 0) ? 'btn_finish btn-success' : 'btn-light-info' ?>" id="btnExam<?php echo $i ?>" name="btnExam" onclick="GetSubBtnExam('<?php echo $i ?>');"><?php echo $s_index . ' - ' . $e_index  ?></button>
    <?php } ?>
</div>