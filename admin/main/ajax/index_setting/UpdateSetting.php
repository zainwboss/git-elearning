<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$title = mysqli_real_escape_string($connection, $_POST['title']);

if ($_FILES['logo_image'] != "") {
    $file = explode(".", $_FILES['logo_image']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
        if (move_uploaded_file($_FILES['logo_image']['tmp_name'], "../../../../images/" . $filename_images)) {
            $sql1 = "SELECT logo_image FROM tbl_setting WHERE setting_id ='1'";
            $rs1 = mysqli_query($connection, $sql1);
            $row1 = mysqli_fetch_array($rs1);
            unlink('../../../../images/' . $row1['logo_image']);

            $sql2 = "UPDATE tbl_setting SET logo_image = '$filename_images' WHERE setting_id ='1'";
            $rs2 = mysqli_query($connection, $sql2) or die($connection->error);
        }
    }
}

if ($_FILES['loading_image'] != "") {
    $file = explode(".", $_FILES['loading_image']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('svg', 'SVG'))) {
        if (move_uploaded_file($_FILES['loading_image']['tmp_name'], "../../../../images/" . $filename_images)) {
            $sql1 = "SELECT loading_image FROM tbl_setting WHERE setting_id ='1'";
            $rs1 = mysqli_query($connection, $sql1);
            $row1 = mysqli_fetch_array($rs1);
            unlink('../../../../images/' . $row1['loading_image']);

            $sql = "UPDATE tbl_setting SET loading_image = '$filename_images' WHERE setting_id ='1'";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
        }
    }
}

if ($_FILES['favicon'] != "") {
    $file = explode(".", $_FILES['favicon']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('ico', 'ICO'))) {
        if (move_uploaded_file($_FILES['favicon']['tmp_name'], "../../../../images/" . $filename_images)) {
            $sql1 = "SELECT favicon FROM tbl_setting WHERE setting_id ='1'";
            $rs1 = mysqli_query($connection, $sql1);
            $row1 = mysqli_fetch_array($rs1);
            unlink('../../../../images/' . $row1['favicon']);

            $sql = "UPDATE tbl_setting SET favicon = '$filename_images' WHERE setting_id ='1'";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
        }
    }
}

$sql = "UPDATE tbl_setting SET title ='$title' WHERE setting_id ='1'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
mysqli_close($connection);
