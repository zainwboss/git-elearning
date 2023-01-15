<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$teacher_id = getRandomID(10, "tbl_teacher", "teacher_id");
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
    <form id="form_add_teacher" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="teacher_id" name="teacher_id" value="<?php echo $teacher_id ?>" />
        <div class="mb-10 text-center">
            <h1 class="mb-3">เพิ่มผู้สอน</h1>
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
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                    <div class="symbol-label bg-light-primary">
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor" />
                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                    <div class="my-4">
                        <div class="text-primary fs-5 fw-bold mb-8">ข้อมูลส่วนตัว</div>
                    </div>
                    <div class="row gx-6 gy-md-2">
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
                                    <span class="required">อีเมล <span class="required"></span></span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="email" name="email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>เบอร์โทรศัพท์ </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="phone" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)responseve./g, '$1');" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>Facebook</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="facebook" name="facebook" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>Line </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="line" name="line" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>Linkedin </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="linkedin" name="linkedin" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>ที่อยู่ที่สามารถติดต่อได้ </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="address" name="address" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                    <div class="symbol-label bg-light-primary">
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor" />
                                <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                    <div class="my-4">
                        <div class="text-primary fs-5 fw-bold mb-8">สถานที่ทำงาน</div>
                    </div>
                    <div class="row gx-6 gy-md-2">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>บริษัท </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="company" name="company" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>แผนก </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="department" name="department" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>ตำแหน่ง </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="position" name="position" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>ที่อยู่บริษัท </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="company_address" name="company_address" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                    <div class="symbol-label bg-light-primary">
                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor" />
                                <path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                    <div class="my-4">
                        <div class="text-primary fs-5 fw-bold mb-8">การศึกษา</div>
                    </div>
                    <div class="row gx-6 gy-md-2">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">ระดับการศึกษา <span class="required"></span></span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="education_level" name="education_level" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">สาขาวิชา <span class="required"></span></span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="field" name="field" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>ประสบการณ์</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="experience" name="experience" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>ใบประกาศนียบัตร</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="certificate" name="certificate" />
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>ทักษะ/ความเชี่ยวชาญ </span>
                            </label>
                            <textarea class="ckeditor" id="skill" name="skill"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_teacher_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Add();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>

    </form>
</div>
<script>
    var form, validate;
    form = document.querySelector("#form_add_teacher");
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
            fullname: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุชื่อ-นามสกุล"
                    }
                }
            },
            education_level: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุระดับการศึกษา"
                    }
                }
            },
            field: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุสาขาวิชา"
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

                            $("#modal_teacher_submit").attr('data-kt-indicator', 'on');
                            $("#modal_teacher_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_teacher")[0]);

                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_teacher/Add.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_teacher_submit").removeAttr('data-kt-indicator');
                                    $("#modal_teacher_submit").attr('disabled', false);

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