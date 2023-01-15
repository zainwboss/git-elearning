<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$admin_id = mysqli_real_escape_string($connection, $_POST['admin_id']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$phone = mysqli_real_escape_string($connection, $_POST['phone']);
$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
$admin_status = mysqli_real_escape_string($connection, $_POST['admin_status']);

$password = md5($phone);
$secure_text = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5);
$secure_point = substr(str_shuffle('123456789'), 0, 1);
$secure = substr_replace($password, $secure_text, $secure_point, 0);
$password = md5($secure);

//เช็ค user ไม่ให้ซ้ำ
$sql_chk = "SELECT count(email) as email FROM tbl_admin WHERE email = '$email'";
$rs_chk = mysqli_query($connection, $sql_chk) or die($connection->error);
$row_chk = mysqli_fetch_array($rs_chk);

if ($row_chk['email'] > 0) {
    $arr['result'] = 2;
} else {
    $sql = "INSERT INTO tbl_admin SET 
                admin_id = '$admin_id' 
                ,email = '$email' 
                ,password = '$password' 
                ,phone = '$phone' 
                ,fullname = '$fullname'  
                ,secure_text = '$secure_text'  
                ,secure_point = '$secure_point' 
                ,admin_status = '$admin_status' 
        ";
    $rs = mysqli_query($connection, $sql);

    if ($_FILES['profile_image'] != "") {
        $file = explode(".", $_FILES['profile_image']['name']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];
        $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], "../../../../images/" . $filename_images)) {
                $sql = "UPDATE tbl_admin SET profile_image = '$filename_images' WHERE admin_id='$admin_id'";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
            }
        }
    }

    if ($rs) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
}
echo json_encode($arr);
mysqli_close($connection);
