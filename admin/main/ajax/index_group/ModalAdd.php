<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

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
    <form id="form_add_group" class="form" action="#">
        <div class="mb-13 text-center">
            <h1 class="mb-3">เพิ่มกลุ่ม</h1>
            <!-- <div class="text-muted fw-bold fs-5">If you need more info, please check
                <a href="#" class="fw-bolder link-primary">Project Guidelines</a>.
            </div> -->
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ชื่อกลุ่ม <span class="required"></span></span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="group_name" name="group_name" />
        </div>

        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">สีกลุ่ม <span class="required"></span></span>
            </label>
            <input type="color" class="form-control h-35px" placeholder="" id="group_color" name="group_color" />
        </div>

        <!--begin::Actions-->
        <div class="text-center">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_group_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Add();">
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
    form = document.querySelector("#form_add_group");
    validate = FormValidation.formValidation(form, {
        fields: {
            group_name: {
                validators: {
                    notEmpty: {
                        message: 'กรุณาระบุชื่อกลุ่ม'
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
                            $("#modal_group_submit").attr('data-kt-indicator', 'on');
                            $("#modal_group_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_group")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_group/Add.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_group_submit").removeAttr('data-kt-indicator');
                                    $("#modal_group_submit").attr('disabled', false);

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