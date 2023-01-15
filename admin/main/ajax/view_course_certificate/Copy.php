<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$copy_course_id = mysqli_real_escape_string($connection, $_POST['copy_course_id']);

$sql_del = "DELETE FROM tbl_course_cer_setting WHERE course_id ='$course_id'";
$rs_del  = mysqli_query($connection, $sql_del) or die($connection->error);
$row_del = mysqli_fetch_array($rs_del);

$i = 0;
$sql_ccs = "SELECT * FROM tbl_course_cer_setting WHERE course_id ='$copy_course_id'";
$rs_ccs  = mysqli_query($connection, $sql_ccs) or die($connection->error);
while ($row_ccs = mysqli_fetch_array($rs_ccs)) {
    $i++;
    $cs_id = getRandomID(10, "tbl_course_cer_setting", "cs_id");

    $sql = "INSERT INTO tbl_course_cer_setting SET 
             cs_id = '$cs_id' 
            ,course_id = '$course_id' 
            ,setting_type = '{$row_ccs['setting_type']}'
            ,pointer_x = '{$row_ccs['pointer_x']}'
            ,pointer_y = '{$row_ccs['pointer_y']}' 
            ,width = '{$row_ccs['width']}'
            ,height = '{$row_ccs['height']}'
            ,setting_text = '{$row_ccs['setting_text']}'
            ,text_position = '{$row_ccs['text_position']}'
            ,text_font = '{$row_ccs['text_font']}'
            ,text_size = '{$row_ccs['text_size']}'
            ,list_order = '{$row_ccs['list_order']}'";
    $rs = mysqli_query($connection, $sql);

    if ($row_ccs['image_file'] != "") {
        $file = explode(".", $row_ccs['image_file']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];
        $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {

            $srcfile = '../../../../images/' . $row_ccs['image_file'];
            $dstfile = '../../../../images/' . $filename_images;

            if (copy($srcfile, $dstfile)) {
                $sql2 = "UPDATE tbl_course_cer_setting SET image_file = '$filename_images' WHERE cs_id='$cs_id'";
                $rs2 = mysqli_query($connection, $sql2) or die($connection->error);
            }
        }
    }
}

$sql_c = "SELECT * FROM tbl_course WHERE course_id ='$copy_course_id'";
$rs_c  = mysqli_query($connection, $sql_c) or die($connection->error);
$row_c = mysqli_fetch_array($rs_c);

$sql_update = "UPDATE tbl_course SET certificate_type = '{$row_c['certificate_type']}' WHERE course_id='$course_id'";
$rs_update = mysqli_query($connection, $sql_update) or die($connection->error);

if ($row_c['certificate_image'] != "") {
    $file = explode(".", $row_c['certificate_image']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {

        $srcfile = '../../../../images/' . $row_c['certificate_image'];
        $dstfile = '../../../../images/' . $filename_images;

        if (copy($srcfile, $dstfile)) {
            $sql2 = "UPDATE tbl_course SET certificate_image = '$filename_images' WHERE course_id='$course_id'";
            $rs2 = mysqli_query($connection, $sql2) or die($connection->error);
        }
    }
}

// if ($rs_update) {
$arr['result'] = 1;
// } else {
//     $arr['result'] = 0;
// }

echo json_encode($arr);
mysqli_close($connection);
