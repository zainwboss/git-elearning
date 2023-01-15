<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = getRandomID(10, "tbl_user", "user_id");
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
    <form id="form_add_user" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="user_id" name="user_id" value="<?php echo $user_id ?>" />
        <div class="mb-10 text-center">
            <h1 class="mb-3">เพิ่มพนักงาน</h1>
        </div>

        <div class="d-flex justify-content-center align-items-center mb-15 fv-row">
            <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url(../../template/assets/media/svg/avatars/blank.svg)">

                <div class="image-input-wrapper w-125px h-125px"></div>

                <label class="btn btn-icon btn-circle btn-color-muted  btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <input type="file" name="profile_image" id="profile_image" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="remove" />
                </label>

                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel">
                    <i class="bi bi-x fs-2"></i>
                </span>

                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove">
                    <i class="bi bi-x fs-2"></i>
                </span>
            </div>
        </div>

        <div class="row gx-7 gy-2">
            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">อีเมล <span class="required"></span></span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ใช้สำหรับเข้าสู่ระบบ"></i>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="email" name="email" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">เบอร์โทรศัพท์ <span class="required"></span></span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="ใช้สำหรับเป็นรหัสผ่าน"></i>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="phone" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="">รหัสพนักงาน </span>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="user_code" name="user_code" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">ชื่อ-นามสกุล <span class="required"></span></span>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="fullname" name="fullname" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="">แผนก </span>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="department" name="department" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="">ตำแหน่ง </span>
                    </label>
                    <input type="text" class="form-control form-control-solid" placeholder="" id="position" name="position" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column mb-5 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="">วันเกิด </span>
                    </label>
                    <input class="form-control" placeholder="กรุณาระบุวันเกิด" id="birthdate" name="birthdate" />
                </div>
            </div>

            <div class="d-flex flex-column mb-5 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span>การเข้าถึง</span>
                </label>
                <select class="form-select form-select-lg form-select-solid" id="user_group" name="user_group[]" data-control="select2" data-placeholder="กรุณาระบุการเข้าถึง" data-allow-clear="true" multiple="multiple">
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

        <div class="text-center">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_user_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Add();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>

    </form>
</div>
<script>
    var form, validate;
    form = document.querySelector("#form_add_user");
    validate = FormValidation.formValidation(form, {
        fields: {
            email: {
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

                            $("#modal_user_submit").attr('data-kt-indicator', 'on');
                            $("#modal_user_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_user")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_user/Add.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_user_submit").removeAttr('data-kt-indicator');
                                    $("#modal_user_submit").attr('disabled', false);

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