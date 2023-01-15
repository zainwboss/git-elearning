<!DOCTYPE html>
<?php
include("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$status = mysqli_real_escape_string($connection, $_GET['status']);
$serial_id = mysqli_real_escape_string($connection, $_GET['id']);

$sql_serial = "SELECT * FROM tbl_forget_password WHERE serial_id = '$serial_id'";
$rs_serial = mysqli_query($connection, $sql_serial) or die($connection->error);
$row_serial = mysqli_fetch_array($rs_serial);

$datenow = date('Y-m-d H:i:s');
$expire_datetime = date('Y-m-d H:i:s', strtotime($row_serial['expire_datetime']));

$sql = "SELECT * FROM tbl_setting WHERE setting_id ='1'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);
// $title = $row['title'];
// if (strlen($title) < 2) {
//     $title = "Title";
// }
?>
<html lang="en">

<head>
    <title>New Password</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/html" />
    <!-- <link rel="shortcut icon" href="../template/assets/media/logos/favicon.ico" /> -->
    <link rel="shortcut icon" href="../images/<?= $row['favicon'] ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="../template/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../template/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body id="kt_body" class="bg-body">
    <?php if ($datenow <= $expire_datetime) {
    ?>
        <?php if ($row_serial['used_datetime'] == "") { ?>
            <div class="d-flex flex-column flex-root">
                <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(../template/assets/media/illustrations/sketchy-1/14.png)">
                    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                        <div class="mb-12">
                            <img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-90px h-lg-125px" />
                        </div>
                        <div class="w-lg-550px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                            <form id="form_new_password" class="form w-100" action="#" autocomplete="off">
                                <div class="text-center mb-10">
                                    <h1 class="text-dark mb-3">ตั้งค่ารหัสผ่านใหม่</h1>
                                    <div class="text-gray-400 fw-bold fs-4">รีเซ็ตรหัสผ่านของคุณแล้วหรือยัง ?
                                        <a href="../<?= ($status == '1') ? 'admin' : 'user' ?>/index.php" class="link-primary fw-bolder">เข้าสู่ระบบ</a>
                                    </div>
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
                                        <!-- ต้องเปืดไว้อันนึงไม้งั้นขึ้น error Uncaught TypeError: Cannot read properties of null (reading 'querySelectorAll') -->
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
                                        <!-- ต้องเปืดไว้อันนึงไม้งั้นขึ้น error Uncaught TypeError: Cannot read properties of null (reading 'querySelectorAll') -->
                                        <!-- <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
								</div> -->
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" id="new_password_submit" class="btn btn-sm btn-primary btn-hover-scale" onclick="SetPassword();">
                                        <span class="indicator-label ">บันทึก</span>
                                        <span class="indicator-progress">โปรดรอสักครู่...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        <?php } else { //ลิงค์ใช้งานแล้ว 
        ?>
            <div class="d-flex flex-column flex-root">
                <div class="d-flex flex-column flex-column-fluid">
                    <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
                        <div class="mb-10 pt-lg-10">
                            <img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-90px h-lg-125px" />
                        </div>
                        <div class="pt-lg-10 mb-10">
                            <h1 class="fw-bolder fs-2qx text-danger mb-7">ลิงก์นี้ถูกใช้งานแล้ว !</h1>
                            <div class="fs-3 fw-bold text-muted mb-10">
                                กรุณาดำเนินการใหม่อีกครั้งหรือติดต่อผู้เกี่ยวข้อง
                            </div>
                            <div class="text-center mb-5">
                                <a href="<?= ($status == '1') ? '../admin/index.php' : '../user/index.php' ?>" class="btn btn-lg btn-primary fw-bolder">เข้าสู่ระบบ</a>
                            </div>
                        </div>
                        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(../template/assets/media/illustrations/sketchy-1/17.png)"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { //ลิงค์หมดอายุแล้ว 
    ?>
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-column flex-column-fluid">
                <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
                    <div class="mb-10 pt-lg-10">
                        <img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-90px h-lg-125px" />
                    </div>
                    <div class="pt-lg-10 mb-10">
                        <h1 class="fw-bolder fs-2qx text-danger mb-7">ลิงก์หมดอายุ !</h1>
                        <div class="fs-3 fw-bold text-muted mb-10">
                            กรุณาดำเนินการใหม่อีกครั้งหรือติดต่อผู้เกี่ยวข้อง
                        </div>
                        <div class="text-center mb-5">
                            <a href="<?= ($status == '1') ? '../admin/index.php' : '../user/index.php' ?>" class="btn btn-lg btn-primary fw-bolder">เข้าสู่ระบบ</a>
                        </div>
                    </div>
                    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(../template/assets/media/illustrations/sketchy-1/17.png)"></div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script src="../template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="../template/assets/js/scripts.bundle.js"></script>

    <script>
        var form, validate;
        form = document.querySelector("#form_new_password");
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

                                $("#new_password_submit").attr('data-kt-indicator', 'on');
                                $("#new_password_submit").attr('disabled', true);

                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const serial_id = urlParams.get('id');
                                const status = urlParams.get('status');
                                let formData = new FormData($("#form_new_password")[0]);
                                formData.append('serial_id', serial_id);
                                formData.append('status', status);

                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: "set_password.php",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        $("#new_password_submit").removeAttr(
                                            'data-kt-indicator');
                                        $("#new_password_submit").attr('disabled', false);

                                        if (response.result == 1) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            setTimeout(() => {
                                                (status == '1') ? location.href = "../admin/index.php": location.href = "../user/index.php"
                                            }, 2000);
                                        } else if (response.result == 0) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'บันทึกข้อมูลไม่สำเร็จ',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        } else if (response.result == 2) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'ลิงก์หมดอายุ กรุณาดำเนินการใหม่อีกครั้งหรือติดต่อผู้เกี่ยวข้อง',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            setTimeout(() => {
                                                (status == '1') ? location.href = "../admin/index.php": location.href = "../user/index.php"
                                            }, 2000);
                                        } else if (response.result == 9) {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'ไม่พบผู้ใช้งานในระบบ',
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
</body>

</html>