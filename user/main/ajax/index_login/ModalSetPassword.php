<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

?>

<div class="modal-header border-0 ">
</div>
<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
    <form id="form_set_password" class="form" action="#" autocomplete="off">
        <div class="mb-13 mt-1 text-center">
            <h1 class="mb-3">ตั้งค่ารหัสผ่านครั้งแรก</h1>
        </div>

        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                <label class="form-label fw-bold fs-6 mb-2 ">
                    รหัสผ่านใหม่
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="มีอักษรอย่างน้อย 8 ตัว , อักษรตัวพิมพ์ใหญ่ , ตัวพิมพ์เล็ก , ตัวเลข และ อักขระ"></i>
                </label>

                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" type="password" id="new_password" name="new_password" autocomplete="off" placeholder="" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!-- ถ้าไม่เปืดไว้อันนึงไม้งั้นขึ้น error Uncaught TypeError: Cannot read properties of null (reading 'querySelectorAll') -->
                <!-- <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div> -->
            </div>
        </div>

        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                <label class="form-label fw-bold fs-6 mb-2 ">ยืนยันรหัสผ่านใหม่</label>
                <div class="position-relative mb-3">
                    <input type="password" class="form-control form-control-lg form-control-solid" id="confirm_password" name="confirm_password" autocomplete="off" placeholder="" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!-- ถ้าไม่เปืดไว้อันนึงไม้งั้นขึ้น error Uncaught TypeError: Cannot read properties of null (reading 'querySelectorAll') -->
                <!-- <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div> -->
            </div>
        </div>

        <div class="text-center">
            <button type="button" id="modal_password_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="SetPassword();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</div>

<script>
    var form, validate;
    form = document.querySelector("#form_set_password");
    validate = FormValidation.formValidation(form, {
        fields: {
            'new_password': {
                validators: {
                    notEmpty: {
                        message: 'กรุณาระบุรหัสผ่านใหม่'
                    },
                    stringLength: {
                        min: 8,
                        message: 'มีอักษรอย่างน้อย 8 ตัว',
                    },
                    regexp: {
                        regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+|~=`{}:";'<>?,./-])/, // []\ ไม่ได้
                        message: 'มีอักษรตัวพิมพ์ใหญ่ / ตัวพิมพ์เล็ก / ตัวเลข / อักขระ',
                    },
                }
            },
            'confirm_password': {
                validators: {
                    notEmpty: {
                        message: 'กรุณาระบุยืนยันรหัสผ่าน'
                    },
                    identical: {
                        compare: function() {
                            return form.querySelector('[name="new_password"]').value;
                        },
                        message: 'รหัสผ่านไม่ตรงกัน'
                    },
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

    function SetPassword() {
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
                            $("#modal_password_submit").attr('data-kt-indicator', 'on');
                            $("#modal_password_submit").attr('disabled', true);

                            let formData = new FormData($("#form_set_password")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_login/SetPassword.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_password_submit").removeAttr('data-kt-indicator');
                                    $("#modal_password_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        $('#modal_pro').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
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