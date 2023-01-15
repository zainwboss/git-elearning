<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$doc_id = getRandomID(10, "tbl_course_document", "doc_id");
$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
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
    <form id="form_add_doc" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="doc_id" name="doc_id" value="<?php echo $doc_id ?>" />
        <input type="hidden" class="form-control form-control-solid" id="doc_course_id" name="doc_course_id" value="<?php echo $course_id ?>" />
        <div class="mb-13 text-center">
            <h1 class="mb-3 mt-1">เพิ่มสื่อ</h1>
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ชื่อสื่อ <span class="required"></span></span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="doc_description" name="doc_description" />
        </div>

        <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ประเภทสื่อ <span class="required"></span></span>
            </label>
            <select class="form-select form-select-solid" id="doc_type" name="doc_type" onchange="ShowUpload(this.value)" data-control="select2" data-dropdown-parent="#modal" data-placeholder="กรุณาระบุประเภทสื่อ" data-hide-search="true">
                <option></option>
                <option value="1">PDF</option>
                <option value="2">IMG</option>
                <option value="3">WORD</option>
                <option value="4">EXCEL</option>
                <option value="5">PowerPoint</option>
                <option value="6">Link</option>
            </select>
        </div>
        <div class="d-flex flex-column mb-8 fv-row d-none" id="show_doc_path_link">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ข้อมูลสื่อ <span class="required"></span></span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" id="doc_path_link" name="doc_path_link" />
        </div>
        <div class="d-flex flex-column mb-8 fv-row d-none" id="show_doc_path_file">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">ข้อมูลสื่อ <span class="required"></span></span>
            </label>
            <input type="file" class="form-control" id="doc_path_file" name="doc_path_file" />
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_doc_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Add();">
                <span class="indicator-label ">บันทึก</span>
                <span class="indicator-progress">โปรดรอสักครู่...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>

    </form>
</div>
<script>
    var form, validate;
    form = document.querySelector("#form_add_doc");
    validate = FormValidation.formValidation(form, {
        fields: {
            doc_description: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุชื่อสื่อ"
                    }
                }
            },
            doc_type: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุประเภทสื่อ"
                    }
                }
            },
            doc_path_link: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุข้อมูลสื่อ',
                        callback: function(input) {
                            if ($('#doc_type').val() == '6') {
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
            doc_path_file: {
                validators: {
                    callback: {
                        message: 'กรุณาระบุข้อมูลสื่อ',
                        callback: function(input) {
                            if ($('#doc_type').val() != '6') {
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

    function ShowUpload(doc_type) {
        $("#doc_path_link").val('');
        $("#doc_path_file").val('');
        validate.resetForm();
        if (doc_type == '6') {
            document.getElementById("show_doc_path_link").classList.remove("d-none");
            document.getElementById("show_doc_path_file").classList.add("d-none");
        } else {
            document.getElementById("show_doc_path_link").classList.add("d-none");
            document.getElementById("show_doc_path_file").classList.remove("d-none");
        }
    }

    $("#doc_path_file").change(function() {
        let doc_type = $('#doc_type').val();
        validate.revalidateField('doc_path_file');
        if ($(this).val() != '') {
            if (doc_type == '1') {
                var fileExtension = ['pdf', 'PDF'];
            } else if (doc_type == '2') {
                var fileExtension = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
            } else if (doc_type == '3') {
                var fileExtension = ['doc', 'docx', 'DOC', 'DOCX'];
            } else if (doc_type == '4') {
                var fileExtension = ['xls', 'xlsx', 'XLS', 'XLSX'];
            } else if (doc_type == '5') {
                var fileExtension = ['ppt', 'pptx', 'PPT', 'PPTX'];
            }
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'อัปโหลดได้เฉพาะไฟล์ตามประเภทสื่อที่เลือก',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#doc_path_file").val('');
                return false;
            }
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
                            $("#modal_doc_submit").attr('data-kt-indicator', 'on');
                            $("#modal_doc_submit").attr('disabled', true);

                            let formData = new FormData($("#form_add_doc")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/view_course_document/Add.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_doc_submit").removeAttr('data-kt-indicator');
                                    $("#modal_doc_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        $('#modal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        GetTable();
                                        $("#list_file").load(window.location.href + " #list_file");

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