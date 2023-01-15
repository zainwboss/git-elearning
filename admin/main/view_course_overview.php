<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id' ORDER BY course_name ASC ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

// พนักงานที่มีสิทธิ์อบรม
$sql1 = "SELECT COUNT(user_id) AS count_user FROM tbl_user WHERE active_status='1' 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))";
$rs1  = mysqli_query($connection, $sql1) or die($connection->error);
$row1 = mysqli_fetch_array($rs1);

// จำนวนวันที่ผ่านการอบรมเร็วที่สุด
$sql_fastest = "SELECT MIN(DATEDIFF(finish_datetime,register_datetime)) AS fastest_day FROM tbl_course_register 
        WHERE course_id ='$course_id' AND finish_datetime IS NOT NULL 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))";
$rs_fastest  = mysqli_query($connection, $sql_fastest) or die($connection->error);
$row_fastest = mysqli_fetch_array($rs_fastest);

// จำนวนวันที่ผ่านการอบรมช้าที่สุด
$sql_slowest = "SELECT MAX(DATEDIFF(finish_datetime,register_datetime)) AS slowest_day FROM tbl_course_register 
        WHERE course_id ='$course_id' AND finish_datetime IS NOT NULL 
        AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id'))";
$rs_slowest  = mysqli_query($connection, $sql_slowest) or die($connection->error);
$row_slowest = mysqli_fetch_array($rs_slowest);

// ค่าเฉลี่ยคะแนนสอบก่อนเรียน
$sql_pre = "SELECT IFNULL(MAX(correct_amount),0) AS max_pre,  IFNULL(MIN(correct_amount),0) AS min_pre , IFNULL(AVG(correct_amount),0) AS avg_pre FROM tbl_exam_head 
   WHERE exam_count='1' AND finish_datetime IS NOT NULL AND course_id='$course_id'";
$rs_pre   = mysqli_query($connection, $sql_pre) or die($connection->error);
$row_pre  = mysqli_fetch_array($rs_pre);

// ค่าเฉลี่ยคะแนนสอบหลังเรียน
$sql_post = "SELECT  IFNULL(MAX(correct_amount),0) AS max_post, IFNULL(MIN(correct_amount),0) AS min_post , IFNULL(AVG(correct_amount),0) AS avg_post FROM tbl_exam_head 
   WHERE exam_count !='1' AND finish_datetime IS NOT NULL AND course_id='$course_id'";
$rs_post   = mysqli_query($connection, $sql_post) or die($connection->error);
$row_post  = mysqli_fetch_array($rs_post);
// เปรียบเทียบคะแนนสอบก่อนเรียนและหลังเรียน
$sum_avg = 0;
$pre_correct_amount = $row_pre['avg_pre'];
$post_correct_amount = $row_post['avg_post'];
if ($pre_correct_amount == 0) { //ถ้าสอบครั้งก่อนได้ 0 
    $sum_avg =  $post_correct_amount * 100;
} else {
    $sum_avg = (($post_correct_amount - $pre_correct_amount) / $pre_correct_amount) * 100;
}

//คะแนนเฉลี่ย
$sum_avg2 = $row_post['avg_post'] - $row_pre['avg_pre'];
$diff_avg = "";
if ($row_post['avg_post'] == $row_pre['avg_pre']) {
    $diff_avg = 'หรือ คะแนนเฉลี่ยเท่าเดิม';
} else if ($row_post['avg_post'] > $row_pre['avg_pre']) {
    $diff_avg =  'หรือ คะแนนเฉลี่ยเพิ่มขึ้น ' . number_format($sum_avg2, 2) . ' คะแนน';
} else if ($row_post['avg_post'] < $row_pre['avg_pre']) {
    $diff_avg = 'หรือ คะแนนเฉลี่ยลดลง ' . number_format($sum_avg2, 2) . ' คะแนน';
}
?>

<style>
    @media (min-width:1400px) {
        .card.card-flush.bg-info.h-md-50.mb-5.mb-xl-10 {
            width: 100%;
            max-height: 30%;
        }

        .card.card-flush.h-md-50.mb-5.mb-xl-10 {
            width: 100%;
            max-height: 30%;
        }

        .card.card-flush.h-md-50.mb-xl-10 {
            width: 100%;
            max-height: 30%;
        }

        .g-xl-10,
        .gx-xl-10 {
            --bs-gutter-x: 1rem;
        }

        .col-md-12.col-xl-12.mb-5.mb-xl-10.bbb111 {
            margin-top: -30px;
        }

        .col-md-12.col-xl-12.mb-5.mb-xl-10.ccc111 {
            margin-top: -30px;
        }

        .mb-xl-10 {
            margin-bottom: 1.5rem !important;
        }

        .col-md-6.col-lg-6.col-xl-6.col-xxl-3.mb-md-5.mb-xl-10.poly111 {
            transform: translateY(-325px);
        }
    }
</style>

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
                <!-- tab -->
                <?php require('menu_view_course.php'); ?>
                <!-- end tap -->
                <div class="row g-5 g-xl-10 mb-xl-10">
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!-- กล่องที่1 -->
                        <div class="card card-flush bg-info h-md-50 mb-5 mb-xl-10">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center flex-stack">
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"></path>
                                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"></rect>
                                            <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"></path>
                                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <div class="text-white fw-bolder fs-2hx" data-kt-countup="true" data-kt-countup-value="<?= $row1['count_user'] ?>">0</div>
                                </div>
                                <div class="fw-bold text-white fs-4 mb-2">พนักงานที่มีสิทธิ์อบรม</div>
                                <?php
                                $sql_cg = "SELECT a.group_name,(SELECT COUNT(b.user_id) FROM tbl_user_group b WHERE b.group_id= a.group_id) AS count_user
                                           FROM tbl_group a WHERE a.group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id') ORDER BY a.group_name ASC";
                                $rs_cg  = mysqli_query($connection, $sql_cg) or die($connection->error);
                                while ($row_cg = mysqli_fetch_array($rs_cg)) { ?>
                                    <span class="text-white fw-bold d-block"><?= $row_cg['group_name'] . ' ' . $row_cg['count_user'] . ' คน' ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- กล่องที่3 -->
                        <div class="card card-flush h-md-50 mb-xl-10">
                            <div class="card-body pt-5">
                                <div class="d-flex flex-stack">
                                    <h4 class="fw-bolder text-gray-800 m-0">พนักงานที่ลงทะเบียนอบรมแล้ว</h4>
                                </div>
                                <div class="d-flex flex-center w-100">
                                    <div class="widget_chart" data-kt-chart-color="primary" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!-- กล่องที่2 -->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <div class="card-body pt-5">
                                <div class="d-flex flex-stack">
                                    <h4 class="fw-bolder text-gray-800 m-0"> พนักงานที่ยังไม่ได้ลงทะเบียนอบรม</h4>
                                </div>
                                <div class="d-flex flex-center w-100">
                                    <div class="widget_chart" data-kt-chart-color="danger" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                        <!-- กล่องที่4 -->
                        <div class="card card-flush h-md-50 mb-xl-10">
                            <div class="card-body pt-5">
                                <div class="d-flex flex-stack">
                                    <h4 class="fw-bolder text-gray-800 m-0"> พนักงานที่ผ่านการอบรมแล้ว</h4>
                                </div>

                                <div class="d-flex flex-center w-100">
                                    <div class="widget_chart" data-kt-chart-color="success" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
                        <div class="row g-lg-5 g-xl-10">
                            <div class="col-md-12 col-xl-12 mb-5 mb-xl-10">
                                <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                                    <div class="card-body my-3">
                                        <div class="card-title fw-bolder text-warning fs-5 mb-3 d-block">เปรียบเทียบคะแนนสอบก่อนเรียนและหลังเรียน</div>
                                        <div class="d-flex align-items-center me-2">
                                            <?php
                                            if ($post_correct_amount > $pre_correct_amount) { ?>
                                                <span class="svg-icon svg-icon-success svg-icon-3x">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            <?php } else if ($post_correct_amount < $pre_correct_amount) { ?>
                                                <span class="svg-icon svg-icon-danger svg-icon-3x">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            <?php } ?>
                                            <span class="text-dark fs-1 fw-bolder me-2"><?php echo number_format($sum_avg, 2) . ' %' ?></span>
                                        </div>
                                        <div class="fw-bold text-dark fs-5"><?= $diff_avg ?></div>
                                        <div class="progress h-7px bg-warning bg-opacity-50 mt-7">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo number_format($sum_avg, 2) . '%' ?>" aria-valuenow="<?= $sum_avg ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12 mb-5 mb-xl-10 bbb111">
                                <div class="card card-flush  mb-lg-10">
                                    <div class="card-body">
                                        <div class="d-flex flex-stack flex-wrap">
                                            <div class="d-flex flex-column my-2 me-5">
                                                <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2" data-kt-countup="true" data-kt-countup-decimal-places="2" data-kt-countup-value="<?= $row_pre['avg_pre'] ?>" data-kt-countup-suffix=" คะแนน">0</span>
                                                <span class="text-gray-400 pt-1 fw-bold fs-6"> ค่าเฉลี่ยคะแนนสอบก่อนเรียน</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex fs-6 fw-bold align-items-center">
                                                    <div class="bullet w-8px h-6px rounded-2 bg-success me-3"></div>
                                                    <div class="fs-6 fw-bold text-gray-400 flex-shrink-0">คะแนนก่อนเรียนต่ำสุด </div>
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
                                                    <div class="ms-auto fw-boldest text-gray-700 text-end" data-kt-countup="true" data-kt-countup-value="<?= $row_pre['min_pre'] ?>" data-kt-countup-suffix=" คะแนน">0</div>
                                                    <input type="hidden" name="min_pre" id="min_pre" value="<?= $row_pre['min_pre'] ?>">
                                                </div>

                                                <div class="d-flex fs-6 fw-bold align-items-center my-1">
                                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                                    <div class="fs-6 fw-bold text-gray-400 flex-shrink-0">คะแนนก่อนเรียนสูงสุด </div>
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
                                                    <div class="ms-auto fw-boldest text-gray-700 text-end" data-kt-countup="true" data-kt-countup-value="<?= $row_pre['max_pre'] ?>" data-kt-countup-suffix=" คะแนน">0</div>
                                                    <input type="hidden" name="min_pre" id="min_pre" value="<?= $row_pre['max_pre'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12 mb-5 mb-xl-10 ccc111">
                                <div class="card card-flush mb-lg-10">
                                    <div class="card-body">
                                        <div class="d-flex flex-stack flex-wrap">
                                            <div class="d-flex flex-column my-2 me-5">
                                                <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2" data-kt-countup="true" data-kt-countup-decimal-places="2" data-kt-countup-value="<?= $row_post['avg_post'] ?>" data-kt-countup-suffix=" คะแนน">0</span>
                                                <span class="text-gray-400 pt-1 fw-bold fs-6"> ค่าเฉลี่ยคะแนนสอบหลังเรียน</span>
                                            </div>
                                            <div class="d-flex flex-column ">
                                                <div class="d-flex fs-6 fw-bold align-items-center">
                                                    <div class="bullet w-8px h-6px rounded-2 bg-success me-3"></div>
                                                    <div class="fs-6 fw-bold text-gray-400 flex-shrink-0">คะแนนหลังเรียนต่ำสุด </div>
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
                                                    <div class="ms-auto fw-boldest text-gray-700 text-end" data-kt-countup="true" data-kt-countup-value="<?= $row_post['min_post'] ?>" data-kt-countup-suffix=" คะแนน">0</div>
                                                    <input type="hidden" name="min_post" id="min_post" value="<?= $row_post['min_post'] ?>">
                                                </div>

                                                <div class="d-flex fs-6 fw-bold align-items-center my-1">
                                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                                    <div class="fs-6 fw-bold text-gray-400 flex-shrink-0">คะแนนหลังเรียนสูงสุด </div>
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
                                                    <div class="ms-auto fw-boldest text-gray-700 text-end" data-kt-countup="true" data-kt-countup-value="<?= $row_post['max_post'] ?>" data-kt-countup-suffix=" คะแนน">0</div>
                                                    <input type="hidden" name="max_post" id="max_post" value="<?= $row_post['max_post'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10 poly111">
                        <div class="card card-flush bg-light">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center bg-white border-success border-dashed  rounded p-5 mb-7">
                                    <span class="svg-icon svg-icon-success svg-icon-1 me-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M17.8 8.79999L13 13.6L9.7 10.3C9.3 9.89999 8.7 9.89999 8.3 10.3L2.3 16.3C1.9 16.7 1.9 17.3 2.3 17.7C2.5 17.9 2.7 18 3 18C3.3 18 3.5 17.9 3.7 17.7L9 12.4L12.3 15.7C12.7 16.1 13.3 16.1 13.7 15.7L19.2 10.2L17.8 8.79999Z" fill="currentColor" />
                                            <path opacity="0.3" d="M22 13.1V7C22 6.4 21.6 6 21 6H14.9L22 13.1Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <div class="flex-grow-1 me-2">
                                        <div class="fw-bolder text-gray-800 text-hover-primary fs-6">จำนวนวันที่ผ่านการอบรมเร็วที่สุด</div>
                                    </div>
                                    <span class="fw-bolder fs-1 text-success py-1" data-kt-countup="true" data-kt-countup-value="<?= $row_fastest['fastest_day'] ?>">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10 poly111">
                        <div class="card card-flush bg-light">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center bg-white border-danger border-dashed rounded p-5 mb-7">
                                    <span class="svg-icon svg-icon-danger svg-icon-1 me-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M19.2 13.8L13.7 8.3C13.3 7.9 12.7 7.9 12.3 8.3L9 11.6L3.7 6.3C3.3 5.9 2.7 5.9 2.3 6.3C1.9 6.7 1.9 7.3 2.3 7.7L8.3 13.7C8.7 14.1 9.3 14.1 9.7 13.7L13 10.4L17.8 15.2L19.2 13.8Z" fill="currentColor" />
                                            <path opacity="0.3" d="M22 10.9V17C22 17.6 21.6 18 21 18H14.9L22 10.9Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <div class="flex-grow-1 me-2">
                                        <div class="fw-bolder text-gray-800 text-hover-primary fs-6">จำนวนวันที่ผ่านการอบรมช้าที่สุด</div>
                                    </div>
                                    <span class="fw-bolder fs-1 text-danger py-1" data-kt-countup="true" data-kt-countup-value="<?= $row_slowest['slowest_day'] ?>">0</span>
                                </div>
                            </div>
                        </div>
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
        WidgetChart();
    });

    function WidgetChart() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/view_course_overview/GetDataWidgetChart.php",
            dataType: "json",
            data: {
                course_id: course_id
            },
            success: function(response) {
                var data = JSON.parse(JSON.stringify(response));
                var e = document.querySelectorAll(".widget_chart");
                [].slice.call(e).map(function(e, i) {
                    var t = parseInt(KTUtil.css(e, "height"));
                    if (e) {
                        var a = e.getAttribute("data-kt-chart-color"),
                            o = {
                                labels: [data[i]['labels']],
                                series: [data[i]['series']],
                                chart: {
                                    fontFamily: "inherit",
                                    height: t,
                                    type: "radialBar",
                                    offsetY: 0,
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -90,
                                        endAngle: 90,
                                        hollow: { //ความกลวงของหลอด
                                            margin: 0,
                                            size: "55%"
                                        },
                                        dataLabels: {
                                            showOn: "always",
                                            name: { //คำอธิบายด้านล่าง
                                                show: !0,
                                                fontSize: "13px",
                                                fontWeight: "700",
                                                offsetY: -5,
                                                color: KTUtil.getCssVariableValue("--bs-gray-500"),
                                            },
                                            value: { //ค่าตัวเลขตรงกลาง
                                                color: KTUtil.getCssVariableValue("--bs-gray-900"),
                                                fontSize: "24px",
                                                fontWeight: "600",
                                                offsetY: -40,
                                                show: !0,
                                                formatter: function(e) {
                                                    return e.toFixed(2) + '%';
                                                },
                                            },
                                        },
                                        track: { //พื้นหลังหลอดเปอร์เซ้น
                                            background: KTUtil.getCssVariableValue("--bs-gray-300"),
                                            strokeWidth: "100%",
                                        },
                                    },
                                },
                                colors: [KTUtil.getCssVariableValue("--bs-" + a)],
                                stroke: {
                                    lineCap: "round"
                                },
                            };
                        new ApexCharts(e, o).render();
                    }
                });
            }
        });
    }
</script>