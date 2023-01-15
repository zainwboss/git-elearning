<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$sql_question = "SELECT * FROM tbl_question WHERE course_id='$course_id' ORDER BY list_order ASC";
$rs_question = mysqli_query($connection, $sql_question);
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
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo $row['course_name'] ?></h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index_course.php">รายการหลักสูตร</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">ข้อสอบ</li>
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

                <div class="card mb-6 mb-xl-9">
                    <div class="card-body py-4">
                        <div class="d-flex flex-wrap align-items-center" id="rowbtnQuestion">
                            <?php while ($row_question = mysqli_fetch_array($rs_question)) { ?>
                                <button type="button" class="btn btn-light-info btn-sm btn-hover-rise me-5 my-3 w-55px bbbb btn_<?php echo $row_question['question_id'] ?>" id="btnQuestion" onclick="DetailQuestion('<?php echo $row_question['question_id'] ?>')"><?php echo $row_question['list_order'] ?></button>
                            <?php } ?>
                            <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button type="button" class="btn btn-primary btn-sm btn-hover-rise me-5 my-3" id="addQuestion" onclick="AddQuestion();">
                                    <span class="svg-icon svg-icon-white svg-icon-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <span class="indicator-label"> เพิ่มข้อสอบ</span>
                                    <span class="indicator-progress">โปรดรอสักครู่...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            <?php } ?>
                            <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button type="button" class="btn btn-sm btn-success btn-hover-rise me-5 my-3" onclick="ModalImportExam();">
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
                            <?php if ($row_admin['admin_status'] != '2') { ?>
                                <button type="button" class="btn btn-sm btn-danger btn-hover-rise my-3" onclick="DeleteAll();">
                                    <span class="svg-icon svg-icon-white svg-icon-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    ล้างข้อสอบ
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="table-loading-message">
                    โหลดข้อมูล...
                </div>
                <div id="ShowQuestion"> </div>
            </div>
        </div>
    </div>
    <!--end content -->
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
        $('.table-loading-message').hide();
        KTApp.init();
    });

    function AddQuestion() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        var btn = document.querySelectorAll('#btnQuestion');
        let count_btn = btn.length + 1;

        $("#addQuestion").attr('data-kt-indicator', 'on');
        $("#addQuestion").attr('disabled', true);
        $.ajax({
            type: "POST",
            url: "ajax/view_course_exam/AddQuestion.php",
            data: {
                course_id: course_id,
                count_btn: count_btn
            },
            dataType: "json",
            success: function(data) {
                $("#addQuestion").removeAttr('data-kt-indicator');
                $("#addQuestion").attr('disabled', false);

                if (data.result == '1') {
                    let btnQuestion = `<button type="button" class="btn btn-light-info btn-sm btn-hover-rise me-5 my-3 w-55px btn_${data.question_id}" id="btnQuestion" onclick="DetailQuestion('${data.question_id}');">${count_btn}</button>`;
                    $('#addQuestion').before(btnQuestion);

                    DetailQuestion(data.question_id);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เพิ่มข้อสอบไม่สำเร็จ โปรดติดต่อแอดมิน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }

    var form, validate;
    form = document.querySelector("#ShowQuestion");
    function DetailQuestion(question_id) {
        $('#ShowQuestion').empty();
        $('.table-loading-message').show();
        $('button#btnQuestion').removeClass('active');
        $('.btn_' + question_id).addClass('active');

        $.ajax({
            type: "POST",
            url: "ajax/view_course_exam/GetDetailQuestion.php",
            data: {
                question_id: question_id,
            },
            dataType: "html",
            success: function(response) {

                $('#ShowQuestion').html(response);
                $('.table-loading-message').hide();

                $("#question_image").change(function() {
                    if ($(this).val() != '') {
                        var fileExtension = ['jpg', 'jpeg', 'png'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#question_image").val('');
                            $("#img_question").attr('src', '../../images/blank.png');
                            return false;
                        } else {
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                $('#img_question').attr('src', e.target.result);
                            }
                            reader.readAsDataURL($(this).get(0).files[0]);
                        }
                    } else {
                        $("#img_question").attr('src', '../../images/blank.png');
                    }
                });

                $('input#choice_id').map(function() {
                    let choice_id = $(this).val();

                    $("#choice_image_" + choice_id).change(function() {
                        if ($(this).val() != '') {
                            var fileExtension = ['jpg', 'jpeg', 'png'];
                            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $("#img_choice_" + choice_id).attr('src', '../../images/blank.png');
                                $("#choice_image_" + choice_id).val('');
                                return false;
                            } else {
                                let reader = new FileReader();
                                reader.onload = function(e) {
                                    $("#img_choice_" + choice_id).attr('src', e.target.result);
                                }
                                reader.readAsDataURL($(this).get(0).files[0]);
                            }
                        } else {
                            $("#img_choice_" + choice_id).attr('src', '../../images/blank.png');
                        }
                    });
                });

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


               
                validate = FormValidation.formValidation(form, {
                    fields: {
                        question_text: {
                            validators: {
                                notEmpty: {
                                    message: "กรุณาระบุคำถาม"
                                }
                            }
                        },
                        // choice_text: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: "กรุณาระบุคำตอบให้ครบถ้วน"
                        //         }
                        //     }
                        // },
                        correct_status: {
                            'radio_input': {
                                validators: {
                                    notEmpty: {
                                        message: 'กรุณาเลือกคำตอบที่ถูกต้อง'
                                    }
                                }
                            },
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                });

            }
        });
    }

    function AddChoice(question_id) {

        var btn = document.querySelectorAll('#rowChoice');
        let count_choice = btn.length + 1;

        // Show loading indication
        $("#addChoice").attr('data-kt-indicator', 'on');
        $("#addChoice").attr('disabled', true);

        $.ajax({
            type: "POST",
            url: "ajax/view_course_exam/AddChoice.php",
            data: {
                question_id: question_id,
                count_choice: count_choice
            },
            dataType: "json",
            success: function(data) {

                $("#addChoice").removeAttr('data-kt-indicator');
                $("#addChoice").attr('disabled', false);

                if (data.result == '1') {
                    let choice_id = data.choice_id;
                    let choiceEle = ` <div class="col-md-6 fv-row Choice_${choice_id}">
                            <div class="btn btn-outline btn-outline-dashed text-start p-6 mb-5 w-100 rowChoice_${choice_id}" id="rowChoice">
                                <div class="d-flex align-items-center mb-5 mb-xl-8">
                                    <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                        <input class="form-check-input" type="radio" name="correct_status" id="correct_status_${choice_id}" value="1" onclick="ChoiceActive('${choice_id}');" />
                                        <input type="hidden" id="choice_id" name="choice_id" value="${choice_id}">
                                    </div>
                                    <div class="flex-grow-1 w-100">
                                        <textarea class="ckeditor" name="choice_text" id="choice_text_${choice_id}"></textarea>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="me-13">
                                        <button class="btn btn-sm btn-icon btn-danger w-25px h-25px" style="border-radius: 15px;" onclick="DeleteChoice('${choice_id}');">
                                            <span class="svg-icon svg-icon-muted svg-icon-1x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="w-100">
                                        <input type="file" class="form-control" name="choice_image" id="choice_image_${choice_id}" />
                                    </div>
                                    <div class="text-end ps-2">
                                        <button class="btn bg-light btn-active-icon-info p-1" data-bs-toggle="modal" data-bs-target="#modal_img_choice_${choice_id}">
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx m-0 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z" fill="currentColor" />
                                                    <path d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal_img_choice_${choice_id}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-500px">
                                    <div class="modal-content rounded">
                                        <div class="modal-header pb-0 border-0 justify-content-end">
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                            <div class="mb-13 text-center">
                                                <h1 class="mb-3">รูปภาพ</h1>
                                            </div>
                                            <div class="d-flex justify-content-center mb-8 ">
                                                <img class="w-250px h-250px" src="../../images/blank.png" id="img_choice_${choice_id}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#ShowChoice').append(choiceEle);

                    $("#choice_image_" + choice_id).change(function() {
                        if ($(this).val() != '') {
                            var fileExtension = ['jpg', 'jpeg', 'png'];
                            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'อัปโหลดได้เฉพาะไฟล์ PNG ,JPG และ JPEG เท่านั้น',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $("#img_choice_" + choice_id).attr('src', '../../images/blank.png');
                                $("#choice_image_" + choice_id).val('');
                                return false;
                            } else {
                                let reader = new FileReader();
                                reader.onload = function(e) {
                                    $("#img_choice_" + choice_id).attr('src', e.target.result);
                                }
                                reader.readAsDataURL($(this).get(0).files[0]);
                            }
                        } else {
                            $("#img_choice_" + choice_id).attr('src', '../../images/blank.png');
                        }
                    });

                    var e;
                    e = document.querySelector('#choice_text_' + choice_id),
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

                }
            }
        });
    }

    function ChoiceActive(choice_id, ) {
        if ($('#correct_status_' + choice_id).is(':checked')) {
            $("#ShowChoice div").removeClass('active');
            $('.rowChoice_' + choice_id).addClass('active');
        }
    }


    function ChangeStatus(button) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_course/ChangeStatus.php",
            data: {
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 1) {
                    if (response.status == 1) {
                        $(button).addClass('form-check-success');
                    } else if (response.status == 0) {
                        $(button).removeClass('form-check-success');
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

    function ModalImportExam() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: "POST",
            url: "ajax/view_course_exam/ModalImportExam.php",
            data: {
                course_id: course_id
            },
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

    function DeleteChoice(choice_id) {
        Swal.fire({
            title: 'กรุณายืนยันการลบคำตอบ',
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
                    url: "ajax/view_course_exam/DeleteChoice.php",
                    data: {
                        choice_id: choice_id
                    },
                    success: function(response) {
                        if (response.result == 1) {
                            $('.Choice_' + choice_id).fadeOut(300, function() {
                                $('.Choice_' + choice_id).remove();
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

    function DeleteQuestion(question_id) {

        Swal.fire({
            title: 'กรุณายืนยันการลบข้อสอบ',
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
                    url: "ajax/view_course_exam/DeleteQuestion.php",
                    data: {
                        question_id: question_id,
                    },
                    success: function(response) {
                        if (response.result == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#ShowQuestion').empty();

                            $('.btn_' + question_id).fadeOut(300, function() {
                                $('.btn_' + question_id).remove();

                                $('button#btnQuestion').map(function(index, ele) {
                                    let i = index + 1;
                                    $(ele).html(i);
                                });
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


    function DeleteAll() {
        Swal.fire({
            title: 'กรุณายืนยันการลบข้อสอบทั้งหมด',
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

                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                let course_id = urlParams.get('id');

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/view_course_exam/DeleteAll.php",
                    data: {
                        course_id: course_id,
                    },
                    success: function(response) {
                        if (response.result == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
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


    function submit() {
        if (validate) {
            validate.validate().then(function(status) {
                if (status == 'Valid') {
                    Swal.fire({
                        title: 'กรุณายืนยันการทำรายการ',
                        icon: "question",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary btn-hover-scale",
                            cancelButton: 'btn btn-sm btn-light btn-hover-scale'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading indication
                            $("#exam_submit").attr('data-kt-indicator', 'on');
                            $("#exam_submit").attr('disabled', true);

                            var formData = new FormData();
                            formData.append('question_id', $('#question_id').val());
                            formData.append('question_text', $('#question_text').val());
                            formData.append('question_image', $("#question_image")[0].files[0]);

                            var list_choice = [];
                            $('input#choice_id').map(function(index, ele) {
                                let choice_id = $(this).val();
                                list_choice.push({
                                    "choice_id": choice_id,
                                    "choice_text": $("#choice_text_" + choice_id).val(),
                                    "correct_choice_id": ($("#correct_status_" + choice_id).is(':checked')) ? '1' : '0'
                                })
                                formData.append(choice_id, $("#choice_image_" + choice_id)[0].files[0]);
                            });
                            formData.append("list_choice", JSON.stringify(list_choice));
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "ajax/view_course_exam/UpdateQuestion.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $("#exam_submit").removeAttr('data-kt-indicator');
                                    $("#exam_submit").attr('disabled', false);

                                    if (response.result == 1) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        form.reset(), validate.resetForm();
                                        // setTimeout(() => {
                                        //     location.href = "view_course_overview.php?id=" + response.course_id;
                                        // }, 1500);
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
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    }
</script>