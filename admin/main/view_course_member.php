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
                    <li class="breadcrumb-item text-dark">ผู้เข้าเรียนหลักสูตร</li>
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
                                <button type="button" class="btn btn-success btn-sm btn-hover-rise" onclick="ExportMember();">
                                    <span class="svg-icon svg-icon-white svg-icon-2 ">
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
                                <div class="d-flex flex-stack flex-wrap gap-2">
                                    <div class="d-flex align-items-center fw-bolder">
                                        <div class="text-gray-400 fs-7 me-2">สถานะ</div>
                                        <select class="form-select form-select-transparent text-dark fs-7 fw-bolder ps-3 w-auto" id="filter_status" name="filter_status" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-200px" data-placeholder="กรุณาเลือกสถานะ" onchange="GetTable();">
                                            <option></option>
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">ยังไม่ลงทะเบียน</option>
                                            <option value="2">ลงทะเบียนแล้ว</option>
                                            <option value="3">อยู่ระหว่างอบรม</option>
                                            <option value="4">ผ่านการอบรม</option>
                                            <option value="5">ไม่ผ่านหลักสูตร</option>
                                        </select>
                                    </div>
                                    <div class="position-relative my-1">
                                        <span class="svg-icon svg-icon-1 position-absolute top-50 translate-middle-y ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-filter="search" class="form-control form-control-solid ps-14" placeholder="ค้นหา">
                                    </div>
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
        GetTable();
    });

    function GetTable() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        let filter_status = $('#filter_status').val();

        $(".loader-wrapper111").fadeIn("slow");
        $.ajax({
            type: 'POST',
            url: "ajax/view_course_member/GetTable.php",
            dataType: "html",
            data: {
                course_id: course_id,
                filter_status: filter_status
            },
            success: function(response) {
                $(".loader-wrapper111").fadeOut("slow");
                $("#show_data").html(response);
                var t, e;
                t = document.querySelector("#tbl_course_member"),
                    e = $(t).DataTable({
                        "scrollX": true,
                    }),
                    document.querySelector('[data-filter="search"]').addEventListener("keyup", (function(t) {
                        e.search(t.target.value).draw()
                    }));
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

    function ExportMember() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        let filter_status = $('#filter_status').val();

        /* console.log(course_id+"***"+filter_status) */

        var redirect = 'ajax/view_course_member/ExportMember.php';
        $.redirectPost(redirect, {
            course_id: course_id,
            filter_status: filter_status
        });
    }
</script>