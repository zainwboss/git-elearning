<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$teacher_id = mysqli_real_escape_string($connection, $_POST['teacher_id']);

$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$phone = mysqli_real_escape_string($connection, $_POST['phone']);
$facebook = mysqli_real_escape_string($connection, $_POST['facebook']);
$line = mysqli_real_escape_string($connection, $_POST['line']);
$linkedin = mysqli_real_escape_string($connection, $_POST['linkedin']);
$address = mysqli_real_escape_string($connection, $_POST['address']);

$company = mysqli_real_escape_string($connection, $_POST['company']);
$department = mysqli_real_escape_string($connection, $_POST['department']);
$position = mysqli_real_escape_string($connection, $_POST['position']);
$company_address = mysqli_real_escape_string($connection, $_POST['company_address']);

$education_level = mysqli_real_escape_string($connection, $_POST['education_level']);
$field = mysqli_real_escape_string($connection, $_POST['field']);
$experience = mysqli_real_escape_string($connection, $_POST['experience']);
$certificate = mysqli_real_escape_string($connection, $_POST['certificate']);
$skill = mysqli_real_escape_string($connection, $_POST['skill']);

$sql = "INSERT INTO tbl_teacher SET 
                teacher_id = '$teacher_id' 
                ,fullname = '$fullname'  
                ,email = '$email' 
                ,phone = '$phone' 
                ,facebook = '$facebook' 
                ,line = '$line' 
                ,linkedin = '$linkedin' 
                ,address = '$address' 
                ,company = '$company' 
                ,department = '$department' 
                ,position = '$position' 
                ,company_address = '$company_address' 
                ,education_level = '$education_level' 
                ,field = '$field' 
                ,experience = '$experience' 
                ,certificate = '$certificate' 
                ,skill = '$skill' 
        ";
$rs = mysqli_query($connection, $sql);

if ($_FILES['profile_image'] != "") {
    $file = explode(".", $_FILES['profile_image']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], "../../../../images/" . $filename_images)) {
            $sql = "UPDATE tbl_teacher SET profile_image = '$filename_images' WHERE teacher_id='$teacher_id'";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
        }
    }
}

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
mysqli_close($connection);
