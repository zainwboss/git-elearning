<!DOCTYPE html>
<?php
include("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$status = $_GET['status'];
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
    <title>Forgot Password</title>
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
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(../template/assets/media/illustrations/sketchy-1/14.png)">

            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="mb-12">
                    <img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-90px h-lg-125px" />
                </div>
                <div class="w-100 w-sm-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">ลืมรหัสผ่าน</h1>
                            <div class="text-gray-400 fw-bold fs-4">กรุณากรอกอีเมลเพื่อกำหนดรหัสผ่านใหม่</div>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fw-bolder text-gray-900 fs-6">อีเมล</label>
                            <input class="form-control form-control-solid" type="email" name="email" id="email" placeholder="" autocomplete="off" />
                        </div>
                        <div class="text-center mb-10">
                            <div class="g-recaptcha" data-type="image" data-sitekey="6LeP9SkjAAAAAJxEs6hXFZodmSomv8KRN5RJsxRA"></div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                            <button type="button" id="kt_password_reset_submit" class="btn btn-md btn-primary btn-hover-scale fw-bolder me-4" onclick="SendEmail();">
                                <span class="indicator-label">ยืนยัน</span>
                                <span class="indicator-progress">โปรดรอสักครู่...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <a href="index.php" class="btn btn-md btn-light btn-hover-scale fw-bolder">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="../template/assets/js/scripts.bundle.js"></script>

    <script>
        // function makeaction() {
        //     $("#kt_password_reset_submit").attr('disabled', false);
        // }

        var form, validate;
        form = document.querySelector("#kt_password_reset_form");
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

        function SendEmail() {
            grecaptcha.ready(function() {
                if (grecaptcha.getResponse() === "") {
                    Swal.fire({
                        title: 'แจ้งเตือน !',
                        text: "โปรดยืนยันตัวตน",
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    if (validate) {
                        validate.validate().then(function(status) {
                            if (status == 'Valid') {
                                $("#kt_password_reset_submit").attr('data-kt-indicator', 'on');
                                $("#kt_password_reset_submit").attr('disabled', true);

                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                var status = urlParams.get('status');

                                let email = $('#email').val();
                                $.ajax({
                                    type: 'POST',
                                    url: 'send_email.php',
                                    data: {
                                        email: email,
                                        status: status
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        $("#kt_password_reset_submit").removeAttr('data-kt-indicator');
                                        $("#kt_password_reset_submit").attr('disabled', false);

                                        if (data.result == 1) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'ระบบกำลังทำการส่งอีเมล...',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then((result) => {
                                                location.href = "verify_email.php?status=" + status + "&email=" + email;
                                            });
                                        } else if (data.result == 0) {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'แจ้งเตือน !',
                                                text: "ไม่พบอีเมลในระบบ",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                })
                            }
                        });
                    }
                }
            });

        }
    </script>
</body>

</html>