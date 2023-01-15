<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$cs_id = mysqli_real_escape_string($connection, $_POST['cs_id']);
$sql_c = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_c  = mysqli_query($connection, $sql_c) or die($connection->error);
$row_c = mysqli_fetch_array($rs_c);

$sql = "SELECT *FROM tbl_course_cer_setting WHERE cs_id='$cs_id' ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs_admin = mysqli_query($connection, $sql_admin);
$row_admin = mysqli_fetch_array($rs_admin);

?>


<div class="modal-header pb-0 border-0 justify-content-end">
    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
        <span class="svg-icon svg-icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
            </svg>
        </span>
    </div>
</div>
<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
    <form id="form_edit_certificate" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="cs_id" name="cs_id" value="<?php echo $cs_id ?>" />
        <input type="hidden" class="form-control form-control-solid" id="course_id" name="course_id" value="<?php echo $course_id ?>" />
        <div class="mb-13 text-center">
            <h1 class="mb-3">แก้ไขเนื้อหา</h1>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">เนื้อหา <span class="required"></span></span>
                    </label>
                    <select class="form-select form-select-solid" id="setting_type" name="setting_type" onchange="SettingType(this.value);" data-control="select2" data-dropdown-parent="#modal" data-placeholder="กรุณาระบุเนื้อหา" data-hide-search="true" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                                                                                } ?>>
                        <option></option>
                        <option value="1" <?php if ($row['setting_type'] == '1') {
                                                echo 'selected';
                                            } ?>>รูปภาพ</option>
                        <option value="2" <?php if ($row['setting_type'] == '2') {
                                                echo 'selected';
                                            } ?>>ข้อความ</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" id="setting_detail" <?php if ($row['setting_type'] == '') {
                                                    echo 'hidden';
                                                } ?>>
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">X <?php echo ($row_c['certificate_type'] == 1) ? '(0-297)' : '(0-210)'; ?><span class="required"></span></span>
                        <!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ตำแหน่ง"></i> -->
                    </label>
                    <input type="number" min="1" class="form-control form-control-solid" id="pointer_x" name="pointer_x" value="<?php echo $row['pointer_x'] ?>" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                    } ?> />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">Y <?php echo ($row_c['certificate_type'] == 1) ? '(0-210)' : '(0-297)'; ?><span class="required"></span></span>
                        <!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ตำแหน่ง"></i> -->
                    </label>
                    <input type="number" min="1" class="form-control form-control-solid" id="pointer_y" name="pointer_y" value="<?php echo $row['pointer_y'] ?>" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                    } ?> />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required width"><?php echo ($row['setting_type'] == 1) ? 'ความกว้าง' : 'ความกว้างของช่อง' ?> <span class="required"></span></span>
                    </label>
                    <input type="number" min="1" class="form-control form-control-solid" id="width" name="width" value="<?php echo $row['width'] ?>" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                            echo 'readonly';
                                                                                                                                                        } ?> />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required height"><?php echo ($row['setting_type'] == 1) ? 'ความสูง' : 'ระยะห่างระหว่างแถว' ?> <span class="required"></span></span>
                    </label>
                    <input type="number" min="1" class="form-control form-control-solid" id="height" name="height" value="<?php echo $row['height'] ?>" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                            echo 'readonly';
                                                                                                                                                        } ?> />
                </div>
            </div>
        </div>

        <div class="row" id="setting_image" <?php if ($row['setting_type'] == '2') {
                                                echo 'hidden';
                                            } ?>>
            <div class="col-sm-12">
                <?php if ($row_admin['admin_status'] != '2') { ?>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="required">รูปภาพ <span class="required"></span></span>
                        </label>
                        <input type="file" class="form-control" id="image_file" name="image_file" />
                    </div>
                <?php } ?>

            </div>
        </div>

        <div class="row" id="setting_text" <?php if ($row['setting_type'] == '1') {
                                                echo 'hidden';
                                            } ?>>
            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">การจัดหน้า <span class="required"></span></span>
                    </label>
                    <select class="form-select form-select-solid" id="text_position" name="text_position" data-control="select2" data-dropdown-parent="#modal" data-placeholder="กรุณาระบุตำแหน่ง" data-hide-search="true" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                            } ?>>
                        <option></option>
                        <option value="1" <?php if ($row['text_position'] == '1') {
                                                echo 'selected';
                                            } ?>>ซ้าย</option>
                        <option value="2" <?php if ($row['text_position'] == '2') {
                                                echo 'selected';
                                            } ?>>กลาง</option>
                        <option value="3" <?php if ($row['text_position'] == '3') {
                                                echo 'selected';
                                            } ?>>ขวา</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">ฟอนต์ <span class="required"></span></span>
                    </label>
                    <select class="form-select form-select-solid" id="text_font" name="text_font" data-control="select2" data-dropdown-parent="#modal" data-placeholder="กรุณาระบุฟอนต์" data-hide-search="true" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                                                                    } ?>>
                        <option></option>
                        <option value="1" <?php if ($row['text_font'] == '1') {
                                                echo 'selected';
                                            } ?>>THSarabunNew</option>
                        <option value="2" <?php if ($row['text_font'] == '2') {
                                                echo 'selected';
                                            } ?>>THSarabunNew Bold</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">ขนาดตัวอักษร <span class="required"></span></span>
                    </label>
                    <input type="number" min="1" class="form-control form-control-solid" placeholder="" id="text_size" name="text_size" value="<?php echo $row['text_size'] ?>" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                } ?> />
                </div>
            </div>

            <div class="d-flex align-items-start flex-row my-5">
                <?php if ($row_admin['admin_status'] != '2') { ?>
                    <button type="button" class="btn btn-light btn-sm btn-hover-rise me-5" id="add_course">
                        <span class="svg-icon svg-icon-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg>
                        </span>
                        ชื่อหลักสูตร
                    </button>
                    <button type="button" class="btn btn-light btn-sm btn-hover-rise me-5" id="add_name">
                        <span class="svg-icon svg-icon-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg>
                        </span>
                        ชื่อพนักงาน
                    </button>
                    <button type="button" class="btn btn-light btn-sm btn-hover-rise me-5" id="add_finish_datetime">
                        <span class="svg-icon svg-icon-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg>
                        </span>
                        วันที่สำเร็จการศึกษา
                    </button>
                <?php } ?>
            </div>

            <div class="d-flex flex-column mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">ข้อความ<span class="required"></span></span>
                </label>
                <textarea class="ckeditor" id="setting_text" name="setting_text"><?php echo $row['setting_text'] ?></textarea>
            </div>
        </div>

        <!--begin::Actions-->
        <div class="text-center">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <?php if ($row_admin['admin_status'] != '2') { ?>
                <button type="button" id="modal_certificate_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Edit();">
                    <span class="indicator-label ">บันทึก</span>
                    <span class="indicator-progress">โปรดรอสักครู่...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            <?php } ?>

        </div>
        <!--end::Actions-->
    </form>
</div>

<script>
    var form, validate;
    form = document.querySelector("#form_edit_certificate");
    validate = FormValidation.formValidation(form, {
        fields: {
            setting_type: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุเนื้อหา"
                    }
                }
            },
            pointer_x: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุ Y"
                    }
                }
            },
            pointer_y: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุ X"
                    }
                }
            },
            width: {
                validators: {
                    callback: {
                        callback: function(input) {
                            if ($('#setting_type').val() == '1') {
                                if (input.value == '') {
                                    return {
                                        valid: false,
                                        message: 'กรุณาระบุความกว้าง'
                                    }
                                }
                            } else if ($('#setting_type').val() == '2') {
                                if (input.value == '') {
                                    return {
                                        valid: false,
                                        message: 'กรุณาระบุความกว้างของช่อง'
                                    }
                                }
                            }
                            return {
                                valid: true
                            }
                        }
                    }
                }
            },
            height: {
                validators: {
                    callback: {
                        callback: function(input) {
                            if ($('#setting_type').val() == 1) {
                                if (input.value == '') {
                                    return {
                                        message: 'กรุณาระบุความสูง',
                                        valid: false
                                    }
                                }
                            } else if ($('#setting_type').val() == 2) {
                                if (input.value == '') {
                                    return {
                                        message: 'กรุณาระบุระยะห่างระหว่างแถว',
                                        valid: false
                                    }
                                }
                            }
                            return {
                                valid: true
                            }
                        }
                    }
                }
            },
            text_position: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุการจัดหน้า',
                        callback: function(input) {
                            if ($('#setting_type').val() == 2) {
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
            text_font: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุฟอนต์',
                        callback: function(input) {
                            if ($('#setting_type').val() == 2) {
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
            text_size: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุฟอนต์',
                        callback: function(input) {
                            if ($('#setting_type').val() == 2) {
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
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger,
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    });

    function SettingType(type) {
        validate.resetForm();
        if (type == '1') {
            $('#setting_detail').attr('hidden', false);
            $('.width').html('ความกว้าง<span class="required"></span>');
            $('.height').html('ความสูง<span class="required"></span>');

            $('#setting_image').attr('hidden', false);
            $('#setting_text').attr('hidden', true);
        } else if (type == '2') {
            $('#setting_detail').attr('hidden', false);
            $('.width').html('ความกว้างของช่อง<span class="required"></span>');
            $('.height').html('ระยะห่างระหว่างแถว<span class="required"></span>');

            $('#setting_image').attr('hidden', true);
            $('#setting_text').attr('hidden', false);
        } else {
            $('#setting_detail').attr('hidden', true);
            $('#setting_image').attr('hidden', true);
            $('#setting_text').attr('hidden', true);
        }
    }

    function Edit() {
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
                            $("#modal_certificate_submit").attr('data-kt-indicator', 'on');
                            $("#modal_certificate_submit").attr('disabled', true);

                            let formData = new FormData($("#form_edit_certificate")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/view_course_certificate/Edit.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_certificate_submit").removeAttr('data-kt-indicator');
                                    $("#modal_certificate_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        $('#modal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        GetTable();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'บันทึกข้อมูลไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
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