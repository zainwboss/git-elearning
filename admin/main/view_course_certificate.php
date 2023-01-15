<?php
include('header.php');

$course_id = $_GET['id'];
$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'  ORDER BY course_name ASC ";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

?>

<?php
if ($rs->num_rows > 0) { //เช็คหลักสูตร 
?>
    <!-- content -->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!-- toolbar -->
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo $row['course_name'] ?>
                    </h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index_course.php">รายการหลักสูตร</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">ใบประกาศ</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end toolbar -->

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <!-- tab -->
                <?php require('menu_view_course.php'); ?>
                <!-- end tap -->

                <div class="row g-5 g-xl-8">
                    <div class="col-xl-12">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-header mb-6">
                                <div class="form-check form-switch form-check-custom  form-check-solid <?php echo ($row['certificate_status'] == 1) ? 'form-check-purple' : ''; ?>" onchange="ChangeStatus(this,'<?php echo $row['course_id']; ?>')">
                                    <input class="form-check-input h-25px w-45px" type="checkbox" id="certificate_status" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                echo 'disabled';
                                                                                                                            } ?> <?php echo ($row['certificate_status'] == 1) ? 'checked' : ''; ?> />
                                    <label class="form-check-label fw-bold" for="certificate_status">
                                        เปิด/ปิดระบบการใช้งานใบประกาศนียบัตร
                                    </label>
                                </div>
                                <div class="card-toolbar">
                                    <?php if ($row_admin['admin_status'] != '2') { ?>
                                        <button class="btn btn-success btn-sm btn-hover-rise me-5" onclick="ModalCopy();">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            คัดลอกใบประกาศ
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="row mb-4">
                                    <?php if ($row_admin['admin_status'] != '2') { ?>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="fv-row mb-5">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="required">พื้นหลัง <span class="required"></span></span>
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="( ขนาดรูปภาพ 210 mm x 297 mm )"></i>
                                                </label>
                                                <input type="file" class="form-control" id="certificate_image" name="certificate_image" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="fv-row mb-5">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">ประเภท <span class="required"></span></span>
                                            </label>
                                            <select class="form-select form-select-solid" id="certificate_type" name="certificate_type" onchange="UpdateType();" data-control="select2" data-placeholder="กรุณาระบุประเภท" data-hide-search="true" <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                                                                                                    } ?>>
                                                <option value="1" <?php if ($row['certificate_type'] == 1) {
                                                                        echo 'selected';
                                                                    } ?>>แนวนอน</option>
                                                <option value="2" <?php if ($row['certificate_type'] == 2) {
                                                                        echo 'selected';
                                                                    } ?>>แนวตั้ง</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="separator mb-6"></div> -->

                                <div class="d-flex  flex-row align-items-center">
                                    <?php if ($row_admin['admin_status'] != '2') { ?>
                                        <button class="btn btn-primary btn-sm btn-hover-rise me-5" onclick="ModalAdd();">
                                            <span class="svg-icon svg-icon-2 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                                </svg>
                                            </span>
                                            เพิ่มเนื้อหา
                                        </button>
                                    <?php } ?>
                                    <a href="../../print/demo_certificate.php?id=<?= $course_id ?>&key=<?= rand(11111, 99999); ?>" target="_blank" class="btn btn-warning btn-sm btn-hover-rise me-5">
                                        <span class="svg-icon svg-icon-2 ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor" />
                                                <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        ตัวอย่าง
                                    </a>
                                </div>


                                <!-- <div class="d-flex align-items-center position-relative my-2">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <input type="text" data-filter="search" class="form-control form-control-solid ps-14" placeholder="ค้นหา">
                            </div> -->
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

<!--end content -->

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-700px">
        <div class="modal-content rounded">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_copy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content rounded">
            <div id="show_modal_copy"></div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

<script>
    $(document).ready(function() {
        GetTable();
        KTApp.init();
    });

    $("#certificate_image").change(function() {
        if ($(this).val() != '') {
            var fileExtension = ['jpg', 'jpeg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#certificate_image").val('');
                return false;
            } else {
                UploadImage();
            }
        }
    });

    function GetTable() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/GetTable.php",
            dataType: "html",
            data: {
                course_id: course_id
            },
            success: function(response) {
                $("#show_data").html(response);
                var t, e;
                t = document.querySelector("#tbl_certificate"),
                    e = $(t).DataTable({
                        "scrollX": true,
                    });
            }
        });
    }

    function UploadImage() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const course_id = urlParams.get('id');
        const certificate_image = $("#certificate_image")[0].files[0];

        let formData = new FormData();
        formData.append("certificate_image", certificate_image);
        formData.append("course_id", course_id);

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/UploadImage.php",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
            }
        });
    }

    function UpdateType() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const course_id = urlParams.get('id');
        let certificate_type = $('#certificate_type').val();
        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/UpdateType.php",
            dataType: "json",
            data: {
                course_id: course_id,
                certificate_type: certificate_type
            },
            success: function(response) {
            }
        });
    }

    function ModalCopy() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/ModalCopy.php",
            dataType: "html",
            data: {
                course_id: course_id
            },
            success: function(response) {
                $("#show_modal_copy").html(response);
                $("#modal_copy").modal('show');
                KTApp.init();
            }
        });
    }

    function ModalAdd() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/ModalAdd.php",
            dataType: "html",
            data: {
                course_id: course_id
            },
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();

                document.querySelectorAll('.ckeditor').forEach(e => {
                    ClassicEditor
                        .create(e, {
                            toolbar: []
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                e.value = editor.getData();
                            });
                            document.querySelector('#add_course').addEventListener('click', () => {
                                editor.model.change(writer => {
                                    writer.insertText('[course_name]', editor.model
                                        .document.selection.getLastPosition());
                                });
                            });
                            document.querySelector('#add_name').addEventListener('click', () => {
                                editor.model.change(writer => {
                                    writer.insertText('[fullname]', editor.model
                                        .document.selection.getLastPosition());
                                });
                            });
                            document.querySelector('#add_finish_datetime').addEventListener('click',
                                () => {
                                    editor.model.change(writer => {
                                        writer.insertText('[finish_datetime]', editor
                                            .model.document.selection
                                            .getLastPosition());
                                    });
                                });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                })

                $("#image_file").change(function() {
                    if ($(this).val() != '') {
                        var fileExtension = ['jpg', 'jpeg', 'png'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -
                            1) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#image_file").val('');
                            return false;
                        }
                    }
                });
            }
        });
    }

    function ModalEdit(cs_id) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: 'POST',
            url: "ajax/view_course_certificate/ModalEdit.php",
            dataType: "html",
            data: {
                course_id: course_id,
                cs_id: cs_id
            },
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();

                document.querySelectorAll('.ckeditor').forEach(e => {
                    ClassicEditor
                        .create(e, {
                            toolbar: []
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                e.value = editor.getData();
                            });
                            document.querySelector('#add_course').addEventListener('click', () => {
                                editor.model.change(writer => {
                                    writer.insertText('[course_name]', editor.model
                                        .document.selection.getLastPosition());
                                });
                            });
                            document.querySelector('#add_name').addEventListener('click', () => {
                                editor.model.change(writer => {
                                    writer.insertText('[fullname]', editor.model
                                        .document.selection.getLastPosition());
                                });
                            });
                            document.querySelector('#add_finish_datetime').addEventListener('click',
                                () => {
                                    editor.model.change(writer => {
                                        writer.insertText('[finish_datetime]', editor
                                            .model.document.selection
                                            .getLastPosition());
                                    });
                                });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                })

                $("#image_file").change(function() {
                    if ($(this).val() != '') {
                        var fileExtension = ['jpg', 'jpeg', 'png'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -
                            1) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#image_file").val('');
                            return false;
                        }
                    }
                });
            }
        });
    }

    function ChangeStatus(button, course_id) {
        $.ajax({
            type: "post",
            url: "ajax/view_course_certificate/ChangeStatus.php",
            data: {
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 1) {
                    if (response.status == 1) {
                        $(button).addClass('form-check-purple');
                    } else if (response.status == 0) {
                        $(button).removeClass('form-check-purple');
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }

    function Delete(cs_id) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

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
                    url: "ajax/view_course_certificate/Delete.php",
                    data: {
                        cs_id: cs_id,
                        course_id: course_id
                    },
                    success: function(response) {
                        if (response.result == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            GetTable();
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