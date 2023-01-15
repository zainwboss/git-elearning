<?php
session_start();
if (empty($_SESSION['user_id'])) {
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

$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$rs_user = mysqli_query($connection, $sql_user);
$row_user = mysqli_fetch_array($rs_user);

//แจ้งเตือน
$now = date('Y-m-d');
$sql_notify  = "SELECT * FROM tbl_course a 
	  WHERE active_status='1' 
	  AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
	  AND course_id NOT IN (SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count ='1' AND finish_datetime IS NOT NULL)
	  AND (('$now' BETWEEN course_start_date AND course_finish_date) OR ('$now' >= course_start_date AND course_finish_date IS NULL))
	  ORDER BY course_name ASC";
$rs_notify   = mysqli_query($connection, $sql_notify);
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
	<!-- <link rel="shortcut icon" href="../../template/assets/media/logos/favicon.ico" /> -->
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

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid">

			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				<div id="kt_header" class="header align-items-stretch">

					<!--begin::Container-->
					<div class="container-fluid d-flex align-items-stretch justify-content-between">
						<!--begin::Aside mobile toggle-->
						<!-- <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
							<div class="btn btn-icon btn-active-light-info w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
								<span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
										<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
									</svg>
								</span>
							</div>
						</div> -->
						<!--end::Aside mobile toggle-->
						<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-10">
							<a href="index_course.php">
								<img class="h-50px h-lg-60px" src="../../images/<?php echo $row_setting['logo_image'] ?>" alt="Logo" />
							</a>
						</div>
						<!--begin::Mobile logo-->
						<!-- <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
							<a href="index.php" class="d-lg-none">
								<img class="h-40px" src="../../images/<?php echo $row_setting['logo_image'] ?>" alt="Logo" />
							</a>
						</div> -->
						<!--end::Mobile logo-->

						<!--begin::Wrapper-->
						<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">

							<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
								<!--begin::Menu-->
								<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
									<!-- <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item here show menu-lg-down-accordion me-lg-1">
										<a href="index.php">
											<span class="menu-link py-3 <?php //if ($pagename == 'index.php') {echo 'active';} 
																		?>">
												<span class="menu-icon" style="color:#c0a4f7">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
													</svg>
												</span>
												<span class="menu-title">Dashboards</span>
											</span>
										</a>
									</div> -->
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<a href="index_course.php">
											<span class="menu-link py-3 <?php if ($pagename == 'index_course.php') {
																			echo 'active';
																		} ?>">
												<span class="menu-icon" style="color:#c0a4f7">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M16.9 10.7L7 5V19L16.9 13.3C17.9 12.7 17.9 11.3 16.9 10.7Z" fill="currentColor" />
													</svg>
												</span>
												<span class="menu-title">หลักสูตร</span>
												<!-- <span class="menu-arrow d-lg-none"></span> -->
											</span>
										</a>
										<!-- <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
											<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
												<span class="menu-link py-3">
													<span class="menu-icon">
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z" fill="currentColor"></path>
																<path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="currentColor"></path>
																<path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z" fill="currentColor"></path>
															</svg>
														</span>
													</span>
													<span class="menu-title">Pages</span>
													<span class="menu-arrow"></span>
												</span>
												<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
													<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
														<span class="menu-link py-3">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Profile</span>
															<span class="menu-arrow"></span>
														</span>
														<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/overview.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Overview</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/projects.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Projects</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/campaigns.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Campaigns</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/documents.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Documents</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/followers.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Followers</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/user-profile/activity.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Activity</span>
																</a>
															</div>
														</div>
													</div>
													<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
														<span class="menu-link py-3">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Blog</span>
															<span class="menu-arrow"></span>
														</span>
														<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/blog/home.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Blog Home</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/blog/post.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Blog Post</span>
																</a>
															</div>
														</div>
													</div>
													<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
														<span class="menu-link py-3">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Pricing</span>
															<span class="menu-arrow"></span>
														</span>
														<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/pricing/pricing-1.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Pricing 1</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/pricing/pricing-2.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Pricing 2</span>
																</a>
															</div>
														</div>
													</div>
													<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
														<span class="menu-link py-3">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Careers</span>
															<span class="menu-arrow"></span>
														</span>
														<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/careers/list.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Careers List</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/careers/apply.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Careers Apply</span>
																</a>
															</div>
														</div>
													</div>
													<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
														<span class="menu-link py-3">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">FAQ</span>
															<span class="menu-arrow"></span>
														</span>
														<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/faq/classic.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Classic</span>
																</a>
															</div>
															<div class="menu-item">
																<a class="menu-link py-3" href="../../demo1/dist/pages/faq/extended.html">
																	<span class="menu-bullet">
																		<span class="bullet bullet-dot"></span>
																	</span>
																	<span class="menu-title">Extended</span>
																</a>
															</div>
														</div>
													</div>
													<div class="menu-item">
														<a class="menu-link py-3" href="../../demo1/dist/pages/about.html">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">About Us</span>
														</a>
													</div>
													<div class="menu-item">
														<a class="menu-link py-3" href="../../demo1/dist/pages/contact.html">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Contact Us</span>
														</a>
													</div>
													<div class="menu-item">
														<a class="menu-link py-3" href="../../demo1/dist/pages/team.html">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Our Team</span>
														</a>
													</div>
													<div class="menu-item">
														<a class="menu-link py-3" href="../../demo1/dist/pages/licenses.html">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Licenses</span>
														</a>
													</div>
													<div class="menu-item">
														<a class="menu-link py-3" href="../../demo1/dist/pages/sitemap.html">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">Sitemap</span>
														</a>
													</div>
												</div>
											</div>
										</div> -->
									</div>
								</div>
								<!--end::Menu-->
							</div>

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

								<!--แจ้งเตือนหลักสูตร-->
								<div class="d-flex align-items-center ms-1 ms-lg-3">
									<a href="index_profile.php?id=<?= $user_id ?>&param=1" class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative" id="kt_drawer_chat_toggle">
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor" />
												<path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor" />
											</svg>
										</span>
										<?php if ($rs_notify->num_rows > 0) { ?>
											<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
										<?php } ?>
									</a>
								</div>

								<!-- เมนู user -->
								<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
									<div class="cursor-pointer symbol symbol-30px symbol-md-40px " data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<img style="object-fit:cover;" src="../../images/<?php echo ($row_user['profile_image'] != '') ? $row_user['profile_image'] : 'blank.png' ?>" alt="user" />
										<!-- <span class="fw-bold text-hover-primary ms-2"><?php echo $row_user['fullname'] ?></span> -->
									</div>
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-2 fs-6 w-275px" data-kt-menu="true">

										<div class="menu-item px-3">
											<div class="menu-content d-flex align-items-center px-3">
												<div class="symbol symbol-50px me-5">
													<img style="object-fit:cover;" alt="Logo" src="../../images/<?php echo ($row_user['profile_image'] != '') ? $row_user['profile_image'] : 'blank.png' ?>" />
												</div>
												<div class="d-flex flex-column">
													<div class="fw-bolder d-flex align-items-center fs-5"><?php echo $row_user['fullname'] ?>
														<!-- <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span> -->
													</div>
													<div class="fw-bold text-muted fs-7"><?php echo $row_user['email'] ?></div>
												</div>
											</div>
										</div>

										<div class="separator"></div>
										<div class="menu-item">
											<a href="index_profile.php?id=<?php echo $row_user['user_id'] ?>" class="menu-link">
												<span class="menu-icon" style="color:#c0a4f7">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
														<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
													</svg>
												</span>
												<span class="menu-title">โปรไฟล์ของฉัน</span>
											</a>
										</div>

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

								<!--begin::Header menu toggle-->
								<div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
									<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
												<path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
											</svg>
										</span>
									</div>
								</div>
								<!--end::Header menu toggle-->
							</div>
							<!--end::Toolbar wrapper-->

						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Header-->