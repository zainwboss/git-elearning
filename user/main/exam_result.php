<?php
include('header.php');

$exam_head_id = $_GET['id'];

$sql_eh = "SELECT a.*,b.* FROM tbl_exam_head a 
           LEFT JOIN tbl_course b ON a.course_id = b.course_id 
           WHERE a.exam_head_id ='$exam_head_id'";
$rs_eh = mysqli_query($connection, $sql_eh) or die($connection->error);
$row_eh = mysqli_fetch_array($rs_eh);

$sql_ans = "SELECT * FROM tbl_exam_answer WHERE exam_head_id='$exam_head_id'";
$rs_ans  = mysqli_query($connection, $sql_ans) or die($connection->error);

$exam_percent = ($row_eh['correct_amount'] / $rs_ans->num_rows) * 100;
$url = "../../template/assets/media/svg/files/blank-image.svg";
if ($exam_percent >= $row_eh["pass_percent"]) {
    $url = "../../template/congratulations.jpg";
} else {
    $url = "../../template/condolence.jpg";
}
?>
<?php
$sql_eh2 = "SELECT * FROM tbl_exam_head WHERE exam_head_id ='$exam_head_id' AND user_id = '{$_SESSION['user_id']}'";
$rs_eh2 = mysqli_query($connection, $sql_eh2) or die($connection->error);
if ($rs_eh2->num_rows > 0) {
?>
    <div class="content d-flex flex-column flex-column-fluid bg-white" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo $row_eh['course_name'] ?></h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index_course.php">รายการหลักสูตร</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">ผลข้อสอบ</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="d-flex flex-column flex-root">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div class="d-flex flex-column flex-column-fluid text-center p-5">
                            <div class="pt-lg-5 mb-5">
                                <h1 class="fw-bolder fs-3qx mb-7 <?php echo ($row_eh['pass_status'] == 1) ? 'text-success' : 'text-danger' ?>"><?php echo ($row_eh['pass_status'] == 1) ? 'ยินดีด้วย!! คุณทำข้อสอบผ่านแล้ว' : 'ไม่ผ่าน!! พยายามอีกนิด' ?></h1>
                                <div class="fw-bolder fs-2qx text-gray-800"><?php echo $row_eh['correct_amount'] . ' / ' . $rs_ans->num_rows ?>
                                    <br /><?php echo '(' . number_format($exam_percent, 2) . '%)' ?>
                                </div>
                            </div>
                            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-350px min-h-lg-450px" style="background-image: url('<?php echo $url; ?>')"></div>
                        </div>

                        <div class="d-flex flex-center flex-column-auto p-5">
                            <a href="view_user_course.php?id=<?php echo $row_eh['course_id'] ?>" class="btn btn-lg btn-primary fw-bolder">กลับหน้าหลักสูตร</a>
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
        alert("ไม่พบข้อมูล");
        location.href = "../";
    </script>
<?php } ?>
<?php include('footer.php') ?>