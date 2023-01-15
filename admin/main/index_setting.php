<?php
include('header.php');

$sql = "SELECT * FROM tbl_setting WHERE setting_id ='1'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">ตั้งค่า</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>

                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-dark">ตั้งค่าเว็บไซต์</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-flex align-items-center">
                        <h3 class="fw-bolder m-0 text-gray-800"></h3>
                    </div>
                    <div class="card-toolbar m-0">
                        <button type="button" id="setting_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="submit();">
                            <span class="indicator-label ">บันทึก</span>
                            <span class="indicator-progress">โปรดรอสักครู่...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
                <form id="form_setting" class="form" action="#">
                    <div class="card-body">

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label bg-light-info">
                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                                    <div class="my-3">
                                        <div class="text-info fs-5 fw-bold mb-8">โลโก้
                                            <i class="fas fa-exclamation-circle ms-2 fs-7 text-danger" data-bs-toggle="tooltip" title="(ขนาดรูปภาพ 1000 mm x 405 mm)"></i>
                                        </div>
                                    </div>
                                    <div class="row gx-6 gy-md-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <input type="file" class="form-control" id="logo_image" name="logo_image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label bg-light-info">
                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M12.6 7C12 7 11.6 6.6 11.6 6V3C11.6 2.4 12 2 12.6 2C13.2 2 13.6 2.4 13.6 3V6C13.6 6.6 13.2 7 12.6 7ZM10 7.59998C10.5 7.29998 10.6 6.69995 10.4 6.19995L9 3.80005C8.7 3.30005 8.10001 3.20002 7.60001 3.40002C7.10001 3.70002 7.00001 4.30005 7.20001 4.80005L8.60001 7.19995C8.80001 7.49995 9.1 7.69995 9.5 7.69995C9.7 7.69995 9.9 7.69998 10 7.59998ZM8 9.30005C8.3 8.80005 8.10001 8.20002 7.60001 7.90002L5.5 6.69995C5 6.39995 4.40001 6.59998 4.10001 7.09998C3.80001 7.59998 4 8.2 4.5 8.5L6.60001 9.69995C6.80001 9.79995 6.90001 9.80005 7.10001 9.80005C7.50001 9.80005 7.9 9.70005 8 9.30005ZM7.20001 12C7.20001 11.4 6.80001 11 6.20001 11H4C3.4 11 3 11.4 3 12C3 12.6 3.4 13 4 13H6.20001C6.70001 13 7.20001 12.6 7.20001 12Z" fill="currentColor" />
                                                <path opacity="0.3" d="M17.4 5.5C17.4 6.1 17 6.5 16.4 6.5C15.8 6.5 15.4 6.1 15.4 5.5C15.4 4.9 15.8 4.5 16.4 4.5C17 4.5 17.4 5 17.4 5.5ZM5.80001 17.1L7.40001 16.1C7.90001 15.8 8.00001 15.2 7.80001 14.7C7.50001 14.2 6.90001 14.1 6.40001 14.3L4.80001 15.3C4.30001 15.6 4.20001 16.2 4.40001 16.7C4.60001 17 4.90001 17.2 5.30001 17.2C5.50001 17.3 5.60001 17.2 5.80001 17.1ZM8.40001 20.2C8.20001 20.2 8.10001 20.2 7.90001 20.1C7.40001 19.8 7.3 19.2 7.5 18.7L8.30001 17.3C8.60001 16.8 9.20002 16.7 9.70002 16.9C10.2 17.2 10.3 17.8 10.1 18.3L9.30001 19.7C9.10001 20 8.70001 20.2 8.40001 20.2ZM12.6 21.2C12 21.2 11.6 20.8 11.6 20.2V18.8C11.6 18.2 12 17.8 12.6 17.8C13.2 17.8 13.6 18.2 13.6 18.8V20.2C13.6 20.7 13.2 21.2 12.6 21.2ZM16.7 19.9C16.4 19.9 16 19.7 15.8 19.4L15.2 18.5C14.9 18 15.1 17.4 15.6 17.1C16.1 16.8 16.7 17 17 17.5L17.6 18.4C17.9 18.9 17.7 19.5 17.2 19.8C17 19.9 16.8 19.9 16.7 19.9ZM19.4 17C19.2 17 19.1 17 18.9 16.9L18.2 16.5C17.7 16.2 17.6 15.6 17.8 15.1C18.1 14.6 18.7 14.5 19.2 14.7L19.9 15.1C20.4 15.4 20.5 16 20.3 16.5C20.1 16.8 19.8 17 19.4 17ZM20.4 13H19.9C19.3 13 18.9 12.6 18.9 12C18.9 11.4 19.3 11 19.9 11H20.4C21 11 21.4 11.4 21.4 12C21.4 12.6 20.9 13 20.4 13ZM18.9 9.30005C18.6 9.30005 18.2 9.10005 18 8.80005C17.7 8.30005 17.9 7.70002 18.4 7.40002L18.6 7.30005C19.1 7.00005 19.7 7.19995 20 7.69995C20.3 8.19995 20.1 8.79998 19.6 9.09998L19.4 9.19995C19.3 9.19995 19.1 9.30005 18.9 9.30005Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                                    <div class="my-3">
                                        <div class="text-info fs-5 fw-bold mb-8">โหลด
                                            <i class="fas fa-exclamation-circle ms-2 fs-7 text-danger" data-bs-toggle="tooltip" title="(ขนาดรูปภาพ 324 mm x 200 mm)"></i>
                                        </div>
                                    </div>
                                    <div class="row gx-6 gy-md-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <input type="file" class="form-control" id="loading_image" name="loading_image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label bg-light-info">
                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                                    <div class="my-3">
                                        <div class="text-info fs-5 fw-bold mb-8">ไอคอนเว็บไซต์
                                            <i class="fas fa-exclamation-circle ms-2 fs-7 text-danger" data-bs-toggle="tooltip" title="(นามสกุลไฟล์ .ico เท่านั้น)"></i>
                                        </div>
                                    </div>
                                    <div class="row gx-6 gy-md-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <input type="file" class="form-control" id="favicon" name="favicon" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                    <div class="symbol-label bg-light-info">
                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M16.95 18.9688C16.75 18.9688 16.55 18.8688 16.35 18.7688C15.85 18.4688 15.75 17.8688 16.05 17.3688L19.65 11.9688L16.05 6.56876C15.75 6.06876 15.85 5.46873 16.35 5.16873C16.85 4.86873 17.45 4.96878 17.75 5.46878L21.75 11.4688C21.95 11.7688 21.95 12.2688 21.75 12.5688L17.75 18.5688C17.55 18.7688 17.25 18.9688 16.95 18.9688ZM7.55001 18.7688C8.05001 18.4688 8.15 17.8688 7.85 17.3688L4.25001 11.9688L7.85 6.56876C8.15 6.06876 8.05001 5.46873 7.55001 5.16873C7.05001 4.86873 6.45 4.96878 6.15 5.46878L2.15 11.4688C1.95 11.7688 1.95 12.2688 2.15 12.5688L6.15 18.5688C6.35 18.8688 6.65 18.9688 6.95 18.9688C7.15 18.9688 7.35001 18.8688 7.55001 18.7688Z" fill="currentColor" />
                                                <path opacity="0.3" d="M10.45 18.9687C10.35 18.9687 10.25 18.9687 10.25 18.9687C9.75 18.8687 9.35 18.2688 9.55 17.7688L12.55 5.76878C12.65 5.26878 13.25 4.8687 13.75 5.0687C14.25 5.1687 14.65 5.76878 14.45 6.26878L11.45 18.2688C11.35 18.6688 10.85 18.9687 10.45 18.9687Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="timeline-content mb-10 mt-n1" style="overflow: hidden">
                                    <div class="my-3">
                                        <div class="text-info fs-5 fw-bold mb-8">ไตเติ้ล</div>
                                    </div>
                                    <div class="row gx-6 gy-md-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <input type="text" class="form-control form-control-solid" placeholder="" id="title" name="title" value="<?php echo $row['title'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content rounded">
            <div id="show_modal"></div>
        </div>
    </div>
</div> -->

<?php include('footer.php') ?>

<script>
    $(document).ready(function() {});

    $("#logo_image").change(function() {
        if ($(this).val() != '') {
            var fileExtension = ['jpg', 'jpeg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#logo_image").val('');
                return false;
            }
        }
    });

    $("#loading_image").change(function() {
        if ($(this).val() != '') {
            var fileExtension = ['svg'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'อัปโหลดได้เฉพาะไฟล์ SVG เท่านั้น',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#loading_image").val('');
                return false;
            }
        }
    });

    $("#favicon").change(function() {
        if ($(this).val() != '') {
            var fileExtension = ['ico'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'อัปโหลดได้เฉพาะไฟล์ ICO เท่านั้น',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#favicon").val('');
                return false;
            }
        }
    });

    var form, validate;
    form = document.querySelector("#form_setting");
    validate = FormValidation.formValidation(form, {
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: "กรุณาระบุไตเติ้ล"
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

    function submit() {
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

                            $("#setting_submit").attr('data-kt-indicator', 'on');
                            $("#setting_submit").attr('disabled', true);

                            let formData = new FormData($("#form_setting")[0]);

                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/index_setting/UpdateSetting.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#setting_submit").removeAttr('data-kt-indicator');
                                    $("#setting_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(() => {
                                            location.href = "index_setting.php";
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