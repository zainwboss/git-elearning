<!DOCTYPE html>
<?php include('header.php'); ?>
<link href="../../template/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
<?php
// หลักสูตรทั้งหมด
// $sql_box1 = "SELECT * FROM tbl_course WHERE active_status='1'";
// $rs_box1 =  mysqli_query($connection, $sql_box1) or die($connection->error);

// พนักงานทั้งหมด
// $sql_box2 = "SELECT * FROM tbl_user WHERE active_status='1'";
// $rs_box2 =  mysqli_query($connection, $sql_box2) or die($connection->error);

// ยังไม่ได้เข้าเรียน
// $sql_box3 = "SELECT DISTINCT(user_id) FROM tbl_exam_head WHERE exam_count ='1' AND finish_datetime IS NOT NULL";
// $rs_box3 =  mysqli_query($connection, $sql_box3) or die($connection->error);

// ค่าเฉลี่ยการจบหลักสูตร
$sql_avg = "SELECT AVG(exam_count-1) AS avg_exam FROM tbl_exam_head WHERE pass_status ='1'";
$rs_avg =  mysqli_query($connection, $sql_avg) or die($connection->error);
$row_avg = mysqli_fetch_array($rs_avg);


?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="toolbar" id="kt_toolbar">
		<!--begin::Container-->
		<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
				<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">ภาพรวม</h1>
				<span class="h-20px border-gray-300 border-start mx-4"></span>
				<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
					<li class="breadcrumb-item ">
						<a href="index.php" class="text-muted text-hover-primary">หน้าหลัก</a>
					</li>
				</ul>
			</div>
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<button class="btn btn-primary btn-sm btn-hover-rise me-5" onclick="PrintThis();">
					<i class="fas fa-print"></i> พิมพ์
				</button>
			</div>
		</div>
	</div>

	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-fluid">

			<!-- <div class="row g-5 g-xl-10">
				<div class="col-md-6 col-xl-3 mb-xl-10">
					<a href="index_course.php" class="card bg-warning hoverable">
						<div class="card-body py-3">
							<div class="d-flex align-items-center flex-stack">
								<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M16.9 10.7L7 5V19L16.9 13.3C17.9 12.7 17.9 11.3 16.9 10.7Z" fill="currentColor" />
									</svg>
								</span>
								<div class="text-white fw-bolder fs-2hx" data-kt-countup="true" data-kt-countup-value="<?= $rs_box1->num_rows ?>">0</div>
							</div>
							<div class="fw-bold text-white fs-4">หลักสูตรทั้งหมด</div>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-xl-3 mb-xl-10">
					<a href="index_user.php" class="card bg-primary hoverable">
						<div class="card-body py-3">
							<div class="d-flex align-items-center flex-stack">
								<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor" />
										<rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor" />
										<path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor" />
										<rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor" />
									</svg>
								</span>
								<div class="text-white fw-bolder fs-2hx" data-kt-countup="true" data-kt-countup-value="<?= $rs_box2->num_rows ?>">0</div>
							</div>
							<div class="fw-bold text-white fs-4 ">พนักงานทั้งหมด</div>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-xl-3 mb-xl-10">
					<div class="card bg-success">
						<div class="card-body py-3">
							<div class="d-flex align-items-center flex-stack">
								<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
										<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
									</svg>
								</span>
								<div class="text-white fw-bolder fs-2hx" data-kt-countup="true" data-kt-countup-value="<?= $rs_box3->num_rows ?>">0</div>
							</div>
							<div class="fw-bold text-white fs-4 ">เข้าเรียนแล้ว</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xl-3 mb-5 mb-xl-10">
					<div class="card bg-danger">
						<div class="card-body py-3">
							<div class="d-flex align-items-center flex-stack">
								<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
										<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
										<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
									</svg>
								</span>
								<div class="text-white fw-bolder fs-2hx" data-kt-countup="true" data-kt-countup-value="<?= ($rs_box2->num_rows -  $rs_box3->num_rows) ?>">0</div>
							</div>
							<div class="fw-bold text-white fs-4">ยังไม่ได้เข้าเรียน</div>
						</div>
					</div>
				</div>
			</div> -->
			<!-- <div class="display" id="break_page" style='page-break-after:always'></div> -->
			<div class="row g-5 g-xl-10">
				<div class="col-xl-8 mb-xl-10">
					<div class="card card-flush h-xl-100">
						<div class="card-header pt-7">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bolder text-dark">ระยะเวลาการเรียน (จำนวนครั้ง)</span>
							</h3>
						</div>
						<div class="card-body pt-5">
							<div id="chart2" class="w-100 h-350px"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 mb-5 mb-xl-10">
					<div class="card card-flush h-xl-100">
						<div class="card-header border-0 pt-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bolder text-dark">ปริมาณผู้จบหลักสูตร</span>
							</h3>
						</div>

						<div class="card-body  pt-5">
							<div class="hover-scroll h-350px">
								<?php
								$sql_group = "SELECT * FROM tbl_group WHERE active_status ='1' ORDER BY group_name ASC";
								$rs_group =  mysqli_query($connection, $sql_group) or die($connection->error);
								while ($row_group = mysqli_fetch_array($rs_group)) {

									//จำนวนหลักสูตรทั้งหมดในกลุ่ม
									$sql_cg = "SELECT COUNT(course_id) AS count_course FROM tbl_course_group WHERE group_id ='{$row_group['group_id']}'";
									$rs_cg =  mysqli_query($connection, $sql_cg) or die($connection->error);
									$row_cg = mysqli_fetch_array($rs_cg);
									$count_course = $row_cg['count_course'];

									//จำนวนพนักงานที่สอบผ่านทุกหลักสูตรในกลุ่มนั้น
									$sql_eh = "SELECT user_id FROM tbl_course_register 
											   WHERE user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id ='{$row_group['group_id']}') 
											   AND finish_datetime IS NOT NULL 
											   GROUP BY user_id HAVING COUNT(*) = $count_course";
									$rs_eh  = mysqli_query($connection, $sql_eh);
									$row_eh = mysqli_fetch_array($rs_eh);

									//จำนวนพนักงานทั้งในกลุ่ม
									$sql_ug = "SELECT COUNT(user_id) AS count_user FROM tbl_user_group WHERE group_id ='{$row_group['group_id']}'";
									$rs_ug  = mysqli_query($connection, $sql_ug);
									$row_ug = mysqli_fetch_array($rs_ug);

									$per = ($rs_eh->num_rows / $row_ug['count_user']) * 100;
									// echo $sql_eh . '<br>' . $row_eh['count_eh'];
								?>
									<div class="rounded-pill bg-secondary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
										<div class="position-absolute rounded-pill d-block  start-0 top-0 h-100 z-index-1" style="width:<?= number_format($per, 2) ?>%;background-color: <?= $row_group['group_color'] ?>;"></div>

										<div class="d-flex align-items-center position-relative z-index-2">
											<a href="#" class="fw-bold text-white text-hover-dark ms-3"><?= $row_group['group_name'] . ' ' . $rs_eh->num_rows . ' คน' ?></a>
										</div>
										<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
											<?= number_format($per, 2) . '%' ?>
										</div>
									</div>
									<div class="separator separator-dashed my-3"></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="display" id="break_page" style='page-break-after:always'></div> -->
			<div class="row g-5 g-xl-10">
				<div class="col-xl-8 mb-xl-10">
					<div class="card card-flush h-md-100">
						<div class="card-header pt-7">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bolder text-dark">ปริมาณผู้เข้าระบบ</span>
							</h3>
						</div>
						<div class="card-body pt-5">
							<div id="chart1" class="w-100 h-325px"></div>
						</div>
					</div>
				</div>

				<div class="col-xl-4 mb-5 mb-xl-10">
					<div class="card h-xl-100">
						<div class="card-header border-0 pt-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bolder text-dark">ค่าเฉลี่ยการจบหลักสูตร</span>
							</h3>
						</div>
						<div class="card-body pt-5">
							<div class="d-flex flex-center">
								<div class="octagon d-flex flex-center h-200px w-200px bg-light-info my-15 mx-2">
									<div class="text-center">
										<span class="svg-icon svg-icon-2tx svg-icon-info">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor" />
												<path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor" />
											</svg>
										</span>
										<div class="mt-1">
											<div class="fs-2qx fw-bolder text-gray-800 d-flex align-items-center">
												<div class="min-w-50px" data-kt-countup="true" data-kt-countup-decimal-places="2" data-kt-countup-value="<?= $row_avg['avg_exam'] ?>" data-kt-countup-suffix=" ครั้ง">0</div>
											</div>
											<!-- <span class="text-gray-600 fw-bold fs-5 lh-0">Payments</span> -->
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>
	</div>
</div>


<?php include('footer.php'); ?>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<!-- <script src="../../template/assets/js/widgets.bundle.js"></script> -->
<script src="../../template/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
<script src="../../template/assets/js/printThis.js"></script>

<!-- chart1 -->
<script>
	function PrintThis() {
		$('#kt_post').printThis({
			importCSS: true,
			importStyle: true,
			header: null,
			footer: null,
			pageTitle: "",
			printContainer: true,
			removeInline: false,
		});
	}

	am5.ready(function() {
		$.ajax({
			type: "post",
			url: "ajax/dashboard/GetDataChart1.php",
			dataType: "json",
			success: function(data) {

				var e = document.getElementById("chart1");
				var a = am5.Root.new(e);
				a.setThemes([am5themes_Animated.new(a)]);
				var t = a.container.children.push(
					am5xy.XYChart.new(a, {
						panX: !0,
						panY: !0,
						wheelX: "panX",
						wheelY: "zoomX",
					})
				);
				//เพิ่มเส้นปะ ณ จุด cursor ชี้อยุ่ 
				t.set(
					"cursor",
					am5xy.XYCursor.new(a, {
						behavior: "none"
					})
				).lineY.set("visible", !1);

				var l = data,
					o = t.xAxes.push(
						am5xy.CategoryAxis.new(a, {
							categoryField: "time",
							startLocation: 0.5,
							endLocation: 0.5,
							renderer: am5xy.AxisRendererX.new(a, {}),
							tooltip: am5.Tooltip.new(a, {}),
						})
					);
				o
					.get("renderer")
					.grid.template.setAll({
						disabled: !0,
						strokeOpacity: 0
					}),
					o
					.get("renderer")
					.labels.template.setAll({
						fontWeight: "400",
						fontSize: 13,
						fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
					}),
					o.data.setAll(l);
				// ตั้งค่าแกน Y
				var r = t.yAxes.push(
					am5xy.ValueAxis.new(a, {
						renderer: am5xy.AxisRendererY.new(a, {}),
					})
				);
				//ฟังชั่น setting ข้อมูล
				function i(e, i, s) {
					var n = t.series.push(
						am5xy.LineSeries.new(a, {
							name: e,
							xAxis: o,
							yAxis: r,
							stacked: !0,
							valueYField: i,
							categoryXField: "time",
							fill: am5.color(s),
							tooltip: am5.Tooltip.new(a, {
								pointerOrientation: "horizontal",
								labelText: "{valueY}",
								// labelText: "[bold]{name}[/]\n{categoryX}: {valueY}",
							}),
						})
					);
					n.fills.template.setAll({
							fillOpacity: 0.5,
							visible: !0,
						}),
						n.data.setAll(l),
						n.appear(1e3);

				}
				//ตั้งค่าการโชว์ grid ด้านหลังของแกน y
				r
					.get("renderer")
					.grid.template.setAll({
						stroke: am5.color(KTUtil.getCssVariableValue("--bs-gray-300")),
						strokeWidth: 1,
						strokeOpacity: 1,
						strokeDasharray: [3],
					}),
					r
					.get("renderer")
					.labels.template.setAll({
						fontWeight: "400",
						fontSize: 13,
						fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
					}),
					//เรียกฟังชั่น setting ข้อมูล
					i("Series 1", "value", KTUtil.getCssVariableValue("--bs-info")),
					t.set( //scroll bar แถมยาวๆ ด้านบน
						"scrollbarX",
						am5.Scrollbar.new(a, {
							orientation: "horizontal",
							marginBottom: 25,
							height: 8,
						})
					);

				// Add export menu
				// var exporting = am5plugins_exporting.Exporting.new(a, {
				// 	menu: am5plugins_exporting.ExportingMenu.new(a, {})
				// });
			}
		});
	});
</script>

<!-- chart2 -->
<script>
	am5.ready(function() {
		$.ajax({
			type: "post",
			url: "ajax/dashboard/GetDataChart2.php",
			dataType: "json",
			success: function(data) {
				// Create root element
				var root = am5.Root.new("chart2");
				// Set themes
				root.setThemes([am5themes_Animated.new(root)]);

				// สร้าง chart
				var chart = root.container.children.push(am5xy.XYChart.new(root, {
					panX: true,
					panY: true,
					wheelX: "panX",
					wheelY: "zoomX",
					pinchZoomX: true,
					// layout: root.verticalLayout,
				}));

				//เพิ่มเส้นปะ ณ จุด cursor ชี้อยุ่ ถ้าปิดคำสั่งนี้ tooltip บนล่างก็จะไม่ขึ้นด้วย
				var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
				// ปิดเส้นแกน Y
				cursor.lineY.set("visible", false);
				cursor.lineX.set("visible", false);

				// ตั้งค่าแกน X
				var xRenderer = am5xy.AxisRendererX.new(root, {
					minGridDistance: 30
				});

				//ตั้งค่าการโชว์ label ด้านล่างแกน x
				xRenderer.labels.template.setAll({
					fontWeight: "400",
					fontSize: 13,
					rotation: -90,
					centerY: am5.p50,
					centerX: am5.p100,
					paddingRight: 10,
					fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
				});

				//ตั้งค่าการโชว์ grid ด้านหลังของแกน x
				xRenderer.grid.template.setAll({
					disabled: true,
					strokeOpacity: 0
				});

				// ตั้งค่าแกน Y
				var yRenderer = am5xy.AxisRendererY.new(root, {});

				//ตั้งค่าการโชว์ label ด้านล่างแกน  y
				yRenderer.labels.template.setAll({
					paddingLeft: 5,
					fontWeight: "400",
					fontSize: 13,
					fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
				});

				//ตั้งค่าการโชว์ grid ด้านหลังของแกน y
				yRenderer.grid.template.setAll({
					stroke: am5.color(
						KTUtil.getCssVariableValue("--bs-gray-300")
					),
					strokeWidth: 1,
					strokeOpacity: 1,
					strokeDasharray: [3],
				});

				var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
					maxDeviation: 0.1, //ค่าเบี่ยงเบนแกน x
					categoryField: "time",
					renderer: xRenderer,
					// tooltip: am5.Tooltip.new(root, {})
				}));

				var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
					maxDeviation: 0, //ค่าเบี่ยงเบนแกน y เวลาลากจะลากลงมาได้มากกว่า 0
					renderer: yRenderer
				}));

				// Create series
				// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
				var series = chart.series.push(am5xy.ColumnSeries.new(root, {
					name: "Series 2",
					xAxis: xAxis,
					yAxis: yAxis,
					valueYField: "value", //ขึ้นกราฟที่ละลำดับแต่ละแท่ง
					categoryXField: "time", //ขึ้นกราฟที่ละลำดับแต่ละแท่ง
					sequencedInterpolation: true, //ขึ้นกราฟที่ละลำดับแต่ละแท่ง
					tooltip: am5.Tooltip.new(root, {
						labelText: "{valueY}"
					})
				}));

				series.columns.template.setAll({
					// tooltipText: "{categoryX}: {valueY}", 
					// tooltipY: 0,
					// strokeOpacity: 0,
					cornerRadiusTL: 6,
					cornerRadiusTR: 6
				});

				series.columns.template.adapters.add("fill", function(fill, target) {
					return chart.get("colors").getIndex(series.columns.indexOf(target));
				});

				series.columns.template.adapters.add("stroke", function(stroke, target) {
					return chart.get("colors").getIndex(series.columns.indexOf(target));
				});

				// Set data
				// var data = [{
				// 	time: "USA",
				// 	value: 2025
				// }, {
				// 	time: "China",
				// 	value: 1882
				// }, {
				// 	time: "Japan",
				// 	value: 1809
				// }, {
				// 	time: "Germany",
				// 	value: 1322
				// }, {
				// 	time: "UK",
				// 	value: 1122
				// }, {
				// 	time: "France",
				// 	value: 1114
				// }, {
				// 	time: "India",
				// 	value: 984
				// }, {
				// 	time: "Spain",
				// 	value: 711
				// }, {
				// 	time: "Netherlands",
				// 	value: 665
				// }, {
				// 	time: "South Korea",
				// 	value: 443
				// }, {
				// 	time: "Canada",
				// 	value: 441
				// }];

				xAxis.data.setAll(data);
				series.data.setAll(data);

				// Add export menu
				// var exporting = am5plugins_exporting.Exporting.new(root, {
				// 	menu: am5plugins_exporting.ExportingMenu.new(root, {})
				// });

				// Make stuff animate on load
				// https://www.amcharts.com/docs/v5/concepts/animations/
				series.appear(1000);
				chart.appear(1000, 100);
			}
		});
	});
</script>