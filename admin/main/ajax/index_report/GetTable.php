<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$filter_date = mysqli_real_escape_string($connection, $_POST['filter_date']);
$now = date('Y-m-d');
$condition = "";
if (!empty($filter_date)) {
    $startDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[0])));
    $endDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[1])));
    $condition = "AND (CASE WHEN a.course_finish_date IS NOT NULL 
                         THEN DATE(a.course_finish_date) >= '$now' AND DATE(a.course_start_date) <='$endDate' 
                         ELSE DATE(a.course_start_date) <='$endDate' 
                       END)";
}

?>

<div class="table-responsive">
    <table class="table table-row-dashed border table-row-gray-300 gy-7" id="tbl_report">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800 align-middle border-bottom border-end border-gray-200">
                <th class="text-center" rowspan="2">ชื่อหลักสูตร</th>
                <th class="text-center" colspan="4">ก่อนเรียน</th>
                <th class="text-center" colspan="6">หลังเรียน</th>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800 align-middle border-bottom border-end border-gray-200">
                <!-- ก่อนเรียน -->
                <th class="text-center">คะแนนต่ำสุด</th>
                <th class="text-center">คะแนนเฉลี่ย</th>
                <th class="text-center">คะแนนสูงสุด</th>
                <th class="text-center">รายชื่อพนักงานที่ได้คะแนนสูงสุด</th>

                <!-- หลังเรียน -->
                <th class="text-center">คะแนนต่ำสุด</th>
                <th class="text-center">คะแนนเฉลี่ย</th>
                <th class="text-center">คะแนนสูงสุด</th>
                <th class="text-center">รายชื่อพนักงานที่ได้คะแนนสูงสุด</th>
                <th class="text-center">เวลาเฉลี่ยการเรียนจบหลักสูตร (นาที)</th>
                <th class="text-center">จำนวนครั้งของการสอบหลังเรียนจนสอบผ่าน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT a.* FROM tbl_course a WHERE 1 $condition ORDER BY a.course_name ASC";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $course_id = $row['course_id'];

                // ค่าเฉลี่ยคะแนนสอบก่อนเรียน
                $sql_pre = "SELECT IFNULL(MAX(a.correct_amount),0) AS max_pre,IFNULL(MIN(a.correct_amount),0) AS min_pre,IFNULL(AVG(a.correct_amount),0) AS avg_pre,b.fullname
                             FROM tbl_exam_head a
                             JOIN tbl_user b ON a.user_id = b.user_id
                             WHERE a.exam_count='1' AND a.finish_datetime IS NOT NULL AND a.course_id='$course_id'";
                $rs_pre   = mysqli_query($connection, $sql_pre) or die($connection->error);
                $row_pre  = mysqli_fetch_array($rs_pre);

                // ค่าเฉลี่ยคะแนนสอบหลังเรียน
                $sql_post = "SELECT  IFNULL(MAX(a.correct_amount),0) AS max_post,IFNULL(MIN(a.correct_amount),0) AS min_post,IFNULL(AVG(a.correct_amount),0) AS avg_post,b.fullname 
                             FROM tbl_exam_head a
                             JOIN tbl_user b ON a.user_id = b.user_id
                             WHERE a.exam_count !='1' AND a.finish_datetime IS NOT NULL AND a.course_id='$course_id'";
                $rs_post   = mysqli_query($connection, $sql_post) or die($connection->error);
                $row_post  = mysqli_fetch_array($rs_post);

                // เวลาเฉลี่ยการเรียนจบหลักสูตร
                $sql_cr = "SELECT IFNULL(AVG(study_time),0) AS avg_finish FROM tbl_course_register WHERE finish_datetime IS NOT NULL AND course_id='$course_id'";
                $rs_cr   = mysqli_query($connection, $sql_cr) or die($connection->error);
                $row_cr  = mysqli_fetch_array($rs_cr);

                $sql_exam = "SELECT COUNT(*) AS count_exam FROM tbl_exam_head WHERE finish_datetime IS NOT NULL AND course_id='$course_id' AND pass_status ='0'";
                $rs_exam   = mysqli_query($connection, $sql_exam) or die($connection->error);
                $row_exam  = mysqli_fetch_array($rs_exam);
            ?>
                <tr id="tr_<?php echo $row['course_id']; ?>">
                    <td class="text-center fw-bold"><?php echo $row['course_name']; ?></td>
                    <!-- ก่อนเรียน -->
                    <td class="text-center fw-bold"><?php echo $row_pre['min_pre']; ?></td>
                    <td class="text-center fw-bold"><?php echo number_format($row_pre['avg_pre'], 2); ?></td>
                    <td class="text-center fw-bold"><?php echo $row_pre['max_pre']; ?></td>
                    <td class="text-center fw-bold"><?php echo ($row_pre['fullname'] != '') ? $row_pre['fullname'] : '-'; ?></td>
                    <!-- หลังเรียน -->
                    <td class="text-center fw-bold"><?php echo $row_post['min_post']; ?></td>
                    <td class="text-center fw-bold"><?php echo number_format($row_post['avg_post'], 2); ?></td>
                    <td class="text-center fw-bold"><?php echo $row_post['max_post']; ?></td>
                    <td class="text-center fw-bold"><?php echo ($row_post['fullname'] != '') ? $row_post['fullname'] : '-'; ?></td>
                    <td class="text-center fw-bold"><?php echo number_format($row_cr['avg_finish']); ?></td>
                    <td class="text-center fw-bold"><?php echo number_format($row_exam['count_exam']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($connection); ?>