<?php include('header.php') ?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">พนักงาน</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>

                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-dark">รายการพนักงาน</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button class="btn btn-primary btn-sm btn-hover-rise me-5" onclick="ModalAdd();" >
                                    <span class="svg-icon svg-icon-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                        </svg>
                                    </span>เพิ่มพนักงาน
                                </button>
                                <?php } ?>

                                <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button type="button" class="btn btn-success btn-sm btn-hover-rise" onclick="ModalImportUser();">
                                    <span class="svg-icon svg-icon-white svg-icon-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M5 22H19C19.6 22 20 21.6 20 21V8L14 2H5C4.4 2 4 2.4 4 3V21C4 21.6 4.4 22 5 22Z" fill="currentColor" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                            <rect x="7.55518" y="16.7585" width="10.144" height="2" rx="1" transform="rotate(-45 7.55518 16.7585)" fill="currentColor" />
                                            <rect x="9.0174" y="9.60327" width="10.0952" height="2" rx="1" transform="rotate(45 9.0174 9.60327)" fill="currentColor" />
                                        </svg>
                                    </span>นำเข้า
                                </button>
                                <?php } ?>
                            </div>

                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor">
                                            </rect>
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                        </svg>
                                    </span>

                                    <input type="text" data-filter="search" class="form-control form-control-solid ps-14" placeholder="ค้นหา">
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

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-700px">
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
        $.ajax({
            type: 'POST',
            url: "ajax/index_user/GetTable.php",
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                var t, e;
                t = document.querySelector("#tbl_user"),
                    e = $(t).DataTable({
                        "scrollX": true,
                    }),
                    document.querySelector('[data-filter="search"]').addEventListener("keyup", (function(t) {
                        e.search(t.target.value).draw()
                    }));
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/index_user/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
                KTImageInput.createInstances();
                $("#birthdate").flatpickr({
                    dateFormat: "d/m/Y",
                });
            }
        });
    }

    function ModalEdit(user_id) {
        $.ajax({
            type: "post",
            url: "ajax/index_user/ModalEdit.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
                KTImageInput.createInstances();
                $("#birthdate").flatpickr({
                    dateFormat: "d/m/Y",
                });
            }
        });
    }

    function ChangeStatus(button, user_id) {
        $.ajax({
            type: "post",
            url: "ajax/index_user/ChangeStatus.php",
            data: {
                user_id: user_id
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

    function ModalImportUser() {
        $.ajax({
            type: "POST",
            url: "ajax/index_user/ModalImportUser.php",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                $("#file_excel").change(function() {
                    if ($(this).val() != '') {
                        var fileExtension = ['xlsx', 'xls'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'อัปโหลดได้เฉพาะไฟล์ XLSX และ XLS เท่านั้น',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#file_excel").val('');
                            return false;
                        }
                    }
                });
            }
        });
    }
</script>