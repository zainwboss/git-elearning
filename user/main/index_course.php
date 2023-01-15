<?php
include('header.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$condition = "";
// search
if (!empty($_GET['param'])) {
    $param = $_GET['param'];
    $condition = "AND course_name LIKE '%$param%'";
}

// checked
if (isset($_GET['param3'])) {
    $param3 = $_GET['param3'];
} else {
    $param3 = 1;
}
$now = date('Y-m-d');

// date
if (isset($_GET['param2']) &&  $param3 == '1') {
    $param2 = $_GET['param2'];
    $date = explode('-', $param2);
    $start = date('Y-m-d', strtotime(str_replace("/", "-", $date[0])));
    $end = date('Y-m-d', strtotime(str_replace("/", "-", $date[1])));
    $condition .= "AND 
            (CASE WHEN course_finish_date IS NOT NULL 
                THEN DATE(course_finish_date) >= '$now' AND DATE(course_start_date) <='$end' 
                ELSE DATE(course_start_date) <='$end'
             END)";
} else {
    $param2 = date('d/m/Y', strtotime('-1 month')) . ' - ' . date('d/m/Y');
    $start = date('Y-m-d', strtotime('-1 month'));
    $end = date('Y-m-d');
    if ($param3 == '1') {
        $condition .= "AND 
            (CASE WHEN course_finish_date IS NOT NULL 
                THEN DATE(course_finish_date) >= '$now' AND DATE(course_start_date) <='$end' 
                ELSE DATE(course_start_date) <='$end' 
            END)";
    }
}

// page
$perpage = 12;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perpage;

$sql = "SELECT * FROM tbl_course WHERE 
course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) $condition  
ORDER BY course_name ASC limit {$start} , {$perpage} ";
$rs  = mysqli_query($connection, $sql);

$sql2 = "SELECT a.* FROM tbl_course a WHERE active_status='1' AND
course_id IN(SELECT course_id FROM tbl_course_group WHERE group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) $condition";
$rs2 = mysqli_query($connection, $sql2);
$total_record = mysqli_num_rows($rs2);
$total_page = ceil($total_record / $perpage);
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">หลักสูตร</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>

                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-dark">รายการหลักสูตร</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12 mt-0">
                    <div class="d-flex flex-wrap flex-stack my-5">
                        <div class="d-flex flex-wrap my-1"></div>
                        <div class="d-flex flex-row flex-wrap align-items-center gap-4">

                            <div class="form-check form-switch form-check-custom form-check-solid form-check-purple">
                                <input class="form-check-input" type="checkbox" id="filter_status" name="filter_status" onchange="CheckedDate();" <?php if ($param3 == '1') {
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                    } ?> />
                                <label class="form-check-label fw-bolder text-dark fs-7" for="filter_status">
                                    เฉพาะช่วงเวลา
                                </label>
                            </div>

                            <div class="position-relative w-100 w-sm-350px">
                                <span class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                        <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <input style="border-color: #f5f8fa;" class="form-control form-control-sm fs-7 ps-12" placeholder="วันที่" id="filter_date" name="filter_date" value="<?= (!empty($param2)) ? $param2 : date('d/m/Y') . '-' . date('d/m/Y'); ?>" />
                            </div>

                            <div class="d-flex align-items-center w-100 w-sm-350px">
                                <div class="input-group">
                                    <input type="text" id="filter_search" name="filter_search" value="<?= $param ?>" class="form-control form-select-sm" style="border-color: #f5f8fa;" placeholder="ชื่อหลักสูตร">
                                </div>
                            </div>

                            <button type="button" class="btn btn-icon btn-warning btn-sm btn-hover-rise" onclick="Search();">
                                <span class="svg-icon svg-icon-white svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!--begin::Row-->
                    <div class="row g-5">
                        <!--begin::Col-->
                        <?php while ($row = mysqli_fetch_array($rs)) {
                            $length = strlen(utf8_decode($row['short_description']));
                            if ($length > 100) {
                                $short_description =  mb_substr($row['short_description'], 0, 100, "utf-8") . '...';
                            } else {
                                $short_description = $row['short_description'];
                            }
                        ?>
                            <div class="col-md-6 col-xl-3" id="card_<?php echo $row['course_id'] ?>">
                                <!--begin::Card-->
                                <div class="card card-md-stretch mb-md-5">
                                    <!-- <div class="card-header border-0 ">
                                        <div class="card-title m-0">
                                        </div>
                                        <div class="card-toolbar">
                                            <span class="badge badge-light-primary fw-bolder me-auto px-4 py-3">In Progress</span>
                                        </div>
                                    </div> -->

                                    <div class="card-body p-4">
                                        <a href="view_user_course.php?id=<?php echo $row['course_id'] ?>">
                                            <img style="height:265px" class="mb-5 w-100" src="../../images/<?php echo ($row['main_image'] != '') ?  $row['main_image'] : 'blank.png' ?>" alt="image" />
                                        </a>

                                        <a href="view_user_course.php?id=<?php echo $row['course_id'] ?>">
                                            <div class="fs-3 fw-bolder text-dark"><?php echo $row['course_name'] ?></div>
                                        </a>
                                        <p class="text-gray-400 fw-bold fs-5 my-1"><?php echo $short_description; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!--end::Row-->

                    <?php if ($rs->num_rows > 0) { ?>
                        <div class="d-flex flex-stack flex-wrap pt-10">
                            <div class="fs-6 fw-bold text-gray-700"></div>
                            <ul class="pagination">
                                <li class="page-item previous">
                                    <a href="index_course.php?page=1&param=<?= $param ?>&param2=<?= $param2 ?>&param3=<?= $param3 ?>" class="page-link">
                                        <i class="previous"></i>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : '' ?>">
                                        <a href="index_course.php?page=<?php echo $i; ?>&param=<?= $param ?>&param2=<?= $param2 ?>&param3=<?= $param3 ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>

                                <li class="page-item next">
                                    <a href="index_course.php?page=<?php echo $total_page; ?>&param=<?= $param ?>&param2=<?= $param2 ?>&param3=<?= $param3 ?>" class="page-link ">
                                        <i class="next"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content rounded">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

<script>
    $(document).ready(function() {
        CheckedDate();

        const filter_date = $('#filter_date').val();
        let startDate = filter_date.split('-')[0];
        let endDate = filter_date.split('-')[1];
        $("#filter_date").daterangepicker({
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });

    function CheckedDate() {
        $('#filter_status').is(':checked') ? $("#filter_date").prop('disabled', false) : $("#filter_date").prop('disabled', true);
    }

    function Search() {
        let param = $('#filter_search').val();
        let param2 = $('#filter_date').val();
        let param3 = $('#filter_status').is(':checked') ? 1 : 0;
        window.location = "index_course.php?page=1&param=" + param + "&param2=" + param2 + "&param3=" + param3;
    }
</script>