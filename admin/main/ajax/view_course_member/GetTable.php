<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$filter_status = mysqli_real_escape_string($connection, $_POST['filter_status']);

$now = date('Y-m-d');
$sql_course = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_course  = mysqli_query($connection, $sql_course) or die($connection->error);
$row_course = mysqli_fetch_array($rs_course);

?>

<div class="table-responsive">
    <table class="table table-row-dashed table-row-gray-300 gy-7" id="tbl_course_member">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                <th class="text-start min-w-100px">ชื่อ-นามสกุล</th>
                <th class="text-center">วันที่ลงทะเบียน</th>
                <th class="text-center">คะแนนก่อนเรียน</th>
                <th class="text-center">คะแนนหลังเรียน</th>
                <th class="text-center">เปอร์เซนต์</th>
                <th class="text-center">จำนวนที่สอบ </th>
                <th class="text-center">ระยะเวลาการเรียน </th>
                <th class="text-center min-w-75px">สถานะ</th>
                <th class="text-center min-w-75px">ใบประกาศ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM tbl_user WHERE active_status='1' 
            AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id')) 
            ORDER BY fullname ASC";
            $rs  = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_array($rs)) {

                $user_id = $row['user_id'];
                $sql_cr = "SELECT * FROM tbl_course_register WHERE user_id='$user_id' AND course_id ='$course_id'";
                $rs_cr  = mysqli_query($connection, $sql_cr);
                $row_cr = mysqli_fetch_array($rs_cr);

                // คะแนนสอบก่อนเรียน
                $sql_pre = "SELECT correct_amount,finish_datetime FROM tbl_exam_head 
                            WHERE exam_count='1' AND finish_datetime IS NOT NULL AND course_id='$course_id' AND user_id='$user_id' ";
                $rs_pre   = mysqli_query($connection, $sql_pre) or die($connection->error);
                $row_pre  = mysqli_fetch_array($rs_pre);

                //คะแนนสอบหลังเรียน
                $sql_post = "SELECT COUNT(exam_count) AS exam_amount , MAX(correct_amount) AS correct_amount  FROM tbl_exam_head 
                             WHERE exam_count !='1' AND finish_datetime IS NOT NULL AND course_id='$course_id' AND user_id='$user_id'";
                $rs_post   = mysqli_query($connection, $sql_post) or die($connection->error);
                $row_post  = mysqli_fetch_array($rs_post);

                // เปรียบเทียบคะแนนสอบก่อนเรียนและหลังเรียน
                $percent = 0;
                $pre_correct_amount = $row_pre['correct_amount'];
                $post_correct_amount = $row_post['correct_amount'];
                if ($pre_correct_amount == 0) { //ถ้าสอบครั้งก่อนได้ 0 
                    $percent =  $post_correct_amount * 100;
                } else {
                    $percent = (($post_correct_amount - $pre_correct_amount) / $pre_correct_amount) * 100;
                }

                //สถานะ
                $status = "";
                $status_certificate = 0;
                if ($rs_cr->num_rows > 0) { //มีการลงทะเบียน (เริ่มทำพรีแล้วแต่ไม่รู้ว่าทำเสร็จรึยังเช็คต่อในเงื่อนไขต่อไป)**
                    if ($row_cr['finish_exam_head_id'] != '') { //ทำข้อสอบหลังเรียนผ่านแล้ว
                        $status_certificate = 1;
                        $status = '<span class="badge badge-light-success">ผ่านการอบรม</span>';
                        $chk_status = '4';
                    } else { //ทำข้อสอบหลังเรียนยังไม่ผ่าน
                        if ($row_course['course_finish_date'] >= $now || $row_course['course_finish_date'] == '') { //ยังไม่ผ่านแต่หมดระยะเวลาคอร์สแล้ว
                            if ($row_pre['finish_datetime'] != '') {  //ทำพรีเสร็จแล้ว**
                                $status = '<span class="badge badge-light-warning">อยู่ระหว่างอบรม</span>';
                                $chk_status = '3';
                            } else {
                                $status = '<span class="badge badge-light-primary">ยังไม่ลงทะเบียน</span>';
                                $chk_status = '1';
                            }
                        } else {
                            $status = '<span class="badge badge-light-danger">ไม่ผ่านหลักสูตร</span>';
                            $chk_status = '5';
                        }
                    }
                } else { //ไม่มีการลงทะเบียน (ยังไม่เริ่มทำพรี)
                    if ($row_course['course_finish_date'] >= $now || $row_course['course_finish_date'] == '') { //ไม่มีการลงทะเบียนและหมดระยะเวลาคอร์สแล้ว
                        $status = '<span class="badge badge-light-primary">ยังไม่ลงทะเบียน</span>';
                        $chk_status = '1';
                    } else {
                        $status = '<span class="badge badge-light-danger">ไม่ผ่านหลักสูตร</span>';
                        $chk_status = '5';
                    }
                }
            ?>
                <?php if ($filter_status == 'all' || ($filter_status == '2' && ($chk_status == '3' || $chk_status == '4')) || ($filter_status != '2' && $chk_status == $filter_status)) { ?>
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
                        <td class="text-center fw-bold"><?php echo ($row_cr['register_datetime'] != '') ? date('d/m/Y', strtotime($row_cr['register_datetime'])) : '-'; ?></td>
                        <td class="text-center fw-bold"><?php echo ($row_pre['correct_amount'] != '') ? $row_pre['correct_amount'] : '-'; ?></td>
                        <td class="text-center fw-bold"><?php echo ($row_post['correct_amount'] != '') ? $row_post['correct_amount'] : '-';  ?></td>
                        <td class="text-center fw-bold">
                            <?php
                            if ($rs_cr->num_rows > 0 &&  $row_post['exam_amount'] != '0') { //ต้องมีการลงทะเบียนและมีการเริ่มทำหลังเรียนแล้ว
                                if ($post_correct_amount > $pre_correct_amount) { ?>
                                    <span class="badge badge-light-success ">
                                        <span class="svg-icon svg-icon-1 svg-icon-success ms-n1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                                                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <?php echo number_format($percent, 2) . ' %' ?>
                                    </span>
                                <?php } else if ($post_correct_amount < $pre_correct_amount) {
                                ?>
                                    <span class="badge badge-light-danger">
                                        <span class="svg-icon svg-icon-1 svg-icon-danger ms-n1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                                                <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <?php echo number_format($percent, 2) . ' %' ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="badge badge-light-primary"> คงที่ </span>
                            <?php }
                            } else {
                                echo '-';
                            } ?>
                        </td>
                        <td class="text-center fw-bold"><?php echo ($row_post['exam_amount'] != '' && $row_post['exam_amount'] != '0') ? $row_post['exam_amount'] : '-'; ?></td>
                        <td class="text-center fw-bold"><?php echo ($rs_cr->num_rows > 0) ? date('H:i:s', mktime(0, 0, $row_cr['study_time'])) : '-'; ?></td>

                        <td class="text-center"><?php echo $status; ?></td>
                        <td class="text-center">
                            <?php if ($status_certificate == 1) { ?>
                                <a href="../../print/certificate.php?id=<?= $course_id ?>&id2=<?= $user_id ?>&key=<?= rand(11111, 99999); ?>" target="_blank" class="btn btn-sm btn-icon btn-light-info btn-hover-rise me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor" />
                                            <path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($connection); ?>