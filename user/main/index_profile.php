<?php
include('header.php');

if (isset($_GET['param'])) { //มาจากการแจ้งเตือน
    $active = 1;
} else {
    $active = 0;
}

$user_id = $_GET['id'];
$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$rs = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($rs);

if ($rs->num_rows == 0) { //เช็คผู้ใช้งาน
    echo '<script>
            alert("ไม่พบพนักงาน");
            location.href = "../";
        </script>';
}

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">โปรไฟล์ของฉัน</h1>
                <!-- <span class="h-20px border-gray-300 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="index_course.php">รายการหลักสูตร</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">ภาพรวม</li>
                </ul> -->
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="d-flex flex-column flex-lg-row">
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-body">
                            <div class="d-flex flex-center flex-column py-5">
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <img style="object-fit: cover;" src="../../images/<?php echo ($row['profile_image'] != '') ? $row['profile_image'] : 'blank.png' ?>" alt="image" />
                                </div>
                                <div class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3"><?php echo $row_user['fullname'] ?></div>
                                <!-- <div class="mb-9">
                                    <div class="badge badge-lg badge-light-primary d-inline">Administrator</div>
                                </div> -->
                            </div>

                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">รายละเอียด
                                    <span class="ms-2 rotate-180">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="separator"></div>

                            <div id="kt_user_view_details" class="collapse show">
                                <div class="pb-5 fs-6">
                                    <div class="fw-bolder mt-5"> รหัสพนักงาน </div>
                                    <div class="text-gray-600"><?= $row['user_code'] ?></div>

                                    <div class="fw-bolder mt-5"> ตำแหน่ง</div>
                                    <div class="text-gray-600"><?= $row['position'] ?></div>

                                    <div class="fw-bolder mt-5"> แผนก</div>
                                    <div class="text-gray-600"><?= $row['department'] ?></div>

                                    <div class="fw-bolder mt-5"> อีเมล</div>
                                    <div class="text-gray-600"><?= $row['email'] ?></div>

                                    <div class="fw-bolder mt-5"> เบอร์โทรศัพท์</div>
                                    <div class="text-gray-600"><?= $row['phone'] ?></div>

                                    <div class="fw-bolder mt-5"> วันเกิด</div>
                                    <div class="text-gray-600"><?= date('d M Y', strtotime($row['birthdate'])) ?></div>

                                    <div class="fw-bolder mt-5 mb-3">กลุ่ม</div>
                                    <div class="d-flex flex-wrap ">
                                        <?php $sql_user_group = "SELECT * FROM tbl_user_group a
                                                             LEFT JOIN tbl_group b ON a.group_id=b.group_id
                                                             WHERE a.user_id ='$user_id' ORDER BY b.group_name ASC ";
                                        $rs_user_group  = mysqli_query($connection, $sql_user_group);
                                        while ($row_user_group = mysqli_fetch_array($rs_user_group)) {
                                        ?>
                                            <div class="border border-info bg-light-info border-dashed rounded py-1 px-3 mb-3 me-2">
                                                <div class="fs-6 fw-bold text-gray-700">
                                                    <span class="w-75px"><?php echo $row_user_group['group_name']; ?></span>
                                                </div>
                                                <!-- <div class="fw-bold text-muted">Total</div> -->
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer border-0 d-flex justify-content-center pt-0">
                            <button type="button" class="btn btn-sm btn-light-info w-100" onclick="ModalEditProfile()">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                แก้ไข
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                $now = date('Y-m-d');
                //tab1
                $sql_tab1 = "SELECT * FROM tbl_course  
                        WHERE active_status='1' 
                        AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
                        AND course_id IN (SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count ='1' AND finish_datetime IS NOT NULL)
                        AND course_id NOT IN(SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count !='1' AND pass_status ='1')
                        AND (('$now' BETWEEN course_start_date AND course_finish_date) OR ('$now' >= course_start_date AND course_finish_date IS NULL))
                        ORDER BY course_name ASC";
                $rs_tab1   = mysqli_query($connection, $sql_tab1);

                //tab2
                $sql_tab2  = "SELECT * FROM tbl_course a 
                WHERE active_status='1' 
                AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
                AND course_id NOT IN (SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count ='1' AND finish_datetime IS NOT NULL)
                AND (('$now' BETWEEN course_start_date AND course_finish_date) OR ('$now' >= course_start_date AND course_finish_date IS NULL))
                ORDER BY course_name ASC";
                $rs_tab2   = mysqli_query($connection, $sql_tab2);

                //tab3
                $sql_tab3 = "SELECT * FROM tbl_course  
                WHERE active_status='1' 
                AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
                AND course_id IN(SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count !='1' AND pass_status ='1')
                ORDER BY course_name ASC";
                $rs_tab3  = mysqli_query($connection, $sql_tab3);

                //tab4
                $sql_tab4 = "SELECT * FROM tbl_course 
                WHERE active_status='1'
                AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
                AND course_id NOT IN(SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count !='1' AND pass_status ='1')
                AND course_finish_date < '$now' 
                ORDER BY course_name ASC";
                $rs_tab4  = mysqli_query($connection, $sql_tab4);

                ?>
                <div class="flex-lg-row-fluid ms-lg-15">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 <?php echo ($active == 0) ? 'active' : '' ?>" data-bs-toggle="tab" href="#tab_course_1" onclick="GetTableTab1();">อยู่ระหว่างอบรม <span class="badge badge-circle badge-warning badge-sm" data-kt-countup="true" data-kt-countup-value="<?= $rs_tab1->num_rows ?>">0</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 <?php echo ($active == 1) ? 'active' : '' ?>" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#tab_course_2" onclick="GetTableTab2();">การอบรมใหม่ <span class="badge badge-circle badge-primary badge-sm" data-kt-countup="true" data-kt-countup-value="<?= $rs_tab2->num_rows ?>">0</span></a>
                            <span class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-primary badge-sm">5</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#tab_course_3" onclick="GetTableTab3();">ผ่านการอบรม <span class="badge badge-circle badge-success badge-sm" data-kt-countup="true" data-kt-countup-value="<?= $rs_tab3->num_rows ?>">0</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#tab_course_4" onclick="GetTableTab4();">หมดเวลา <span class="badge badge-circle badge-danger badge-sm" data-kt-countup="true" data-kt-countup-value="<?= $rs_tab4->num_rows ?>">0</span></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade <?php echo ($active == 0) ? 'show active' : '' ?>" id="tab_course_1" role="tabpanel">
                            <div id="show_tab_1"></div>
                        </div>

                        <div class="tab-pane fade <?php echo ($active == 1) ? 'show active' : '' ?>" id="tab_course_2" role="tabpanel">
                            <div id="show_tab_2"></div>
                        </div>

                        <div class="tab-pane fade" id="tab_course_3" role="tabpanel">
                            <div id="show_tab_3"></div>
                        </div>

                        <div class="tab-pane fade" id="tab_course_4" role="tabpanel">
                            <div id="show_tab_4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        GetTableTab1();
        GetTableTab2();
    });

    function ModalEditProfile() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var user_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_profile/ModalEditProfile.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
                KTImageInput.createInstances();
                $("#birthdate").flatpickr({
                    dateFormat: "d/m/Y",
                });
            }
        });
    }

    function GetTableTab1() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var user_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_profile/GetTableTab1.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_tab_1").html(response);
            }
        });
    }

    function GetTableTab2() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var user_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_profile/GetTableTab2.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_tab_2").html(response);
            }
        });
    }

    function GetTableTab3() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var user_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_profile/GetTableTab3.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_tab_3").html(response);
            }
        });
    }

    function GetTableTab4() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var user_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_profile/GetTableTab4.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_tab_4").html(response);
            }
        });
    }
</script>