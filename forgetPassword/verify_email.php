<!DOCTYPE html>
<?php
include("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$status = mysqli_real_escape_string($connection, $_GET['status']);
$email = mysqli_real_escape_string($connection, $_GET['email']);
if ($status == '1') {
	$path = "../admin/index.php";
} else if ($status == '2') {
	$path = "../user/index.php";
}

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
	<title>Verify Email</title>
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

<body id="kt_body" class="auth-bg">
	<div class="d-flex flex-column flex-root">
		<div class="d-flex flex-column flex-column-fluid">
			<div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
				<div class="mb-10 pt-lg-10">
					<img alt="Logo" src="../images/<?= $row['logo_image'] ?>" class="h-90px h-lg-125px" />
				</div>
				<div class="pt-lg-10 mb-10">
					<h1 class="fw-bolder fs-2qx text-gray-800 mb-7">สำเร็จ !</h1>
					<div class="fs-3 fw-bold text-muted mb-10">เราได้ส่งอีเมลไปที่
						<span class="link-primary fw-bolder hoverable"><?= $email ?></span>
						<br />โปรดไปที่ลิงก์เพื่อยืนยันการเปลี่ยนรหัสผ่านของคุณ
					</div>
					<div class="text-center mb-10">
						<a href="<?= $path ?>" class="btn btn-lg btn-primary fw-bolder">เข้าสู่ระบบ</a>
					</div>
					<!-- <div class="fs-5">
						<span class="fw-bold text-gray-700">Did’t receive an email?</span>
						<a href="../../demo1/dist/authentication/sign-up/basic.html" class="link-primary fw-bolder">Resend</a>
					</div> -->
				</div>
				<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(../template/assets/media/illustrations/sketchy-1/17.png)"></div>
			</div>
		</div>
	</div>
	<script src="../template/assets/plugins/global/plugins.bundle.js"></script>
	<script src="../template/assets/js/scripts.bundle.js"></script>
</body>

</html>