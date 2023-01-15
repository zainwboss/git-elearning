<?php
include('header.php');
$course_id = $_GET['id'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$sql_q = "SELECT q.* FROM tbl_question q WHERE q.course_id='$course_id' ORDER BY q.list_order ASC ";
$rs_q  = mysqli_query($connection, $sql_q) or die($connection->error);
$row_q = mysqli_fetch_array($rs_q);

$sql_eh = "SELECT * FROM tbl_exam_head WHERE course_id ='$course_id' AND user_id ='$user_id' ORDER BY create_datetime DESC LIMIT 1";
$rs_eh = mysqli_query($connection, $sql_eh) or die($connection->error);
$row_eh = mysqli_fetch_array($rs_eh);

$topic_exam = "";
$status_exam = 0; // 0= เริ่มทำข้อสอบ,1 = ทำต่อ, 2= หมดเวลา
$date_now = date('Y-m-d H:i:s');
$exam_head_id = "";

if ($rs_eh->num_rows > 0) { //เช็คว่าเคยมีการสอบไหม
    if ($row_eh['finish_datetime'] == '') { //มีการสอบและยังสอบไม่จบ
        $exam_head_id = $row_eh['exam_head_id'];
        if ($row_eh['exam_count'] == 1) { //pre
            $topic_exam = 'ข้อสอบก่อนเรียน (ต่อ)';
        } else {  //post
            $topic_exam = 'ข้อสอบหลังเรียนครั้งที่ ' . ($row_eh['exam_count'] - 1) . ' (ต่อ)';
        }
        //เวลา
        if ($date_now < $row_eh['expire_datetime']) {
            $status_exam = 1;
            $diff = date_diff(date_create($date_now), date_create($row_eh['expire_datetime']));
            $hours = str_pad($diff->h, 2, '0', STR_PAD_LEFT);
            $minutes = str_pad($diff->i, 2, '0', STR_PAD_LEFT);
            $seconds = str_pad($diff->s, 2, '0', STR_PAD_LEFT);
        } else {
            $status_exam = 2;
            $hours = '00';
            $minutes = '00';
            $seconds = '00';
        }
    } else {  //มีการสอบและสอบเสร็จแล้วให้เริ่มข้อสอบใหม่

        $topic_exam = 'ข้อสอบหลังเรียนครั้งที่ ' . ($row_eh['exam_count']);

        //เวลา
        $time = date('H:i:s', mktime(0, $row['exam_time'], 0));
        $hours =  explode(':', $time)[0];
        $minutes = explode(':', $time)[1];
        $seconds = explode(':', $time)[2];
    }
} else {
    $topic_exam = 'ข้อสอบก่อนเรียน';

    //เวลา
    // $time = gmdate("H:i:s", $row['exam_time']);
    $time = date('H:i:s', mktime(0, $row['exam_time'], 0));
    $hours =  explode(':', $time)[0];
    $minutes = explode(':', $time)[1];
    $seconds = explode(':', $time)[2];
}

?>
<style>
    /* .btn.btn-outline.btn-outline-dashed.btn-outline-default {
        border-width: 2px;
        border-style: solid;
        color: #7e8299;
        border-color: #e4e6ef;
    }

    .btn-check:active+.btn.btn-outline.btn-outline-dashed.btn-outline-default,
    .btn-check:checked+.btn.btn-outline.btn-outline-dashed.btn-outline-default,
    .btn.btn-outline.btn-outline-dashed.btn-outline-default.active,
    .btn.btn-outline.btn-outline-dashed.btn-outline-default.show,
    .btn.btn-outline.btn-outline-dashed.btn-outline-default:active:not(.btn-active),
    .btn.btn-outline.btn-outline-dashed.btn-outline-default:focus:not(.btn-active),
    .btn.btn-outline.btn-outline-dashed.btn-outline-default:hover:not(.btn-active),
    .show>.btn.btn-outline.btn-outline-dashed.btn-outline-default {
        color: #1ab394;
        border-color: #1ab394;
        background-color: #ffffff !important
    } */
</style>

<?php
if ($rs->num_rows > 0) { //เช็คหลักสูตร 
?>
    <div class="content d-flex flex-column flex-column-fluid bg-white" id="kt_content">
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
                        <li class="breadcrumb-item text-muted">
                            <a href="view_user_course.php?id=<?php echo $course_id ?>">ภาพรวม</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">ข้อสอบ</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <input type="hidden" id="exam_head_id" name="exam_head_id" value="<?php echo $exam_head_id ?>">
                <input type="hidden" id="status_exam" name="status_exam" value="<?php echo $status_exam ?>">
                <input type="hidden" id="previous_status" name="previous_status" value="0">

                <div class="d-flex flex-column flex-center p-10 p-lg-20">
                    <h3 class="fw-bolder fs-2qx text-dark m-0 pb-10"><?php echo $topic_exam ?></h3>
                    <div class="d-flex text-center mb-10 mb-lg-15">
                        <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                            <div class="fs-2 fw-bolder text-gray-800" id="hours"><?php echo $hours;  ?></div>
                            <div class="fs-7 text-muted">ชม.</div>
                        </div>
                        <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                            <div class="fs-2 fw-bolder text-gray-800" id="minutes"><?php echo $minutes; ?></div>
                            <div class="fs-7 text-muted">นาที</div>
                        </div>
                        <div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
                            <div class="fs-2 fw-bolder text-gray-800" id="seconds"><?php echo $seconds; ?></div>
                            <div class="fs-7 text-muted">วินาที</div>
                        </div>
                    </div>
                    <div id="row_btn_exam">
                        <?php if ($status_exam == 0) { ?>
                            <button type="button" id="btn_start_exam" onclick="GetExam();" class="btn btn-icon btn-light-info pulse pulse-info p-5 w-100">
                                <span class="svg-icon svg-icon-3 me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="pulse-ring"></span>
                                เริ่มทำข้อสอบ
                            </button>
                        <?php } else  if ($status_exam == 1) { ?>
                            <button type="button" id="btn_start_exam" onclick="GetBtnExam()" class="btn btn-icon btn-light-info pulse pulse-info p-5 w-100">
                                <span class="svg-icon svg-icon-3 me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="pulse-ring"></span>
                                ทำข้อสอบต่อ
                            </button>
                        <?php } else { ?>
                            <button type="button" id="btn_start_exam" onclick="SendExam()" class="btn btn-icon btn-light-info pulse pulse-info p-5 w-100">
                                <span class="svg-icon svg-icon-3 me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor" />
                                        <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="pulse-ring"></span>
                                ส่งคำตอบ
                            </button>
                        <?php } ?>
                    </div>
                    <div id="row_sub_btn_exam" class="w-100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content rounded">
                <div id="show_modal"></div>
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

<?php include('footer.php') ?>

<script>
    $(document).ready(function() {
        if ($('#status_exam').val() == 1) {
            StartCountDown();
        }
    });

    var handler,
        date = new Date(),
        h = date.setHours($('#hours').html()), // obtain these values somewhere else 
        m = date.setMinutes($('#minutes').html()),
        s = date.setSeconds($('#seconds').html());


    function CountDown() {

        let time = date.getTime();
        date.setTime(time - 1000);
        let formatDate = date.toTimeString().split(" ")[0];

        $('#hours').html(formatDate.split(":")[0]);
        $('#minutes').html(formatDate.split(":")[1]);
        $('#seconds').html(formatDate.split(":")[2]);

        if (date.getHours() === 0 && date.getMinutes() === 0 && date.getSeconds() === 0) {
            clearInterval(handler);
            TimeOut();
        }
    }

    // document.getElementById("btn_start_exam").addEventListener("click", function() {
    //     clearInterval(handler);
    //     handler = setInterval(CountDown, 1000);
    // });

    function StartCountDown() {
        handler = setInterval(CountDown, 1000);
    }

    function GetExam() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        $.ajax({
            type: "POST",
            url: "ajax/exam/GetExam.php",
            data: {
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 1) {
                    // $('#row_btn_exam').remove();
                    $('#exam_head_id').val(response.exam_head_id);
                    GetBtnExam();
                    StartCountDown();
                } else if (response.result == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อสอบเกิดข้อผิดพลาด กรุณาติดต่อแอดมิน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (response.result == 8) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบหลักสูตร',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                } else if (response.result == 9) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                }
            }
        });
    }

    function GetBtnExam() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        let exam_head_id = $('#exam_head_id').val();

        $.ajax({
            type: "POST",
            url: "ajax/exam/GetBtnExam.php",
            data: {
                exam_head_id: exam_head_id,
                course_id: course_id
            },
            dataType: "html",
            success: function(response) {
                $('#row_btn_exam').html(response);
                GetSubBtnExam(1);
            }
        });
    }

    function GetSubBtnExam(btn_no) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');
        let exam_head_id = $('#exam_head_id').val();

        $.ajax({
            type: "POST",
            url: "ajax/exam/GetSubBtnExam.php",
            data: {
                exam_head_id: exam_head_id,
                course_id: course_id,
                btn_no: btn_no
            },
            dataType: "html",
            success: function(response) {
                AddChoice();
                setTimeout(() => {
                    $('button[name="btnExam"]').removeClass('active');
                    $('#btnExam' + btn_no).removeClass('btn-success').addClass('btn-light-info active');
                    $('#row_sub_btn_exam').html(response);
                    Last(); //เช็คสำหรับข้อสอบที่มีข้อเดียว
                    //เช็คมาจากการกดปุ่มก่อนระหว่างชุด
                    if ($('#previous_status').val() == 1) {
                        $('#previous_status').val(0);
                        let last_btn = $('[name="subbtnExam"]').last().attr('id').split('_')[1];
                        $('#subbtnExam_' + last_btn).click();
                    }
                }, 1000);
            }
        });
    }

    function AddChoice() {
        let exam_head_id = $('#exam_head_id').val();
        let exam_id = $('#exam_id').val();

        if ($('input[name="choice_id_' + exam_id + '"]').is(':checked')) {
            let choice_id = $('input[name="choice_id_' + exam_id + '"]:checked').data('choice_id');
            $.ajax({
                type: "POST",
                url: "ajax/exam/AddChoice.php",
                data: {
                    exam_head_id: exam_head_id,
                    exam_id: exam_id,
                    choice_id: choice_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.result == 1) {

                        $('#subbtnExam_' + exam_id).removeClass('btn-light-info').addClass('btn_sub_finish btn-success');

                        //ถ้าทำข้อสอบทุกข้อให้ active ปุ่มหลัก
                        let no = $('#btn_no').val();
                        let btn_this_exam = Number($('#btn_this_exam').val()); //จำนวนข้อสอบของชุดปัจจุบัน
                        let btn_finish = $('button[name="subbtnExam"].btn_sub_finish').length; //จำนวนข้อสอบที่ตอบแล้ว
                        if (btn_this_exam == btn_finish) {
                            $('#btnExam' + no).removeClass('btn-light-info active').addClass('btn_finish btn-success');
                        }

                        //เช็คปุ่มส่งข้อสอบ
                        let total_exam = Number($('#total_exam').val());
                        let btnExam = $('button[name="btnExam"].btn_finish').length;
                        if (total_exam == btnExam) {
                            $('button#send_exam').attr('hidden', false);
                        }
                        Last(); //เช็คข้อสอบข้อสุดท้ายหลังจาก add choice ข้อก่อนหน้าแล้ว
                    }
                }
            });
        }
    }

    function NextPreviousBtn(id) {
        $('#subbtnExam_' + id).click();
    }

    function PreviousBtnNo(btn_no) {
        $('#previous_status').val(1);
        $('#btnExam' + btn_no).click();
    }

    function NextBtnNo(btn_no) {
        $('#btnExam' + btn_no).click();
    }

    function ActiveSubBtn(exam_id) {
        //เข้า func แอดก่อนยังไงปุ่มก่อนหน้าก็มีคลาส btn-success
        AddChoice();

        // ลบคลาส active ทั้งหมด 
        $('button[name="subbtnExam"]').removeClass('active');
        //ปุ่มปัจปัน active สีม่วง 
        $('#subbtnExam_' + exam_id).removeClass('btn-success').addClass('btn-light-info active');

        $('[name="detailExam"]').attr('hidden', true);
        $('#detailExam_' + exam_id).attr('hidden', false);

        $('#exam_id').val(exam_id);
    }

    function Last() {
        //ข้อสุดท้าย
        let exam_id = $('#exam_id').val();
        let btn_this_exam = Number($('#btn_this_exam').val()); //จำนวนข้อสอบของชุดปัจจุบัน
        let btn_finish = $('button[name="subbtnExam"].btn_sub_finish').length; //จำนวนข้อสอบที่ตอบแล้ว
        let total_exam = Number($('#total_exam').val()); //เช็คปุ่มส่งข้อสอบ
        let btnExam = $('button[name="btnExam"].btn_finish').length;

        let chk_exam_last = total_exam - btnExam;
        let chk_btn_last = btn_this_exam - btn_finish;
        if ((chk_exam_last == 1 && chk_btn_last == 1 && $('button[name="subbtnExam"].active').not('btn_sub_finish')) || total_exam == 1 && btn_this_exam == 1) {
            $('input[name="choice_id_' + exam_id + '"]').change(function() {
                AddChoice();
            });
        }
    }

    function SendExam() {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        let exam_head_id = $('#exam_head_id').val();

        Swal.fire({
            title: 'กรุณายืนยันการส่งข้อสอบ',
            icon: "question",
            // iconColor: '#ed5565',
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
                AddChoice(); // ยิงส่งข้อล่าสุดไปอีกที

                $(".loader-wrapper111").fadeIn("slow");
                $("#send_exam").attr('data-kt-indicator', 'on');
                $("#send_exam").attr('disabled', true);

                $.ajax({
                    type: "POST",
                    url: "ajax/exam/SendExam.php",
                    data: {
                        exam_head_id: exam_head_id,
                        course_id: course_id
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".loader-wrapper111").fadeOut("slow");
                        $("#send_exam").removeAttr('data-kt-indicator');
                        $("#send_exam").attr('disabled', false);

                        if (response.result == 1) {
                            location.href = "exam_result.php?id=" + exam_head_id;
                        } else if (response.result == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อสอบเกิดข้อผิดพลาด กรุณาติดต่อแอดมิน',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (response.result == 8) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'ไม่พบหลักสูตร',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                location.href = "../";
                            }, 1500);
                        } else if (response.result == 9) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                location.href = "../";
                            }, 1500);
                        }
                    }
                });
            }
        });
    }

    function TimeOut() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        let exam_head_id = $('#exam_head_id').val();
        $(".loader-wrapper111").fadeIn("slow");
        $("#send_exam").attr('data-kt-indicator', 'on');
        $("#send_exam").attr('disabled', true);

        $.ajax({
            type: "POST",
            url: "ajax/exam/SendExam.php",
            data: {
                exam_head_id: exam_head_id,
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                $(".loader-wrapper111").fadeOut("slow");
                $("#send_exam").removeAttr('data-kt-indicator');
                $("#send_exam").attr('disabled', false);

                if (response.result == 1) {
                    location.href = "exam_result.php?id=" + exam_head_id;
                } else if (response.result == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อสอบเกิดข้อผิดพลาด กรุณาติดต่อแอดมิน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (response.result == 8) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบหลักสูตร',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                } else if (response.result == 9) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = "../";
                    }, 1500);
                }
            }
        });
    }
</script>