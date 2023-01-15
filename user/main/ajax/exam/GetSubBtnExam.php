<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$btn_no = mysqli_real_escape_string($connection, $_POST['btn_no']);
$exam_head_id = mysqli_real_escape_string($connection, $_POST['exam_head_id']);

$start = ($btn_no - 1) * 20;
$sql = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id' ORDER BY list_order ASC limit {$start},20 ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);

$sql2 = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '$user_id'";
$rs2  = mysqli_query($connection, $sql2) or die($connection->error);
$total_record = mysqli_num_rows($rs2);
$total_exam = ceil($total_record / 20);

//เช็คปุ่มส่งข้อสอบกรณีกลับมาทำข้อสอบต่อ
$sql_chk_ans = "SELECT choice_id FROM tbl_exam_answer WHERE exam_head_id='$exam_head_id'";
$rs_chk_ans  = mysqli_query($connection, $sql_chk_ans) or die($connection->error);
$status_send_exam = 0;
while ($row_chk_ans = mysqli_fetch_array($rs_chk_ans)) {
    if ($row_chk_ans['choice_id'] == '') {
        $status_send_exam = 1;
    }
}

//คอร์ส ใช้สำหรับสลับ choice
$sql_c = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_c = mysqli_query($connection, $sql_c) or die($connection->error);
$row_c = mysqli_fetch_array($rs_c);
if ($row_c["shuffle_choice"] == "1") {
    $shuffle_choice = "ORDER BY RAND()";
} else {
    $shuffle_choice = "ORDER BY list_order ASC";
}

?>
<div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center mb-5 mb-lg-10">
    <?php
    $list_id = [];
    $i = 0;
    while ($row = mysqli_fetch_array($rs)) {
        $i++;
        array_push($list_id, $row['exam_id']);
        $sql_ans = "SELECT choice_id FROM tbl_exam_answer WHERE exam_head_id='$exam_head_id' AND exam_id ='{$row['exam_id']}'";
        $rs_ans  = mysqli_query($connection, $sql_ans) or die($connection->error);
        $row_ans  = mysqli_fetch_assoc($rs_ans);
    ?>
        <button type="button" id="subbtnExam_<?php echo $row['exam_id'] ?>" name="subbtnExam" class="btn btn-sm btn-hover-rise me-5 my-3 w-55px <?php echo ($row_ans['choice_id'] == '') ? '' : 'btn_sub_finish' ?> <?php echo ($row_ans['choice_id'] == '' || $i == '1') ? 'btn-light-info' : 'btn-success' ?> <?php if ($i == '1') {
                                                                                                                                                                                                                                                                                                                    echo 'active';
                                                                                                                                                                                                                                                                                                                } ?>" onclick="ActiveSubBtn('<?php echo $row['exam_id'] ?>')"><?php echo $row['list_order'] ?></button>
    <?php } ?>
</div>

<!-- ไว้เก็บ exam_id สำหรับบันทึกคำตอบ -->
<input type="hidden" id="exam_id" name="exam_id" value="<?php echo $list_id[0] ?>">
<!-- เลขปุ่มหลัก -->
<input type="hidden" id="btn_no" name="btn_no" value="<?php echo $btn_no ?>">
<!-- จำนวนปุ่มข้อสอบของชุดนี้ -->
<input type="hidden" id="btn_this_exam" name="btn_this_exam" value="<?php echo $rs->num_rows ?>">

<?php
$sql_q = "SELECT a.* ,q.question_image,q.question_text FROM tbl_exam a 
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
            $sql_c = "SELECT * FROM tbl_choice WHERE question_id='{$row_q['question_id']}' $shuffle_choice";
            $rs_c  = mysqli_query($connection, $sql_c) or die($connection->error);
            while ($row_c = mysqli_fetch_assoc($rs_c)) {

                $sql_ans = "SELECT choice_id FROM tbl_exam_answer WHERE exam_head_id='$exam_head_id' AND exam_id ='{$row_q['exam_id']}'";
                $rs_ans  = mysqli_query($connection, $sql_ans) or die($connection->error);
                $row_ans  = mysqli_fetch_assoc($rs_ans);

            ?>
                <input type="radio" class="btn-check" name="choice_id_<?php echo $row_q['exam_id'] ?>" id="choice_id_<?php echo $row_c['choice_id']; ?>" data-choice_id="<?php echo $row_c['choice_id']; ?>" value="1" <?php if ($row_ans['choice_id'] == $row_c['choice_id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>  />
                <label class="btn border btn-light-primary btn-active-success p-7 d-flex align-items-center mb-5" for="choice_id_<?php echo $row_c['choice_id']; ?>">
                    <?php if ($row_c['choice_image'] != '') { ?>
                        <img class="w-100px h-100px w-lg-150px h-lg-150px me-8" src="../../images/<?php echo ($row_c['choice_image'] != '') ? $row_c['choice_image'] : 'no-image.jpg'; ?>" alt="image">
                    <?php } ?>
                    <span class="d-block fw-bold text-start">
                        <span class="text-dark fw-bolder d-block fs-3 text-break"><?php echo $row_c['choice_text']; ?></span>
                    </span>
                </label>
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
        <div class="d-flex flex-center">
            <button type="button" onclick="SendExam();" class="btn btn-icon btn-light-primary pulse pulse-success p-5 w-50" id="send_exam" <?php if ($status_send_exam == 1) {
                                                                                                                                                echo 'hidden';
                                                                                                                                            } ?>>
                <span class="svg-icon svg-icon-3 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor" />
                        <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor" />
                    </svg>
                </span>
                <span class="pulse-ring"></span>
                <span class="indicator-label">ส่งข้อสอบ</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
<?php
    $index++;
}
?>