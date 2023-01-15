<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id' ORDER BY course_name ASC ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$sql_document = "SELECT COUNT(doc_id) AS all_file FROM tbl_course_document WHERE course_id='$course_id' ORDER BY list_order ASC ";
$rs_document  = mysqli_query($connection, $sql_document) or die($connection->error);
$row_document = mysqli_fetch_array($rs_document);

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
                        <li class="breadcrumb-item text-dark">สื่อประกอบหลักสูตร</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <!-- tab -->
                <?php require('menu_view_course.php'); ?>
                <!-- end tap -->

                <div class="d-flex flex-wrap flex-stack my-5">
                    <h3 class="fw-bolder my-2" id="list_file"><?php echo $row_document['all_file'] . ' รายการ' ?>
                        <span class="fs-6 text-gray-400 fw-bold ms-1"></span>
                    </h3>
                    <div class="d-flex my-2">
                        <?php if ($row_admin['admin_status'] != '2') { ?>
                        <button type="button" class="btn btn-primary btn-sm btn-hover-rise me-5" onclick="ModalAdd();">เพิ่มสื่อ</button>
                        <?php } ?>
                    </div>
                </div>
                <div id="show_data"></div>
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

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_document/GetTable.php",
            data: {
                course_id: course_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
            }
        });
    }

    function ModalAdd() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_document/ModalAdd.php",
            dataType: "html",
            data: {
                course_id: course_id
            },
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
            }
        });
    }

    function Delete(doc_id) {
        Swal.fire({
            title: 'กรุณายืนยันการลบรายการ',
            icon: "question",
            iconColor: '#ed5565',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "ยืนยัน",
            cancelButtonText: 'ยกเลิก',
            customClass: {
                confirmButton: "btn btn-sm btn-danger btn-hover-scale",
                cancelButton: 'btn btn-sm btn-light btn-hover-scale'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/view_course_document/Delete.php",
                    data: {
                        doc_id: doc_id
                    },
                    success: function(response) {
                        if (response.result == 1) {
                            $('#doc_' + doc_id).fadeOut(300, function() {
                                $('#doc_' + doc_id).remove();
                                $("#list_file").load(window.location.href + " #list_file");
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ลบข้อมูลไม่สำเร็จ กรุณาติดต่อแอดมิน',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });
    }
</script>