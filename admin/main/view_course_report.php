<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id' ORDER BY course_name ASC ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

?>
<?php
if ($rs->num_rows > 0) { //เช็คหลักสูตร 
?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo $row['course_name'] ?></h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index_course.php">รายการหลักสูตร</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">รายงาน</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <?php require('menu_view_course.php'); ?>

                <div class="row g-5 g-xl-8">
                    <div class="col-xl-12">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-header pt-5 border-0">
                                <div class="card-title">
                                    <?php if ($row_admin['admin_status'] != '2') { ?>
                                    <button type="button" class="btn btn-success btn-sm btn-hover-rise" onclick="ExportReport();">
                                        <span class="svg-icon svg-icon-white svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M5 22H19C19.6 22 20 21.6 20 21V8L14 2H5C4.4 2 4 2.4 4 3V21C4 21.6 4.4 22 5 22Z" fill="currentColor" />
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                                <rect x="7.55518" y="16.7585" width="10.144" height="2" rx="1" transform="rotate(-45 7.55518 16.7585)" fill="currentColor" />
                                                <rect x="9.0174" y="9.60327" width="10.0952" height="2" rx="1" transform="rotate(45 9.0174 9.60327)" fill="currentColor" />
                                            </svg>
                                        </span>นำออก
                                    </button>
                                    <?php } ?>
                                </div>

                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center flex-wrap gap-4">
                                        <div class="form-check form-switch form-check-custom form-check-solid form-check-purple">
                                            <input class="form-check-input" type="checkbox" id="filter_status" name="filter_status" checked="checked" onchange="CheckedDate(this);" />
                                            <label class="form-check-label fw-bolder text-dark fs-7" for="filter_status">
                                                เฉพาะช่วงเวลา
                                            </label>
                                        </div>
                                        <div class="position-relative my-2">
                                            <span class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input class="form-control form-control-solid form-control-sm text-dark fs-7 ps-12" placeholder="วันที่" id="filter_date" name="filter_date" />
                                        </div>
                                        <div class="d-flex align-items-center fw-bolder ">
                                            <select class="form-select form-select-sm form-select-solid text-dark fs-7 fw-bolder ps-3 w-auto" id="filter_type" name="filter_type" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-200px" data-placeholder="กรุณาเลือกสถานะ">
                                                <option></option>
                                                <option value="all" selected>ทั้งหมด</option>
                                                <option value="pre">ก่อนเรียน</option>
                                                <option value="post">หลังเรียน</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-icon btn-warning btn-sm btn-hover-rise" onclick="GetTable();">
                                            <span class="svg-icon svg-icon-white svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body py-3">
                                <div id="show_data"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } else {
    session_destroy();
?>
    <script>
        alert("ไม่พบหลักสูตร");
        location.href = "../";
    </script>
<?php } ?>

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content rounded">
            <div id="show_modal"></div>
        </div>
    </div>
</div>


<?php include('footer.php') ?>

<script>
    $(document).ready(function() {
        var startDate = moment().subtract(1, "month");
        var endDate = moment();;
        $("#filter_date").daterangepicker({
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        GetTable();
    });

    function CheckedDate(ele) {
        $(ele).is(':checked') ? $("#filter_date").prop('disabled', false) : $("#filter_date").prop('disabled', true);
    }

    function GetTable() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        let filter_status = $('#filter_status').is(':checked') ? 1 : 0;
        let filter_date = $('#filter_date').val();
        let filter_type = $('#filter_type').val();

        $(".loader-wrapper111").fadeIn("slow");

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_report/GetTable.php",
            dataType: "html",
            data: {
                course_id: course_id,
                filter_status: filter_status,
                filter_date: filter_date,
                filter_type: filter_type
            },
            success: function(response) {
                $(".loader-wrapper111").fadeOut("slow");
                $("#show_data").html(response);
                var t, e;
                t = document.querySelector("#tbl_course_report"),
                    e = $(t).DataTable({
                        "scrollX": true,
                        'ordering': false
                    });
            }
        });
    }

    function ModalImportUser() {
        $.ajax({
            type: "POST",
            url: "ajax/view_course_report/ModalImportUser.php",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                $("#file_excel").change(function() {
                    var fileExtension = ['xlsx', 'xls'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'อัปโหลดได้เฉพาะไฟล์ XLSX และ XLS เท่านั้น',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#file_excel").val('');
                        // $(this).siblings('.label-excel').html('Choose file');
                        return false;
                    }
                    // var fileName = $(this).val().split('\\').pop()
                    // $(this).siblings('.label-excel').html(fileName);
                });
            }
        });
    }

    $.extend({
        redirectPost: function(location, args) {
            var form = '';
            $.each(args, function(key, value) {
                form += '<input type="hidden" name="' + key + '" value="' + value + '">';
            });
            $('<form action="' + location + '" method="POST" target="_blank">' + form + '</form>').appendTo('body').submit();
        }
    });

    function ExportReport() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        let filter_status = $('#filter_status').is(':checked') ? 1 : 0;
        let filter_date = $('#filter_date').val();
        let filter_type = $('#filter_type').val();

        var redirect = 'ajax/view_course_report/ExportReport.php';
        $.redirectPost(redirect, {
            course_id: course_id,
            filter_status: filter_status,
            filter_date: filter_date,
            filter_type: filter_type
        });
    }
</script>