<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$sql_course = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_course  = mysqli_query($connection, $sql_course) or die($connection->error);

if ($rs_course->num_rows > 0) { //เช็คหลักสูตร

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

    $sql = "SELECT MAX(list_order) AS list_order FROM tbl_course_cer_setting WHERE course_id = '$course_id'";
    $rs = mysqli_query($connection, $sql);
    if ($rs->num_rows > 0) {
        $row = mysqli_fetch_assoc($rs);
        $list_order = $row['list_order'] + 1;
    } else {
        $list_order = 0;
    }

    $sql = "INSERT INTO tbl_course_cer_setting SET 
                 cs_id = '$cs_id' 
                ,course_id = '$course_id' 
                ,setting_type = '$setting_type' 
                ,pointer_x = '$pointer_x' 
                ,pointer_y = '$pointer_y'  
                ,width = '$width'  
                ,height = '$height' 
                ,list_order = '$list_order' 
        ";
    $rs = mysqli_query($connection, $sql);

    if ($rs) {

        if ($setting_type == '1') {
            if ($_FILES['image_file'] != "") {
                $file = explode(".", $_FILES['image_file']['name']); //แยกชื่อกับนามสกุลไฟล์
                $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
                $file_surname = $file[$count];
                $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
                if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
                    if (move_uploaded_file($_FILES['image_file']['tmp_name'], "../../../../images/" . $filename_images)) {
                        $sql = "UPDATE tbl_course_cer_setting SET image_file = '$filename_images' WHERE cs_id='$cs_id'";
                        $rs = mysqli_query($connection, $sql) or die($connection->error);
                    }
                }
            }
        } elseif ($setting_type == '2') {

            $sql = "UPDATE tbl_course_cer_setting SET 
                     setting_text = '$setting_text' 
                    ,text_position = '$text_position' 
                    ,text_font = '$text_font' 
                    ,text_size = '$text_size' 
                WHERE cs_id='$cs_id'";
            $rs = mysqli_query($connection, $sql);
        }

        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 8;
}
echo json_encode($arr);
mysqli_close($connection);
