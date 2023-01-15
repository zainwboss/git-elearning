<?php
include('header.php');
$course_id = $_GET['id'];
$user_id = $_GET['id2'];

$sql = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

?>
<?php
$sql2 = "SELECT * FROM tbl_exam WHERE course_id='$course_id' AND user_id = '{$_SESSION['user_id']}'";
$rs2  = mysqli_query($connection, $sql2) or die($connection->error);
if ($rs2->num_rows > 0) { //เช็คข้อสอบ
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
                        <li class="breadcrumb-item text-dark">เฉลยข้อสอบ</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <div class="d-flex flex-column flex-center p-2 p-lg-4">
                    <input type="hidden" id="previous_status" name="previous_status" value="0">
                    <div id="row_btn_exam"></div>
                    <div id="row_sub_btn_exam" class="w-100"></div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    session_destroy();
?>
    <script>
        alert("ไม่พบข้อมูล");
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
        GetBtnExam();
    });


    function GetBtnExam() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const course_id = urlParams.get('id');
        const user_id = urlParams.get('id2');

        $.ajax({
            type: "POST",
            url: "ajax/exam_answer/GetBtnExam.php",
            data: {
                course_id: course_id,
                user_id: user_id
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
        const course_id = urlParams.get('id');
        const user_id = urlParams.get('id2');

        $.ajax({
            type: "POST",
            url: "ajax/exam_answer/GetSubBtnExam.php",
            data: {
                user_id: user_id,
                course_id: course_id,
                btn_no: btn_no
            },
            dataType: "html",
            success: function(response) {
                setTimeout(() => {
                    $('button[name="btnExam"]').removeClass('active');
                    $('#btnExam' + btn_no).addClass('active');

                    $('#row_sub_btn_exam').html(response);

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
        // ลบคลาส active ทั้งหมด 
        $('button[name="subbtnExam"]').removeClass('active');
        //ปุ่มปัจปัน active สีม่วง 
        $('#subbtnExam_' + exam_id).addClass('active');

        $('[name="detailExam"]').attr('hidden', true);
        $('#detailExam_' + exam_id).attr('hidden', false);

        $('#exam_id').val(exam_id);
    }
</script>