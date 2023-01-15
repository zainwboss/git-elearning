<?php
session_start();
if (empty($_SESSION['admin_id'])) {
	session_destroy();
	echo '<script>
			alert("เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง");
			location.href = "../";
		  </script>';
}

include("../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$pagename = basename($_SERVER['PHP_SELF']);

$sql_setting = "SELECT * FROM tbl_setting WHERE setting_id ='1'";
$rs_setting  = mysqli_query($connection, $sql_setting) or die($connection->error);
$row_setting = mysqli_fetch_array($rs_setting);
$title = $row_setting['title'];
if (strlen($title) < 2) {
	$title = "Title";
}

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs_admin = mysqli_query($connection, $sql_admin);
$row_admin = mysqli_fetch_array($rs_admin);

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<title><?= $title ?></title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="../../images/<?= $row_setting['favicon'] ?>" />
	<!--begin::Page Vendor Stylesheets(used by this page)-->
	<link href="../../template/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Page Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="../../template/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../../template/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
	<!--begin::Main-->
	<!--begin::Root-->

	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid">
			<!--begin::Aside-->
			<div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
				<!--begin::Brand-->
				<div class="aside-logo flex-column-auto" id="kt_aside_logo">
					<!--begin::Logo-->
					<a href="index.php">
						<img alt="Logo" src="../../images/<?php echo $row_setting['logo_image'] ?>" class="h-70px logo mt-1" />
					</a>
					<!--end::Logo-->
					<!--begin::Aside toggler-->
					<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-info aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
						<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
						<span class="svg-icon svg-icon-1 rotate-180" style="color:#c0a4f7">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
								<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
							</svg>
						</span>
						<!--end::Svg Icon-->
					</div>
					<!--end::Aside toggler-->
				</div>
				<!--end::Brand-->
				<!--begin::Aside menu-->
				<div class="aside-menu flex-column-fluid">
					<!--begin::Aside Menu-->
					<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
						<!--begin::Menu-->
						<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
							<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<span class="menu-link">
									<span class="menu-icon" style="color:#c0a4f7">
										<span class="svg-icon svg-icon-2" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
												<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
												<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
												<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
											</svg>
										</span>
									</span>
									<span class="menu-title">Dashboard</span>
									<span class="menu-arrow"></span>
								</span>
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/index.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Multipurpose</span>
										</a>
									</div>

									<div class="menu-inner flex-column collapse" id="kt_aside_menu_collapse">
										<div class="menu-item">
											<a class="menu-link" href="../../demo1/dist/dashboards/logistics.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Logistics</span>
											</a>
										</div>
									</div>
									<div class="menu-item">
										<div class="menu-content">
											<a class="btn btn-flex btn-color-success fs-base p-0 ms-2 mb-2 collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_aside_menu_collapse" data-kt-toggle-text="Show Less">
												<span data-kt-toggle-text-target="true">Show 10 More</span>
												<span class="svg-icon ms-2 svg-icon-3 rotate-180">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.5" d="M12.5657 9.63427L16.75 5.44995C17.1642 5.03574 17.8358 5.03574 18.25 5.44995C18.6642 5.86416 18.6642 6.53574 18.25 6.94995L12.7071 12.4928C12.3166 12.8834 11.6834 12.8834 11.2929 12.4928L5.75 6.94995C5.33579 6.53574 5.33579 5.86416 5.75 5.44995C6.16421 5.03574 6.83579 5.03574 7.25 5.44995L11.4343 9.63427C11.7467 9.94669 12.2533 9.94668 12.5657 9.63427Z" fill="currentColor" />
														<path d="M12.5657 15.6343L16.75 11.45C17.1642 11.0357 17.8358 11.0357 18.25 11.45C18.6642 11.8642 18.6642 12.5357 18.25 12.95L12.7071 18.4928C12.3166 18.8834 11.6834 18.8834 11.2929 18.4928L5.75 12.95C5.33579 12.5357 5.33579 11.8642 5.75 11.45C6.16421 11.0357 6.83579 11.0357 7.25 11.45L11.4343 15.6343C11.7467 15.9467 12.2533 15.9467 12.5657 15.6343Z" fill="currentColor" />
													</svg>
												</span>
											</a>
										</div>
									</div>
								</div>
							</div> -->
							<div class="menu-item">
								<div class="menu-content">
									<span class="menu-section text-muted text-uppercase fs-5 ls-1">เมนู</span>
								</div>
							</div>
							<?php if ($row_admin['admin_status'] != '3') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index.php') {
															echo 'active';
														} ?>" href="index.php" title="ภาพรวม" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="currentColor" />
												<path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">ภาพรวม</span>
									</a>
								</div>

								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_report.php') {
															echo 'active';
														} ?>" href="index_report.php" title="รายงานสรุปผล" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
												<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
												<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
												<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
												<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">รายงานสรุปผล</span>
									</a>
								</div>
							<?php } ?>
							<?php if ($row_admin['admin_status'] == '0') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_admin.php') {
															echo 'active';
														} ?>" href="index_admin.php" title="รายการผู้ดูแลระบบ" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22  12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="currentColor" />
												<path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999  21 9.4 22 12 22Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">ผู้ดูแลระบบ</span>
									</a>
								</div>
							<?php } ?>
							<?php if ($row_admin['admin_status'] != '3') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_course.php' || $pagename == 'view_course_overview.php' || $pagename == 'view_course_member.php' || $pagename == 'view_course_exam.php' || $pagename == 'view_course_document.php' || $pagename == 'view_course_certificate.php' || $pagename == 'view_course_report.php' || $pagename == 'form_edit_course.php') {
															echo 'active';
														} ?>" href="index_course.php" title="รายการหลักสูตร" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M16.9 10.7L7 5V19L16.9 13.3C17.9 12.7 17.9 11.3 16.9 10.7Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">หลักสูตร</span>
									</a>
								</div>
							<?php } ?>

							<?php if ($row_admin['admin_status'] != '3') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_group.php') {
															echo 'active';
														} ?>" href="index_group.php" title="รายการกลุ่ม" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="7" y="2" width="14" height="16" rx="3" fill="currentColor" />
												<rect x="3" y="6" width="14" height="16" rx="3" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">กลุ่ม</span>
									</a>
								</div>
							<?php } ?>

							<div class="menu-item">
								<a class="menu-link <?php if ($pagename == 'index_user.php') {
														echo 'active';
													} ?>" href="index_user.php" title="รายการพนักงาน" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
									<span class="menu-icon" style="color:#c0a4f7">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor" />
											<rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor" />
											<path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor" />
											<rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor" />
										</svg>
									</span>
									<span class="menu-title">พนักงาน</span>
								</a>
							</div>

							<?php if ($row_admin['admin_status'] != '3') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_teacher.php') {
															echo 'active';
														} ?>" href="index_teacher.php" title="รายการผู้สอน" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor" />
												<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">ผู้สอน</span>
									</a>
								</div>
							<?php } ?>

							<?php if ($row_admin['admin_status'] == '0' || $row_admin['admin_status'] == '1') { ?>
								<div class="menu-item">
									<a class="menu-link <?php if ($pagename == 'index_setting.php') {
															echo 'active';
														} ?>" href="index_setting.php" title="ตั้งค่าเว็บไซต์" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										<span class="menu-icon" style="color:#c0a4f7">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor" />
												<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor" />
											</svg>
										</span>
										<span class="menu-title">ตั้งค่า</span>
									</a>
								</div>
							<?php } ?>
							<!-- เมนูล่างหลักสูตร -->
							<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<span class="menu-link">
									<span class="menu-icon">
										<span class="svg-icon svg-icon-2">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z" fill="currentColor" />
												<path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="currentColor" />
												<path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z" fill="currentColor" />
											</svg>
										</span>
									</span>
									<span class="menu-title">Pages</span>
									<span class="menu-arrow"></span>
								</span>
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">User Profile</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="index_setting.php">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Overview</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="index_setting.php">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Projects</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/user-profile/campaigns.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Campaigns</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/user-profile/documents.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Documents</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/user-profile/followers.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Followers</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/user-profile/activity.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Activity</span>
												</a>
											</div>
										</div>
									</div>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Blog</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/blog/home.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Blog Home</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/blog/post.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Blog Post</span>
												</a>
											</div>
										</div>
									</div>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Pricing</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/pricing/pricing-1.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Pricing 1</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/pricing/pricing-2.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Pricing 2</span>
												</a>
											</div>
										</div>
									</div>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Careers</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/careers/list.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Careers List</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/careers/apply.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Careers Apply</span>
												</a>
											</div>
										</div>
									</div>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">FAQ</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/faq/classic.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Classic</span>
												</a>
											</div>
											<div class="menu-item">
												<a class="menu-link" href="../../demo1/dist/pages/faq/extended.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Extended</span>
												</a>
											</div>
										</div>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/pages/about.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">About Us</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/pages/contact.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Contact Us</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/pages/team.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Our Team</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/pages/licenses.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Licenses</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="../../demo1/dist/pages/sitemap.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sitemap</span>
										</a>
									</div>
								</div>
							</div> -->

							<!-- เส้น hr -->
							<div class="menu-item">
								<div class="menu-content">
									<div class="separator mx-1 my-4"></div>
								</div>
							</div>
						</div>
						<!--end::Menu-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside menu-->

			</div>
			<!--end::Aside-->

			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				<div id="kt_header" class="header align-items-stretch">
					<!--begin::Container-->
					<div class="container-fluid d-flex align-items-stretch justify-content-between">
						<!--begin::Aside mobile toggle-->
						<div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
							<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
								<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
								<span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
										<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
						</div>
						<!--end::Aside mobile toggle-->

						<!--begin::Mobile logo-->
						<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
							<a href="index.php" class="d-lg-none">
								<img alt="Logo" src="../../images/<?php echo $row_setting['logo_image'] ?>" class="h-40px" />
							</a>
						</div>
						<!--end::Mobile logo-->

						<!--begin::Wrapper-->
						<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">

							<!--begin::Navbar-->
							<div class="d-flex align-items-stretch" id="kt_header_nav">
								<!--begin::Menu wrapper-->
								<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
									<!--begin::Menu-->
									<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">

									</div>
									<!--end::Menu-->
								</div>
								<!--end::Menu wrapper-->
							</div>
							<!--end::Navbar-->

							<!--begin::Toolbar wrapper-->
							<div class="d-flex align-items-stretch flex-shrink-0">
								<!--เมนู admin -->
								<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
									<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<img style="object-fit:cover;" src="../../images/<?php echo ($row_admin['profile_image'] != '') ? $row_admin['profile_image'] : 'blank.png' ?>" alt="user" />
									</div>
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-2 fs-6 w-275px" data-kt-menu="true">
										<div class="menu-item px-3">
											<div class="menu-content d-flex align-items-center px-3">
												<div class="symbol symbol-50px me-5">
													<img style="object-fit:cover;" alt="Logo" src="../../images/<?php echo ($row_admin['profile_image'] != '') ? $row_admin['profile_image'] : 'blank.png' ?>" />
												</div>
												<div class="d-flex flex-column">
													<div class="fw-bolder d-flex align-items-center fs-5"><?php echo $row_admin['fullname'] ?>
														<!-- <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span> -->
													</div>
													<div class="fw-bold text-muted fs-7"><?php echo $row_admin['email'] ?></div>
												</div>
											</div>
										</div>
										<!-- <div class="separator my-2"></div>
										<div class="menu-item px-5"> -->
										<div class="separator"></div>
										<div class="menu-item">
											<a onclick="ModalPassword();" class="menu-link">
												<span class="menu-icon" style="color:#c0a4f7">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
														<path d="M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z" fill="currentColor" />
													</svg>
												</span>
												<span class="menu-title">เปลี่ยนรหัสผ่าน</span>
											</a>
										</div>
										<!-- <div class="menu-item px-5">
											<a href="../../demo1/dist/apps/projects/list.html" class="menu-link px-5">
												<span class="menu-text">My Projects</span>
												<span class="menu-badge">
													<span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
												</span>
											</a>
										</div> -->
										<div class="separator"></div>
										<div class="menu-item">
											<a onclick="Logout();" class="menu-link">
												<span class="menu-icon" style="color:#c0a4f7">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)" fill="currentColor" />
														<path d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z" fill="currentColor" />
														<path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="#C4C4C4" />
													</svg>
												</span>
												<span class="menu-title">ออกจากระบบ</span>
											</a>
										</div>
									</div>
								</div>
							</div>
							<!--end::Toolbar wrapper-->

						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Header-->