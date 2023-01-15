<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT c.*,t.* FROM tbl_course c
        LEFT JOIN tbl_teacher t ON c.teacher_id=t.teacher_id
        WHERE c.course_id='$course_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$sql_document = "SELECT *FROM tbl_course_document WHERE course_id ='$course_id' ORDER BY list_order ASC";
$rs_document = mysqli_query($connection, $sql_document);

$sql_cr = "SELECT * FROM tbl_course_register WHERE course_id ='$course_id' AND user_id ='$user_id'";
$rs_cr = mysqli_query($connection, $sql_cr) or die($connection->error);
$row_cr = mysqli_fetch_array($rs_cr);

if ($rs_cr->num_rows > 0) { //เช็คว่าเคยมีการสมัครรึยัง
    $time = date('H:i:s', mktime(0, 0, $row_cr['study_time']));
    $hours =  explode(':', $time)[0];
    $minutes = explode(':', $time)[1];
    $seconds = explode(':', $time)[2];
} else {
    $hours = '00';
    $minutes = '00';
    $seconds = '00';
}


$sql_box1 = "SELECT MAX(correct_amount) AS high_score FROM tbl_exam_head WHERE course_id ='$course_id' AND exam_count !='1' AND finish_datetime IS NOT NULL";
$rs_box1 =  mysqli_query($connection, $sql_box1) or die($connection->error);
$row_box1 = mysqli_fetch_array($rs_box1);

$sql_box2 = "SELECT COUNT(DISTINCT(user_id)) AS box2 FROM tbl_exam_head WHERE course_id ='$course_id' AND (exam_count = 1 AND finish_datetime IS NOT NULL)
             AND user_id NOT IN(SELECT user_id FROM tbl_exam_head WHERE course_id ='$course_id' AND exam_count !='1' AND pass_status ='1')";
$rs_box2  = mysqli_query($connection, $sql_box2) or die($connection->error);
$row_box2 = mysqli_fetch_array($rs_box2);

$sql_box3 = "SELECT * FROM tbl_course_register WHERE course_id ='$course_id' AND finish_datetime IS NOT NULL";
$rs_box3  = mysqli_query($connection, $sql_box3) or die($connection->error);
$row_box3 = mysqli_fetch_array($rs_box3);

// $sql_box4 = "SELECT exam_head_id,correct_amount,DENSE_RANK() OVER (PARTITION BY user_id ORDER BY correct_amount DESC) AS  my_rank FROM tbl_exam_head WHERE course_id ='$course_id' AND exam_count !='1' AND finish_datetime IS NOT NULL ";

$sql_box4 = "WITH rnk AS (SELECT exam_head_id,user_id,MAX(correct_amount) as high_score,RANK() OVER (ORDER BY high_score DESC) AS my_rank FROM tbl_exam_head WHERE course_id ='$course_id ' AND exam_count !='1' AND finish_datetime IS NOT NULL GROUP BY user_id) 
SELECT exam_head_id,user_id ,high_score ,  my_rank FROM rnk WHERE user_id='$user_id'";
$rs_box4  = mysqli_query($connection, $sql_box4) or die($connection->error);
$row_box4 = mysqli_fetch_array($rs_box4);

?>
<?php
if ($rs->num_rows > 0) { //เช็คหลักสูตร 
?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo $row['course_name'] ?></h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index_course.php">รายการหลักสูตร</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">ภาพรวม</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <div class="d-flex flex-column flex-xl-row">
                    <div class="flex-lg-row-fluid mb-6">

                        <?php echo $row['vimeo_embed'] ?>

                        <div class="card card-flush mt-6 mt-xl-9">
                            <div class="card-header">
                                <div class="card-title flex-column">
                                    <h3 class="fw-bolder mb-1">สื่อประกอบหลักสูตร</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-4">
                                <!-- <div class="overflow-auto pb-5"> -->
                                <div class="d-flex flex-row flex-wrap align-items-center">
                                    <?php while ($row_document = mysqli_fetch_array($rs_document)) {
                                        if ($row_document['doc_path'] != '') {
                                            if ($row_document['doc_type'] == '1') {
                                                $path = "../../template/assets/media/svg/files2/pdf.svg";
                                            } else if ($row_document['doc_type'] == '2') {
                                                $path = "../../template/assets/media/svg/files2/image.svg";
                                            } else if ($row_document['doc_type'] == '3') {
                                                $path = "../../template/assets/media/svg/files2/word.svg";
                                            } else if ($row_document['doc_type'] == '4') {
                                                $path = "../../template/assets/media/svg/files2/excel.svg";
                                            } else if ($row_document['doc_type'] == '5') {
                                                $path = "../../template/assets/media/svg/files2/power_point.svg";
                                            } else if ($row_document['doc_type'] == '6') {
                                                $path = "../../template/assets/media/svg/files2/link.svg";
                                            }
                                        } else {
                                            $path = "../../template/assets/media/svg/files/blank-image.svg";
                                        }

                                        $filename = "[" . $row['course_code'] . "]" . $row_document['doc_path'];
                                    ?>
                                        <a href="<?php echo ($row_document['doc_type'] == '6') ? $row_document['doc_path'] : '../../images/' . $row_document['doc_path'] ?>" download="<?= $filename ?>" target="_blank" class="d-flex flex-aligns-center border border-dashed border-gray-300 rounded p-3 mb-3 me-3">
                                            <img class="w-20px me-3" src="<?php echo $path ?>" alt="<?php echo $path ?>">
                                            <div class="ms-1 fw-bold">
                                                <div class="fs-6 text-hover-primary fw-bolder"><?php echo $row_document['doc_description'] ?></div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                                <!-- </div> -->
                            </div>
                        </div>

                        <div class="card card-flush mt-6 mt-xl-9">
                            <div class="card-header">
                                <div class="card-title flex-column">
                                    <h3 class="fw-bolder mb-1">คำอธิบายหลักสูตร</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="fs-6 text-gray-600 "><?php echo $row['short_description'] ?></div>
                            </div>
                        </div>

                        <div class="card card-flush mt-6 mt-xl-9">
                            <div class="card-header">
                                <div class="card-title flex-column">
                                    <h3 class="fw-bolder mb-1">ประวัติการทำข้อสอบ</h3>
                                    <!-- <div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div> -->
                                </div>
                                <!-- <div class="card-toolbar my-1">
                                    <div class="me-6 my-1">
                                        <select id="kt_filter_year" name="year" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm">
                                            <option value="All" selected="selected">All time</option>
                                            <option value="thisyear">This year</option>
                                            <option value="thismonth">This month</option>
                                            <option value="lastmonth">Last month</option>
                                            <option value="last90days">Last 90 days</option>
                                        </select>
                                    </div>
                                    <div class="me-4 my-1">
                                        <select id="kt_filter_orders" name="orders" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm">
                                            <option value="All" selected="selected">All Orders</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Declined">Declined</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="In Transit">In Transit</option>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" id="kt_filter_search" class="form-control form-control-solid form-select-sm w-150px ps-9" placeholder="Search Order" />
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="h-md-90px border border-info border-dashed rounded py-3 px-4 mb-3">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="fs-4 fw-bolder text-info" data-kt-countup="true" data-kt-countup-value="<?= $row_box1['high_score'] ?>" data-kt-countup-suffix=" คะแนน">0 </div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">คะแนนสูงสุดของพนักงานทั้งหมด</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="h-md-90px border border-info border-dashed rounded py-3 px-4 mb-3">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="fs-4 fw-bolder text-info" data-kt-countup="true" data-kt-countup-value="<?= $row_box2['box2'] ?>" data-kt-countup-suffix=" คน">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">พนักงานทั้งหมดที่อยู่ระหว่างอบรม</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="h-md-90px border border-info border-dashed rounded py-3 px-4 mb-3">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="fs-4 fw-bolder text-info" data-kt-countup="true" data-kt-countup-value="<?= $rs_box3->num_rows ?>" data-kt-countup-suffix=" คน">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">พนักงานทั้งหมดที่ผ่านการอบรม</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="h-md-90px border border-info border-dashed rounded py-3 px-4 mb-3">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="fs-4 fw-bolder text-info" data-kt-countup="true" data-kt-countup-value="<?= $row_box4['my_rank'] ?>" data-kt-countup-prefix="อันดับ ">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">ระดับคะแนนของฉัน</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="min-w-200px">รายการ</th>
                                                <th class="text-center min-w-150px">วัน/เวลาที่ทำ</th>
                                                <th class="text-center min-w-100px">คะแนน</th>
                                                <th class="text-center min-w-100px">เปอร์เซ็นต์</th>
                                            </tr>
                                        </thead>

                                        <tbody class="fs-6">
                                            <?php

                                            $sql_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND finish_datetime IS NOT NULL ORDER BY create_datetime ASC ";
                                            $rs_eh = mysqli_query($connection, $sql_eh) or die($connection->error);
                                            while ($row_eh = mysqli_fetch_array($rs_eh)) {

                                                $sql_ea = "SELECT * FROM tbl_exam_answer WHERE exam_head_id='{$row_eh['exam_head_id']}' ";
                                                $rs_ea  = mysqli_query($connection, $sql_ea) or die($connection->error);

                                                $list_exam = "";
                                                if ($row_eh['exam_count'] == 1) { //pre
                                                    $list_exam = 'ข้อสอบก่อนเรียน';
                                                } else {  //post
                                                    $list_exam = 'ข้อสอบหลังเรียนครั้งที่ ' . ($row_eh['exam_count'] - 1);
                                                }

                                                $pre_correct_amount = 0;
                                                $exam_count = "";

                                                if ($row_eh['exam_count'] > 1) { //ไม่นับข้อสอบพรี
                                                    $exam_count = $row_eh['exam_count'] - 1;
                                                    //ข้อสอบก่อนหน้า
                                                    $sql_pre_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND exam_count='$exam_count'";
                                                    $rs_pre_eh = mysqli_query($connection, $sql_pre_eh) or die($connection->error);
                                                    $row_pre_eh = mysqli_fetch_array($rs_pre_eh);

                                                    $pre_correct_amount = $row_pre_eh['correct_amount'];
                                                    $post_correct_amount = $row_eh['correct_amount'];
                                                    if ($pre_correct_amount == 0) { //ถ้าสอบครั้งก่อนได้ 0 
                                                        $sum =  $post_correct_amount * 100;
                                                    } else {
                                                        $sum = (($post_correct_amount - $pre_correct_amount) / $pre_correct_amount) * 100;
                                                    }
                                                }

                                                //เปอร์เซ็นต์ที่ทำได้ 
                                                $exam_percent = ($row_eh['correct_amount'] / $rs_ea->num_rows) * 100;
                                            ?>
                                                <tr id="eh_<?php echo $row_eh['exam_head_id'] ?>">
                                                    <td>
                                                        <?php echo $list_exam ?>
                                                    </td>
                                                    <td class="text-center"><?php echo date('d/m/Y', strtotime($row_eh['start_datetime'])) ?>
                                                        <br>
                                                        <?php echo date('H:i:s', strtotime($row_eh['start_datetime'])) ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $row_eh['correct_amount'] . '/' .  $rs_ea->num_rows ?>
                                                        <br /><?php echo '(' . number_format($exam_percent, 2) . '%)' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($row_eh['exam_count'] > 1) {
                                                            if ($post_correct_amount > $pre_correct_amount) { ?>
                                                                <span class="badge badge-success fs-base">
                                                                    <span class="svg-icon svg-icon-5 svg-icon-white ms-n1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                                                                            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <?php echo number_format($sum, 2) . ' %' ?>
                                                                </span>
                                                            <?php } else if ($post_correct_amount < $pre_correct_amount) {
                                                                // $sum = str_replace('-', ' ', $sum);
                                                            ?>
                                                                <span class="badge badge-danger fs-base">
                                                                    <span class="svg-icon svg-icon-5 svg-icon-white ms-n1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                                                                            <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <?php echo number_format($sum, 2) . ' %' ?>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-primary fs-base"> คงที่ </span>
                                                        <?php }
                                                        } ?>
                                                        <!-- <span class="badge badge-light-danger fw-bolder px-4 py-3">Rejected</span> -->
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-6 ms-lg-15">
                        <div class="card mb-6 ">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2 class="fw-bolder">เวลา</h2>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="d-flex flex-center text-center mb-2">
                                    <!-- <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                                    <div class="fs-2 fw-bolder text-gray-800" id="kt_coming_soon_counter_days"></div>
                                    <div class="fs-7 fw-bold text-muted">days</div>
                                </div> -->
                                    <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                                        <div class="fs-2 fw-bolder text-gray-800" id="hours"><?php echo $hours;  ?></div>
                                        <div class="fs-7 text-muted">ชม.</div>
                                    </div>
                                    <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                                        <div class="fs-2 fw-bolder text-gray-800" id="minutes"><?php echo $minutes; ?></div>
                                        <div class="fs-7 text-muted">นาที</div>
                                    </div>
                                    <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                                        <div class="fs-2 fw-bolder text-gray-800" id="seconds"><?php echo $seconds; ?></div>
                                        <div class="fs-7 text-muted">วินาที</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>

                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body pt-15">
                                <div class="d-flex flex-center flex-column mb-5">
                                    <div class="symbol symbol-150px symbol-circle mb-7">
                                        <img style="object-fit: cover;" src="../../images/<?php echo ($row['profile_image'] != '') ? $row['profile_image'] : 'blank.png' ?>" alt="image">
                                    </div>
                                    <div class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1"><?php echo $row['fullname'] ?></div>
                                    <!-- <a href="#" class="fs-5 fw-bold text-muted text-hover-primary mb-6"><?php echo $row['email'] ?></a> -->
                                </div>

                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bolder">รายละเอียด</div>
                                    <div class="badge badge-light-info d-inline">ผู้สอน</div>
                                </div>

                                <div class="separator separator-dashed my-3"></div>
                                <div class="fs-6">
                                    <div class="fw-bolder mt-5">ระดับการศึกษา</div>
                                    <div class="text-gray-600"><?php echo $row['education_level'] ?></div>

                                    <div class="fw-bolder mt-5">สาขาวิชา</div>
                                    <div class="text-gray-600"><?php echo $row['field'] ?></div>

                                    <div class="fw-bolder mt-5">ประสบการณ์</div>
                                    <div class="text-gray-600"><?php echo $row['experience'] ?></div>

                                    <div class="fw-bolder mt-5">ใบประกาศนียบัตร</div>
                                    <div class="text-gray-600"><?php echo $row['certificate'] ?></div>

                                    <div class="fw-bolder mt-5">ทักษะ/ความเชี่ยวชาญ</div>
                                    <div class="text-gray-600"><?php echo $row['skill'] ?></div>

                                </div>
                            </div>
                        </div>

                        <?php

                        $sql_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND exam_count !='1' ORDER BY create_datetime DESC LIMIT 1";
                        $rs_eh = mysqli_query($connection, $sql_eh) or die($connection->error);
                        $row_eh = mysqli_fetch_array($rs_eh);

                        $sql_chk_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' AND exam_count !='1'";
                        $rs_chk_eh = mysqli_query($connection, $sql_chk_eh) or die($connection->error);
                        $row_chk_eh = mysqli_fetch_array($rs_chk_eh);

                        //ตอนเข้าคอร์สครั้งแรกจะไม่เห็นปุ่มอะไรเลย
                        $sql_chk_pre = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id'";
                        $rs_chk_pre = mysqli_query($connection, $sql_chk_pre) or die($connection->error);
                        $row_chk_pre = mysqli_fetch_array($rs_chk_pre);

                        $now = date('Y-m-d');
                        ?>
                        <?php
                        if ($row['course_finish_date'] >= $now || $row['course_finish_date'] == '') {
                            if ($rs_chk_pre->num_rows > 0) {
                                if ($row_eh['pass_status'] == 0) { ?>
                                    <a href="exam.php?id=<?php echo $course_id ?>" class="btn btn-info btn-sm btn-hover-rise w-100">ทำข้อสอบ</a>
                                <?php
                                } else { ?>
                                    <?php if ($row['solve_type'] == 1) { ?>
                                        <a href="exam_answer.php?id=<?= $course_id ?>&id2=<?= $user_id ?>" class="btn btn-info btn-sm btn-hover-rise w-100 mb-5">เฉลย</a>
                                    <?php } ?>
                                    <?php if ($row['certificate_status'] == 1) { ?>
                                        <a href="../../print/certificate.php?id=<?= $course_id ?>&id2=<?= $user_id ?>&key=<?= rand(11111, 99999); ?>" target="_blank" class="btn btn-info btn-sm btn-hover-rise w-100">ใบประกาศ</a>
                                    <?php } ?>
                        <?php }
                            }
                        } ?>
                    </div>
                </div>

            </div>

        </div>
    </div>

<?php } else {
    session_destroy();
?>
    <script>
        alert("ไม่พบหลักสูตร");
        location.href = "../";
    </script>
<?php } ?>

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content rounded">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>


<script>
    $(document).ready(function() {
        CheckPreTest();
    });

    window.addEventListener('beforeunload', function(e) {
        UpdateTime();
    });

    var handler, timer,
        date = new Date(),
        h = date.setHours($('#hours').html()), // obtain these values somewhere else 
        m = date.setMinutes($('#minutes').html()),
        s = date.setSeconds($('#seconds').html());

    function CountTime() {
        let time = date.getTime();
        date.setTime(time + 1000);
        let formatDate = date.toTimeString().split(" ")[0];

        $('#hours').html(formatDate.split(":")[0]);
        $('#minutes').html(formatDate.split(":")[1]);
        $('#seconds').html(formatDate.split(":")[2]);
    }

    function StartCountTime() {
        clearInterval(handler);
        handler = setInterval(CountTime, 1000);
        timer = setInterval(UpdateTime, 60000);
    }

    function UpdateTime() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        let h = $('#hours').html();
        let m = $('#minutes').html();
        let s = $('#seconds').html();

        $.ajax({
            type: "post",
            url: "ajax/view_user_course/UpdateTime.php",
            data: {
                course_id: course_id,
                h: h,
                m: m,
                s: s
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 8) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบหลักสูตร',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "index_course.php";
                    }, 1500);
                } else if (response.result == 9) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                clearInterval(handler);
                clearInterval(timer);
                if (jqXHR.status == 500) {
                    alert('ข้อผิดพลาดภายใน : ' + jqXHR.responseText);
                } else {
                    alert('ข้อผิดพลาดที่ไม่คาดคิด');
                }
                setTimeout(() => {
                    location.href = "../";
                }, 1500);
            }
        }).fail(function() {
            clearInterval(handler);
            clearInterval(timer);
        });
    }

    function CheckPreTest() {
        //รับค่าจาก path link
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/view_user_course/CheckPreTest.php",
            data: {
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 1) { //ยังไม่มีการเริ่มทำข้อสอบ pre หรือ ยังทำข้อสอบ pre ไม่เสร็จ
                    Swal.fire({
                        title: 'กรุณาทำข้อสอบก่อนเรียน',
                        icon: "warning",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary btn-hover-scale",
                            cancelButton: 'btn btn-sm btn-light btn-hover-scale'
                        },
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "exam.php?id=" + course_id;
                        } else {
                            location.href = "index_course.php";
                        }
                    });
                } else if (response.result == 2) { //ทำข้อสอบหลังเรียนยังไม่ผ่าน
                    StartCountTime();
                } else if (response.result == 3) { // ทำข้อสอบหลังเรียนผ่านแล้ว
                    clearInterval(handler);
                    clearInterval(timer);
                } else if (response.result == 4) { //หลักสูตรเกินเวลาที่กำหนด
                    clearInterval(handler);
                    clearInterval(timer);
                } else if (response.result == 8) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบหลักสูตร',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "index_course.php";
                    }, 1500);
                } else if (response.result == 9) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                }
            }
        });
    }
</script>