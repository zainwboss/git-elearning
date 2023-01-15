<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$sql = "SELECT a.* ,b.course_code FROM tbl_course_document a
        JOIN tbl_course b ON a.course_id = b.course_id  
        WHERE a.course_id ='$course_id' ORDER BY a.list_order ASC";
$rs  = mysqli_query($connection, $sql);

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs_admin = mysqli_query($connection, $sql_admin);
$row_admin = mysqli_fetch_array($rs_admin);
?>

<div class="row g-6 g-xl-9 mb-6 mb-xl-9">
    <?php
    $i = 0;
    while ($row = mysqli_fetch_array($rs)) {
        if ($row['doc_path'] != '') {
            if ($row['doc_type'] == '1') {
                $path = "../../template/assets/media/svg/files2/pdf.svg";
            } else if ($row['doc_type'] == '2') {
                $path = "../../template/assets/media/svg/files2/image.svg";
            } else if ($row['doc_type'] == '3') {
                $path = "../../template/assets/media/svg/files2/word.svg";
            } else if ($row['doc_type'] == '4') {
                $path = "../../template/assets/media/svg/files2/excel.svg";
            } else if ($row['doc_type'] == '5') {
                $path = "../../template/assets/media/svg/files2/power_point.svg";
            } else if ($row['doc_type'] == '6') {
                $path = "../../template/assets/media/svg/files2/link.svg";
            }
        } else {
            $path = "../../template/assets/media/svg/files/blank-image.svg";
        }

        $filename = "[" . $row['course_code'] . "]" . $row['doc_path'];
    ?>
        <div class="col-md-6 col-lg-4 col-xl-3" id="doc_<?php echo $row['doc_id'] ?>">
            <div class="card h-100">
                <div class="card-header ribbon ribbon-top ribbon-vertical">
                    <?php if ($row_admin['admin_status'] != '2') { ?>
                        <div class="ribbon-label bg-danger" style="cursor:pointer" onclick="Delete('<?php echo $row['doc_id'] ?>');">
                            <span class="svg-icon  svg-icon-2x svg-icon-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    <?php } ?>
                    <div class="card-title w-100"><?php echo $row['doc_description'] ?></div>
                </div>
                <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                    <a href="<?php echo ($row['doc_type'] == '6') ? $row['doc_path'] : '../../images/' . $row['doc_path'] ?>" download="<?= $filename ?>" target="_blank" class="text-gray-800 text-hover-primary d-flex flex-column">
                        <div class="symbol symbol-60px mb-5">
                            <img src="<?php echo $path ?>" alt="" />
                        </div>
                        <!-- <div class="fs-5 fw-bolder mb-2"><?php //cho $row['doc_description'] 
                                                                ?></div> -->
                    </a>
                    <div class="fs-7 fw-bold text-gray-400"><?php echo date('d/m/Y | H:i:s', strtotime($row['create_datetime'])) ?></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php mysqli_close($connection); ?>