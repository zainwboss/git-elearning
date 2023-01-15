<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

$filter_status = mysqli_real_escape_string($connection, $_POST['filter_status']);
$filter_date = mysqli_real_escape_string($connection, $_POST['filter_date']);
$filter_type = mysqli_real_escape_string($connection, $_POST['filter_type']);

$condition = "";
if ($filter_status == '1') {
    if (!empty($filter_date)) {
        $startDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[0])));
        $endDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[1])));

        $condition .= "AND (DATE(a.start_datetime) BETWEEN '$startDate' AND '$endDate')";
    }
}

if ($filter_type == 'pre') {
    $condition .= "AND a.exam_count ='1' ";
} else if ($filter_type == 'post') {
    $condition .= "AND a.exam_count !='1' ";
}

?>

<div class="table-responsive">
    <table class="table table-row-dashed table-row-gray-300 gy-7" id="tbl_course_report">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                <th class="text-start min-w-100px">ชื่อ-นามสกุล</th>
                <th class="text-center">ประเภท</th>
                <th class="text-center">วัน/เวลาที่เริ่มทำ</th>
                <th class="text-center">วัน/เวลาที่ทำเสร็จ</th>
                <th class="text-center">ระยะเวลา</th>
                <th class="text-center">คะแนน</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT a.*,b.fullname,b.profile_image FROM tbl_exam_head a 
                    JOIN tbl_user b ON a.user_id = b.user_id
                    WHERE a.course_id ='$course_id' AND a.finish_datetime IS NOT NULL $condition ORDER BY a.start_datetime DESC";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $list_type = "";
                if ($row['exam_count'] == 1) {
                    $list_type = 'ข้อสอบก่อนเรียน';
                } else {
                    $list_type = 'ข้อสอบหลังเรียนครั้งที่ ' . ($row['exam_count'] - 1);
                }

                $sql_ea = "SELECT * FROM tbl_exam_answer WHERE exam_head_id='{$row['exam_head_id']}' ";
                $rs_ea  = mysqli_query($connection, $sql_ea) or die($connection->error);

                //เปอร์เซ็นต์ที่ทำได้ 
                $exam_percent = ($row['correct_amount'] / $rs_ea->num_rows) * 100;
            ?>
                <tr>
                    <td class="text-start fw-bold">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-45px me-5">
                                <img style="object-fit:cover;" alt="image_user" src="../../images/<?php echo ($row['profile_image'] != '') ? $row['profile_image'] : 'blank.png' ?>">
                            </div>
                            <div class="d-flex justify-content-start flex-column">
                                <div class="">
                                    <div class="text-dark fw-bold text-hover-primary fs-6">
                                        <?php echo $row['fullname']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center fw-bold"><?php echo $list_type;  ?></td>
                    <td class="text-center fw-bold"><?php echo date('d/m/Y', strtotime($row['start_datetime'])) ?>
                        <br><?php echo date('H:i:s', strtotime($row['start_datetime']))  ?>
                    </td>
                    <td class="text-center fw-bold"><?php echo date('d/m/Y', strtotime($row['finish_datetime'])) ?>
                        <br><?php echo date('H:i:s', strtotime($row['finish_datetime']))  ?>
                    </td>
                    <td class="text-center fw-bold"><?php echo round(abs(strtotime($row['finish_datetime']) - strtotime($row['start_datetime'])) / 60) . ' นาที'; ?></td>

                    <td class="text-center fw-bold <?php echo ($row['pass_status'] == 1) ? 'text-success' : 'text-danger' ?>">
                        <?php echo $row['correct_amount'] . '/' .  $rs_ea->num_rows ?>
                        <br /><?php echo '(' . number_format($exam_percent, 2) . '%)' ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($connection); ?>