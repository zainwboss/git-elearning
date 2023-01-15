<!DOCTYPE html>
<?php
include("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$sql = "SELECT * FROM tbl_setting WHERE setting_id ='1'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);
$title = $row['title'];
if (strlen($title) < 2) {
    $title = "Title";
}

?>
<html lang="en">

<head>
    <title>Login Admin by <?= $title ?></title>
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
    <link rel="shortcut icon" href="../images/<?= $row['favicon'] ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="../template/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../template/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain " style="background-image: url(../template/image-phishing.png)">
            <div class="d-flex flex-lg-row-fluid">
                <!-- <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="../template/Albatrosses-logo.png" alt="" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="../template/assets/media/auth/agency-dark.png" alt="" />
                </div> -->
            </div>
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-100 w-sm-500px p-10">
                    <!--begin::Content-->
                    <div class="w-100 w-sm-400px">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                            <div class="text-center mb-8">
                                <img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-80px h-sm-90px" />
                            </div>
                            <div class="separator separator-content my-14">
                                <h2 class="w-425px w-sm-225px w-lg-250px text-dark fw-bolder mb-3">เข้าสู่ระบบผู้ดูแล</h2>
                            </div>

                            <!-- <div class="row g-3 mb-9">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="../template/assets/media/svg/brand-logos/google-icon.svg" class="h-15px me-3" />Sign in with Google</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="../template/assets/media/svg/brand-logos/apple-black.svg" class="theme-light-show h-15px me-3" />
                                        <img alt="Logo" src="../template/assets/media/svg/brand-logos/apple-black-dark.svg" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
                                </div>
                            </div>
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                            </div> -->

                            <div class="fv-row mb-5">
                                <label class="form-label fs-6 fw-bolder text-dark">อีเมล</label>
                                <input class="form-control form-control-lg form-control-solid" type="text" id="email" name="email" autocomplete="off" />
                            </div>

                            <div class="fv-row mb-5">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">รหัสผ่าน</label>
                                <input class="form-control form-control-lg form-control-solid" type="password" id="password" name="password" autocomplete="off" />
                            </div>

                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="../forgetPassword/forget_password.php?status=1" class="link-primary">ลืมรหัสผ่าน ?</a>
                            </div>
                            <div class="d-grid mb-10">
                                <button type="button" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" onclick="CheckLogin();">
                                    <span class="indicator-label">ยืนยัน</span>
                                    <span class="indicator-progress">โปรดรอสักครู่...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!-- 
                            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                                <a href="../template/../demo1/authentication/layouts/overlay/sign-up.html" class="link-primary">Sign up</a>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="../template/assets/js/scripts.bundle.js"></script>

    <!-- <script src="../template/assets/js/custom/authentication/sign-in/general.js"></script> -->

    <!--end::Javascript-->
    <script>
        $('#email').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                CheckLogin();
            }
        });
        $('#password').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                CheckLogin();
            }
        });

        var form, validate;
        form = document.querySelector("#kt_sign_in_form");
        validate = FormValidation.formValidation(form, {
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: "กรุณากรอกอีเมล"
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "กรุณากรอกรหัสผ่าน"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleValidClass: ''
                })
            }
        });

        function CheckLogin() {
            if (validate) {
                validate.validate().then(function(status) {
                    if (status == 'Valid') {
                        $("#kt_sign_in_submit").attr('data-kt-indicator', 'on');
                        $("#kt_sign_in_submit").attr('disabled', true);

                        let email = $('#email').val();
                        let password = $('#password').val();
                        $.ajax({
                            type: 'POST',
                            url: 'login.php',
                            data: {
                                email: email,
                                password: password
                            },
                            dataType: 'json',
                            success: function(data) {

                                if (data.result == 4) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'กำลังเข้าสู่ระบบ...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((result) => {
                                        // if (typeof(Storage) !== "undefined") {
                                        //     localStorage.setItem("admin_id", data.admin_id);
                                        //     location.href = "main/index.php";
                                        // }
                                        if (data.admin_status == 3) {
                                            location.href = "main/index_user.php";
                                        } else {
                                            location.href = "main/index.php";
                                        }
                                    });
                                }
                                if (data.result == 3) {
                                    Swal.fire({
                                        title: 'แจ้งเตือน !',
                                        text: "รหัสผ่านไม่ถูกต้อง",
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                                if (data.result == 2) {
                                    Swal.fire({
                                        title: 'แจ้งเตือน !',
                                        text: "ผู้ใช้งานนี้ ไม่ได้เปิดสถานะใช้งาน",
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                                if (data.result == 1) {
                                    Swal.fire({
                                        title: 'แจ้งเตือน !',
                                        text: "ไม่พบผู้ใช้งานในระบบ",
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                                if (data.result == 9) {
                                    Swal.fire({
                                        title: 'ผิดพลาด !',
                                        text: "ไม่สามารติดต่อฐานข้อมูลได้ โปรดติดต่อผู้ดูแลระบบ",
                                        icon: 'error',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                                $("#kt_sign_in_submit").removeAttr('data-kt-indicator');
                                $("#kt_sign_in_submit").attr('disabled', false);

                            }
                        })
                    }
                });
            }

        }
    </script>
</body>

</html>