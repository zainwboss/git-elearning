<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$btn_no = mysqli_real_escape_string($connection, $_POST['btn_no']);

$start = ($btn_no - 1) * 20;
$sql = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id' ORDER BY list_order ASC limit {$start},20 ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);

$sql2 = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id'";
$rs2  = mysqli_query($connection, $sql2) or die($connection->error);
$total_record = mysqli_num_rows($rs2);
$total_exam = ceil($total_record / 20);

?>
<div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center mb-5 mb-lg-10">
    <?php
    $list_id = [];
    $i = 0;
    while ($row = mysqli_fetch_array($rs)) {
        $i++;
        array_push($list_id, $row['exam_id']);
    ?>
        <button type="button" id="subbtnExam_<?php echo $row['exam_id'] ?>" name="subbtnExam" class="btn btn-sm btn-hover-rise me-5 my-3 w-55px btn-light-info <?php if ($i == '1') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>" onclick="ActiveSubBtn('<?php echo $row['exam_id'] ?>')"><?php echo $row['list_order'] ?></button>
    <?php } ?>
</div>

<!-- ไว้เก็บ exam_id สำหรับบันทึกคำตอบ -->
<input type="hidden" id="exam_id" name="exam_id" value="<?php echo $list_id[0] ?>">
<!-- เลขปุ่มหลัก -->
<input type="hidden" id="btn_no" name="btn_no" value="<?php echo $btn_no ?>">

<?php
$sql_q = "SELECT a.* ,q.question_image,q.question_text,q.correct_choice_id FROM tbl_exam a 
          LEFT JOIN tbl_question q ON a.question_id = q.question_id 
          WHERE a.course_id='$course_id' AND a.user_id = '$user_id'
          ORDER BY a.list_order ASC limit {$start},20 ";
$rs_q  = mysqli_query($connection, $sql_q) or die($connection->error);

$i2 = 0;
$index = 0; //ลำดับของ array exam_id
while ($row_q = mysqli_fetch_array($rs_q)) {
    $i2++;
?>
    <div id="detailExam_<?php echo $row_q['exam_id'] ?>" name="detailExam" name="" <?php if ($i2 != 1) {
                                                                                        echo 'hidden';
                                                                                    } ?>>
        <div class="card hoverable" style="background-color: #CBD4F4">
            <div class="card-body">
                <div class="d-flex flex-column flex-center p-5">
                    <?php if ($row_q['question_image'] != '') { ?>
                        <div class="mb-10">
                            <img class="h-100px w-lg-550px h-lg-250px" src="../../images/<?php echo ($row_q['question_image'] != '') ? $row_q['question_image'] : 'no-image.jpg'; ?>" alt="image">
                        </div>
                    <?php } ?>
                    <div class="fw-bold fs-4 text-start text-break"><?php echo $row_q['question_text'] ?></div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <?php
            $sql_c = "SELECT * FROM tbl_choice WHERE question_id='{$row_q['question_id']}'";
            $rs_c  = mysqli_query($connection, $sql_c) or die($connection->error);
            while ($row_c = mysqli_fetch_assoc($rs_c)) {
            ?>
                <div class="rounded border p-7 d-flex align-items-center mb-5 <?php echo ($row_q['correct_choice_id'] == $row_c['choice_id']) ? 'bg-success' : 'bg-light-primary'; ?>">
                    <?php if ($row_c['choice_image'] != '') { ?>
                        <img class="w-100px h-100px w-lg-150px h-lg-150px me-8" src="../../images/<?php echo ($row_c['choice_image'] != '') ? $row_c['choice_image'] : 'no-image.jpg'; ?>" alt="image">
                    <?php } ?>
                    <span class="d-block fw-bold text-start">
                        <span class="text-dark fw-bolder d-block fs-3 text-break"><?php echo  $row_c['choice_text']; ?></span>
                    </span>
                </div>
            <?php } ?>
        </div>

        <div class="d-flex flex-stack flex-wrap mb-5">
            <div style="position: sticky;">
                <?php if ($btn_no != '1' && $index == 0) { ?>
                    <button type="button" class="btn btn-light-info btn-sm btn-hover-rise w-100px" onclick="PreviousBtnNo('<?php echo $btn_no - 1 ?>');">ก่อนหน้า</button>
                <?php } else { ?>
                    <button type="button" class="btn btn-light-info btn-sm btn-hover-rise w-100px" onclick=" NextPreviousBtn('<?php echo $list_id[$index - 1] ?>');" <?php if ($index == 0) {
                                                                                                                                                                            echo 'hidden';
                                                                                                                                                                        } ?>>ก่อนหน้า</button>
                <?php } ?>
            </div>
            <div style="position: sticky;">
                <?php if ($btn_no != $total_exam || ($index + 1) != $rs->num_rows) {
                    if (($index + 1) == $rs->num_rows) { ?>
                        <button type="button" class="btn btn-light-info btn-sm btn-hover-rise w-100px" onclick="NextBtnNo('<?php echo $btn_no + 1 ?>');">ถัดไป</button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-light-info btn-sm btn-hover-rise w-100px" onclick=" NextPreviousBtn('<?php echo $list_id[$index + 1] ?>');">ถัดไป</button>
                <?php }
                } ?>
            </div>
        </div>
    </div>
<?php
    $index++;
}
?>