<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
?>

<div class="modal-header">
    <h1 class="modal-title">นำเข้าข้อสอบ</h1>
    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
        <span class="svg-icon svg-icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
            </svg>
        </span>
    </div>
</div>
<div class="modal-body px-10 px-lg-15 ">
    <form id="form_import_exam" class="form" action="#">
        <input type="hidden" name="import_course_id" id="import_course_id" value="<?= $course_id ?>">
        <div class="d-flex mb-8 ">
            <a class="btn btn-sm btn-light-warning btn-hover-rise" href="ajax/view_course_exam/ExportExam.php?id=<?php echo $course_id ?>">
                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                        <path opacity="0.3" d="M13 14.4V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V14.4H13Z" fill="currentColor" />
                        <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM13 14.4V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V14.4H8L11.3 17.7C11.7 18.1 12.3 18.1 12.7 17.7L16 14.4H13Z" fill="currentColor" />
                    </svg></span>
                ดาวน์โหลดแบบฟอร์ม
            </a>
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
            <input type="file" class="form-control" id="file_excel" name="file_excel" />
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
    <button type="button" id="import_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="ImportExam();">
        <span class="indicator-label ">นำเข้า</span>
        <span class="indicator-progress">โปรดรอสักครู่...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
</div>

<script>
    var form, validate;
    form = document.querySelector("#form_import_exam");
    validate = FormValidation.formValidation(form, {
        fields: {
            file_excel: {
                validators: {
                    notEmpty: {
                        message: "กรุณาอัปไฟล์นำเข้า"
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

    function ImportExam() {
        if (validate) {
            validate.validate().then(function(status) {
                if (status == 'Valid') {
                    Swal.fire({
                        title: 'กรุณายืนยันการอัปโหลด',
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

                            let formData = new FormData($("#form_import_exam")[0]);
                           
                            $("#import_submit").attr('data-kt-indicator', 'on');
                            $("#import_submit").attr('disabled', true);

                            $.ajax({
                                type: 'POST',
                                url: 'ajax/view_course_exam/ImportExam.php',
                                data: formData,
                                dataType: 'json',
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $("#import_submit").removeAttr('data-kt-indicator');
                                    $("#import_submit").attr('disabled', false);

                                    if (data.result == 1) {
                                        $('#modal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'นำเข้าข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        location.reload()
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'นำเข้าข้อมูลไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            })
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