<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$admin_id = getRandomID(10, "tbl_admin", "admin_id");
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
    <form id="form_add_admin" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="admin_id" name="admin_id" value="<?php echo $admin_id ?>" />
        <div class="mb-13 text-center">
            <h1 class="mb-3">เพิ่มผู้ดูแลระบบ</h1>
            <!-- <div class="text-muted fw-bold fs-5">If you need more info, please check
                <a href="#" class="fw-bolder link-primary">Project Guidelines</a>.
            </div> -->
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">อีเมล <span class="required"></span></span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ใช้สำหรับเข้าสู่ระบบ"></i>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="username" name="username" />
        </div>

        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">เบอร์โทรศัพท์ <span class="required"></span></span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ใช้สำหรับเป็นรหัสผ่าน"></i>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="phone" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
        </div>

        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ชื่อ-นามสกุล <span class="required"></span></span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="fullname" name="fullname" />
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">กำหนดสิทธิ์ <span class="required"></span></span>
            </label>
            <select class="form-select form-select-solid" id="admin_status" name="admin_status" data-control="select2" data-dropdown-parent="#modal" data-placeholder="กรุณากำหนดสิทธิ์" data-allow-clear="true">
                <option value="1">Admin</option>
                <option value="2">View</option>
                <option value="3">HR</option>
            </select>
        </div>

        <!--begin::Actions-->
        <div class="text-center">
            <button type="reset" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_admin_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Add();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <!--end::Actions-->
    </form>
</div>
<script>
    var form, validate;
    form = document.querySelector("#form_add_admin");
    validate = FormValidation.formValidation(form, {
        fields: {
            username: {
                validators: {
                    emailAddress: {
                        message: 'รูปแบบอีเมลไม่ถูกต้อง'
                    },
                    notEmpty: {
                        message: 'กรุณาระบุอีเมล'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุเบอร์โทรศัพท์"
                    }
                }
            },
            fullname: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุชื่อ-นามสกุล"
                    }
                }
            },
            admin_status: {
                validators: {
                    notEmpty: {
                        message: 'กรุณากำหนดสิทธิ์'
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
                            $("#modal_admin_submit").attr('data-kt-indicator', 'on');
                            $("#modal_admin_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_admin")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_admin/Add.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_admin_submit").removeAttr('data-kt-indicator');
                                    $("#modal_admin_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        $('#modal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        GetTable();

                                    } else if (response.result == 2) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'มีอีเมลนี้อยู่ในระบบแล้ว',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
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