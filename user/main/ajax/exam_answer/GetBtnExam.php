<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);

$exam_head_id = mysqli_real_escape_string($connection, $_POST['exam_head_id']);

$sql2 = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id'";
$rs2  = mysqli_query($connection, $sql2) or die($connection->error);
$total_record = mysqli_num_rows($rs2);
$total_exam = ceil($total_record / 20);

?>
<!-- จำนวนข้อสอบต่อชุด -->
<input type="hidden" id="total_exam" name="total_exam" value="<?php echo $total_exam ?>">

<div class="d-flex flex-wrap align-items-center mb-2 mb-lg-4">
    <?php
    for ($i = 1; $i <= $total_exam; $i++) {
        $s_index = (($i - 1) * 20) + 1;
        if ($i == $total_exam) {
            $e_index = $total_record;
        } else {
            $e_index = $i * 20;
        }

    ?>
        <button type="button" class="btn  btn-sm btn-hover-rise me-5 my-3 w-80px btn-light-info" id="btnExam<?php echo $i ?>" name="btnExam" onclick="GetSubBtnExam('<?php echo $i ?>');"><?php echo $s_index . ' - ' . $e_index  ?></button>
    <?php } ?>
</div>