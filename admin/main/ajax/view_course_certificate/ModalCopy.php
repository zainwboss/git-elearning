<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

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
    <form id="form_copy_certificate" class="form" action="#">
        <input type="hidden" class="form-control form-control-solid" id="course_id" name="course_id" value="<?php echo $course_id ?>" />
        <div class="mb-13 text-center">
            <h1 class="mb-3">คัดลอกใบประกาศ</h1>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span class="required">จากหลักสูตร <span class="required"></span></span>
                    </label>
                    <select class="form-select form-select-solid" id="copy_course_id" name="copy_course_id" data-control="select2" data-dropdown-parent="#modal_copy" data-placeholder="กรุณาระบุหลักสูตร" data-allow-clear="true">
                        <option></option>
                        <?php
                        $sql = "SELECT * FROM tbl_course WHERE active_status='1' AND course_id !='$course_id' ORDER BY course_name ASC";
                        $rs = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($rs)) {
                        ?>
                            <option value="<?php echo $row['course_id'] ?>"><?php echo $row['course_name'] . ' [' . $row['course_code'] . ']' ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <!--begin::Actions-->
        <div class="text-center mt-5">
            <button type="button" class="btn btn-sm btn-light btn-hover-scale me-3" data-bs-dismiss="modal">ปิด</button>
            <button type="button" id="modal_certificate_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="Copy();">
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
    form = document.querySelector("#form_copy_certificate");
    validate = FormValidation.formValidation(form, {
        fields: {
            copy_course_id: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุหลักสูตร"
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

    function Copy() {
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

                            let formData = new FormData($("#form_copy_certificate")[0]);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/view_course_certificate/Copy.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#modal_certificate_submit").removeAttr('data-kt-indicator');
                                    $("#modal_certificate_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        $('#modal_copy').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        location.reload();
                                    } else if (response.result == 8) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'ไม่พบหลักสูตร',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(() => {
                                            location.href = "index_course.php";
                                        }, 1500);
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