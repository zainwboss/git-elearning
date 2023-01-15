<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

if ($_FILES['certificate_image'] != "") {
    $file = explode(".", $_FILES['certificate_image']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
        if (move_uploaded_file($_FILES['certificate_image']['tmp_name'], "../../../../images/" . $filename_images)) {

            $sql1 = "SELECT certificate_image FROM tbl_course WHERE course_id='$course_id'";
            $rs1 = mysqli_query($connection, $sql1);
            $row1 = mysqli_fetch_array($rs1);
            unlink('../../../../images/' . $row1['certificate_image']);

            $sql = "UPDATE tbl_course SET certificate_image = '$filename_images' WHERE course_id='$course_id'";
            $rs = mysqli_query($connection, $sql) or die($connection->error);

            if ($rs) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }
        }
    }
}

echo json_encode($arr);
mysqli_close($connection);
