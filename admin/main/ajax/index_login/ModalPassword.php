<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    session_destroy();
    echo '<script>
			alert("เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง");
			location.href = "../";
		  </script>';
}

include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_assoc($rs);

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
    <form id="form_password" class="form" action="#" autocomplete="off">
        <div class="mb-13 mt-1 text-center">
            <h1 class="mb-3">ตั้งค่ารหัสผ่าน</h1>
            <!-- <div class="text-muted fw-bold fs-5">If you need more info, please check
                <a href="#" class="fw-bolder link-primary">Project Guidelines</a>.
            </div> -->
        </div>
        <input type="hidden" id="chk_password" name="chk_password" value="<?php echo $row['password'] ?>" />

        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                <label class="form-label fw-bold fs-6 mb-2 ">รหัสผ่านเดิม</label>
                <div class="position-relative mb-3">
                    <input type="password" class="form-control form-control-lg form-control-solid" id="current_password" name="current_password" autocomplete="off" placeholder="" />
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
                <label class="form-label fw-bold fs-6 mb-2 ">
                    รหัสผ่านใหม่
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="มีอักษรอย่างน้อย 8 ตัว , อักษรตัวพิมพ์ใหญ่ , ตัวพิมพ์เล็ก , ตัวเลข และ อักขระ"></i>
                </label>

                <div class="position-relative mb-3">
                    <input type="password" class="form-control form-control-lg form-control-solid" id="new_password" name="new_password" autocomplete="off" placeholder="" />
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
            <button type="button" id="modal_password_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Password();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</div>

<script>
    var form, validate;
    form = document.querySelector("#form_password");
    validate = FormValidation.formValidation(form, {
        fields: {
            'current_password': {
                validators: {
                    notEmpty: {
                        message: 'กรุณาระบุรหัสเดิม'
                    },
                    callback: {
                        message: 'รหัสผ่านเดิมไม่ถูกต้อง',
                        callback: function(input) {
                            if (input.value.length > 8 && input.value != '') {
                                let Fn = CheckPassword(input.value);
                                let current_password = Fn.responseJSON;
                                let password = form.querySelector('[name="chk_password"]').value;
                                return password == current_password;
                            } else {
                                return {
                                    valid: true
                                }
                            }
                        }
                    }
                }
            },
            'new_password': {
                validators: {
                    notEmpty: {
                        message: 'กรุณาระบุรหัสผ่านใหม่'
                    },
                    stringLength: {
                        min: 8,
                        message: 'มีอักษรอย่างน้อย 8 ตัว',
                    },
                    // regexp: {
                    //     regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/,
                    //     message: 'มีอักษรตัวพิมพ์ใหญ่ / ตัวพิมพ์เล็ก / ตัวเลข / อักขระ',
                    // },
                    regexp: {
                        regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+|~=`{}:";'<>?,./-])/, //[]\ ไม่ได้ 
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

    function CheckPassword(current_password) {
        return $.ajax({
            type: "POST",
            url: 'ajax/index_login/CheckPassword.php',
            data: {
                current_password: current_password
            },
            dataType: "json",
            async: false
        });
    }

    function Password() {
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

                            let formData = new FormData($("#form_password")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_login/Password.php",
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