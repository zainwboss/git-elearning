<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$cs_id = mysqli_real_escape_string($connection, $_POST['cs_id']);
$setting_type = mysqli_real_escape_string($connection, $_POST['setting_type']);
$pointer_x = mysqli_real_escape_string($connection, ($_POST['pointer_x'] == '') ? 0 : $_POST['pointer_x']);
$pointer_y = mysqli_real_escape_string($connection, ($_POST['pointer_y'] == '') ? 0 : $_POST['pointer_y']);
$width = mysqli_real_escape_string($connection, ($_POST['width'] == '') ? 0 : $_POST['width']);
$height = mysqli_real_escape_string($connection, ($_POST['height'] == '') ? 0 : $_POST['height']);

$setting_text = mysqli_real_escape_string($connection, $_POST['setting_text']);
$text_position = mysqli_real_escape_string($connection, $_POST['text_position']);
$text_font = mysqli_real_escape_string($connection, $_POST['text_font']);
$text_size = mysqli_real_escape_string($connection, ($_POST['text_size'] == '') ? 0 : $_POST['text_size']);

$condition = "";
if ($setting_type == '2') {
    $sql_img = "SELECT * FROM tbl_course_cer_setting WHERE cs_id ='$cs_id' ";
    $rs_img = mysqli_query($connection, $sql_img) or die($connection->error);
    $row_img = mysqli_fetch_array($rs_img);

    $file = "../../../../images/" . $row_img['image_file'];
    unlink($file);

    $condition = ",image_file=NULL,setting_text = '$setting_text',text_position = '$text_position',text_font = '$text_font',text_size = '$text_size'";
}

$sql = "UPDATE tbl_course_cer_setting SET 
                 setting_type = '$setting_type' 
                ,pointer_x = '$pointer_x' 
                ,pointer_y = '$pointer_y'  
                ,width = '$width'  
                ,height = '$height' 
                $condition
        WHERE cs_id='$cs_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);

if ($rs) {
    if ($setting_type == '1') {
        if ($_FILES['image_file'] != "") {
            $file = explode(".", $_FILES['image_file']['name']); //แยกชื่อกับนามสกุลไฟล์
            $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
            $file_surname = $file[$count];
            $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
            if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
                if (move_uploaded_file($_FILES['image_file']['tmp_name'], "../../../../images/" . $filename_images)) {

                    $sql1 = "SELECT image_file FROM tbl_course_cer_setting WHERE cs_id='$cs_id'";
                    $rs1 = mysqli_query($connection, $sql1);
                    $row1 = mysqli_fetch_array($rs1);
                    unlink('../../../../images/' . $row1['image_file']);

                    $sql = "UPDATE tbl_course_cer_setting SET image_file = '$filename_images',setting_text = NULL,text_position = NULL,text_font = NULL,text_size = NULL WHERE cs_id='$cs_id'";
                    $rs = mysqli_query($connection, $sql) or die($connection->error);
                }
            }
        }
    }

    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
