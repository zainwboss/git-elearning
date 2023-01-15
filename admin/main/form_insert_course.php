<?php
include('header.php');
$course_id = getRandomID(10, "tbl_course", "course_id");

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">หลักสูตร</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>

                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="index_course.php">รายการหลักสูตร</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">เพิ่มหลักสูตร</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="row g-7">
                <div class="col-xl-12">
                    <div class="card card-flush h-lg-100" id="kt_contacts_main">
                        <div class="card-header" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <span class="svg-icon svg-icon-info svg-icon-1 me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.9 10.7L7 5V19L16.9 13.3C17.9 12.7 17.9 11.3 16.9 10.7Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <h2>เพิ่มหลักสูตร</h2>
                            </div>
                        </div>
                        <div class="separator mb-6"></div>

                        <div class="card-body pt-5">
                            <form id="form_add_course" class="form" action="#">
                                <input type="hidden" class="form-control form-control-solid" id="course_id" name="course_id" value="<?php echo $course_id ?>" />

                                <div class="d-flex justify-content-center align-items-center mb-6 fv-row">
                                    <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url(../../template/assets/media/svg/files/blank-image.svg)">
                                        <div class="image-input-wrapper w-250px h-100px w-lg-350px h-lg-150px"></div>
                                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="main_image" id="main_image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="remove" />
                                        </label>

                                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!-- <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span> -->
                                    </div>
                                </div>

                                <div class="row" id="course_valid">
                                    <!-- แถว 1 -->
                                    <div class="col-sm-12 col-md-6 col-lg-8">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">ชื่อหลักสูตร <span class="required"></span></span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="course_name" name="course_name" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">รหัสหลักสูตร <span class="required"></span></span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="course_code" name="course_code" />
                                        </div>
                                    </div>

                                    <!-- แถว 2 -->
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">ผู้สอน <span class="required"></span></span>
                                            </label>
                                            <select class="form-select form-select-solid" id="teacher_id" name="teacher_id" data-control="select2" data-placeholder="กรุณาระบุผู้สอน" data-allow-clear="true">
                                                <option></option>
                                                <?php
                                                $sql_teacher = "SELECT teacher_id,fullname FROM tbl_teacher WHERE active_status='1' ORDER BY fullname ASC";
                                                $rs_teacher = mysqli_query($connection, $sql_teacher);
                                                while ($row_teacher = mysqli_fetch_assoc($rs_teacher)) {
                                                ?>
                                                    <option value="<?php echo $row_teacher['teacher_id'] ?>"><?php echo $row_teacher['fullname'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">เกณฑ์สอบผ่าน (%) <span class="required"></span></span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="pass_percent" name="pass_percent" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">ระยะเวลาทำข้อสอบ (นาที) <span class="required"></span></span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="exam_time" name="exam_time" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>การเฉลยข้อสอบ</span>
                                            </label>
                                            <select class="form-select form-select-solid" id="solve_type" name="solve_type" data-control="select2" data-placeholder="กรุณาเลือกการเฉลย" data-allow-clear="true">
                                                <option value="0" selected>ไม่เฉลย</option>
                                                <option value="1">เฉลย</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- แถว 3 -->
                                    <div class="col-sm-12 col-md-6 col-lg-6 fv-row mb-7">
                                        <div class="d-flex flex-wrap justify-content-between pt-5 pt-md-12">
                                            <label class="form-check form-check-inline form-check-solid mb-2">
                                                <input class="form-check-input" id="shuffle_choice" name="shuffle_choice" type="checkbox" value="1" />
                                                <span class="fw-bold ps-2 fs-6">สลับตัวเลือก</span>
                                            </label>
                                            <label class="form-check form-check-inline form-check-solid mb-2">
                                                <input class="form-check-input" id="shuffle_exam" name="shuffle_exam" type="checkbox" value="1" />
                                                <span class="fw-bold ps-2 fs-6">สลับข้อสอบ</span>
                                            </label>
                                            <label class="form-check form-check-inline form-check-solid me-20">
                                                <input class="form-check-input" id="random_exam" name="random_exam" type="checkbox" value="1" onclick="CheckRandom(this);" />
                                                <span class="fw-bold ps-2 fs-6">สุ่มข้อสอบ</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7 active_random_amount" hidden>
                                            <label class="fs-6 fw-bold form-label mt-2">
                                                <span class="required">จำนวนข้อ <span class="required"></span></span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="random_amount" name="random_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
                                        </div>
                                    </div>

                                    <!-- แถว 4 -->
                                    <div class="col-sm-12 col-md-6 col-lg-12">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>คำอธิบายหลักสูตร</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="short_description" name="short_description" />
                                        </div>
                                    </div>

                                    <!-- แถว 5 -->
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Vimeo</span>
                                            </label>
                                            <textarea class="form-control form-control-solid" style="height:314px;" id="vimeo_embed" name="vimeo_embed" onchange="$('#showVimeo').html(this.value);"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>ตัวอย่าง Vimeo</span>
                                            </label>
                                            <div id="showVimeo">
                                                <!-- <img class="mb-5 h-350px w-100" src="../../images/blank.png" alt="image" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- แถว 6 -->
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>การเข้าถึง </span>
                                            </label>
                                            <select class="form-select form-select-lg form-select-solid" id="course_group" name="course_group[]" data-control="select2" data-placeholder="กรุณาระบุการเข้าถึง" data-allow-clear="true" multiple="multiple">
                                                <option></option>
                                                <?php
                                                $sql_group = "SELECT * FROM tbl_group WHERE active_status ='1' ORDER BY group_name ASC";
                                                $rs_group  = mysqli_query($connection, $sql_group);
                                                while ($row_group  = mysqli_fetch_assoc($rs_group)) {
                                                ?>
                                                    <option value="<?php echo $row_group['group_id'] ?>"><?php echo $row_group['group_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">วันที่เริ่ม <span class="required"></span></span>
                                            </label>
                                            <input class="form-control flatpickr" placeholder="กรุณาระบุวันที่เริ่ม" id="course_start_date" name="course_start_date" />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>วันที่สิ้นสุด </span>
                                            </label>
                                            <input class="form-control flatpickr" placeholder="กรุณาระบุวันที่สิ้นสุด" id="course_finish_date" name="course_finish_date" />
                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end">
                                    <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light btn-hover-scale me-3">ยกเลิก</button>
                                    <button type="button" data-kt-contacts-type="submit" class="btn btn-primary btn-hover-scale" id="course_submit" onclick="Add();">
                                        <span class="indicator-label">บันทึก</span>
                                        <span class="indicator-progress">โปรดรอสักครู่...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script src="../../template/assets/js/StartEndDate.min.js"></script>
<script>
    $(document).ready(function() {
        $(".flatpickr").flatpickr({
            dateFormat: "d/m/Y",
        });
    });

    function CheckRandom(element) {
        if ($(element).is(':checked')) {
            $('.active_random_amount').prop('hidden', false);
            $('#shuffle_exam').prop('checked', true);
            $('#shuffle_exam').prop('disabled', true);
            $('#random_amount').val('');
        } else {
            $('.active_random_amount').prop('hidden', true);
            $('#shuffle_exam').prop('checked', false);
            $('#shuffle_exam').prop('disabled', false);
            $('#random_amount').val('');
        }
    }

    $("#question_image").change(function() {
        var fileExtension = ['jpg', 'jpeg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            Swal.fire({
                icon: 'warning',
                title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                showConfirmButton: false,
                timer: 1500
            });
            $("#img_question").attr('src', '../../images/blank.png');
            return false;
        }
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#img_question').attr('src', e.target.result);
        }
        reader.readAsDataURL($(this).get(0).files[0]);
    });

    var form, validate;
    form = document.querySelector("#course_valid");
    validate = FormValidation.formValidation(form, {
        fields: {
            course_name: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุชื่อหลักสูตร "
                    }
                }
            },
            course_code: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุรหัสหลักสูตร"
                    }
                }
            },
            teacher_id: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุผู้สอน"
                    }
                }
            },
            pass_percent: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุเกณฑ์สอบผ่าน"
                    }
                }
            },
            exam_time: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุระยะเวลาทำข้อสอบ"
                    }
                }
            },
            random_amount: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุจำนวนข้อ',
                        callback: function(input) {
                            if ($('#random_exam').is(':checked')) {
                                return input.value != '';
                            } else {
                                return {
                                    valid: true
                                }
                            }
                        }
                    }
                }
            },
            course_start_date: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุวันที่เริ่ม"
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger,
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: '',
                eleValidClass: ''
            }),
            startEndDate: new FormValidation.plugins.StartEndDate({
                format: 'DD/MM/YYYY',
                startDate: {
                    field: 'course_start_date',
                    message: 'วันที่เริ่มต้องน้อยกว่าหรือเท่ากับวันที่สิ้นสุด',
                },
                endDate: {
                    field: 'course_finish_date',
                    message: 'วันที่สิ้นสุดต้องมากกว่าหรือเท่ากับวันที่เริ่ม',
                },
            }),
        }
    });

    function Add() {
        if (validate) {
            validate.validate().then(function(status) {
                if (status == 'Valid') {
                    Swal.fire({
                        title: 'กรุณายืนยันการทำรายการ',
                        icon: "question",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary btn-hover-scale",
                            cancelButton: 'btn btn-sm btn-light btn-hover-scale'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading indication
                            $("#course_submit").attr('data-kt-indicator', 'on');
                            $("#course_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_course")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_course/AddCourse.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {

                                    $("#course_submit").removeAttr('data-kt-indicator');
                                    $("#course_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(() => {
                                            location.href = "view_course_overview.php?id=" + response.course_id;
                                        }, 1500);
                                    } else if (response.result == 0) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'บันทึกข้อมูลไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    } else if (response.result == 9) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(() => {
                                            location.href = "../";
                                        }, 2000);
                                    }
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    }
</script>