<?php include('header.php') ?>
<style>
    :root {
        --color: #f5f8fa;
    }

    .ck.ck-editor__main>.ck-editor__editable {
        background: var(--color);
        border-color: var(--color);
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">ผู้สอน</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>

                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-dark">รายการผู้สอน</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <div class="card-title">
                                <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button class="btn btn-primary btn-sm btn-hover-rise me-5" onclick="ModalAdd();">
                                    <span class="svg-icon svg-icon-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    เพิ่มผู้สอน
                                </button>
                                <?php } ?>
                            </div>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-filter="search" class="form-control form-control-solid ps-14" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div id="show_data"></div>
                        </div>
                        <!--begin::Body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
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
            url: "ajax/index_teacher/GetTable.php",
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                var t, e;
                t = document.querySelector("#tbl_teacher"),
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
            url: "ajax/index_teacher/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
                KTImageInput.createInstances();
                //CKEditor
                document.querySelectorAll('.ckeditor').forEach(e => {
                    ClassicEditor
                        .create(e, {
                            toolbar: []
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                e.value = editor.getData();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            }
        });
    }

    function ModalEdit(teacher_id) {
        $.ajax({
            type: "post",
            url: "ajax/index_teacher/ModalEdit.php",
            data: {
                teacher_id: teacher_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
                $("#modal").modal('show');
                KTApp.init();
                KTImageInput.createInstances();
                //CKEditor
                document.querySelectorAll('.ckeditor').forEach(e => {
                    ClassicEditor
                        .create(e, {
                            toolbar: []
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                e.value = editor.getData();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            }
        });
    }


    function ChangeStatus(button, teacher_id) {
        $.ajax({
            type: "post",
            url: "ajax/index_teacher/ChangeStatus.php",
            data: {
                teacher_id: teacher_id
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
</script>