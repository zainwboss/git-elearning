<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$phone = mysqli_real_escape_string($connection, $_POST['phone']);
$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
$user_code = mysqli_real_escape_string($connection, $_POST['user_code']);
$department = mysqli_real_escape_string($connection, $_POST['department']);
$position = mysqli_real_escape_string($connection, $_POST['position']);
$password = md5($phone);

$condition = "";
if (!empty($_POST['birthdate'])) {
    $birthdate = date('Y-m-d', strtotime(str_replace("/", "-", $_POST['birthdate'])));
    $condition = ",birthdate='$birthdate'";
}

//เช็ค user ไม่ให้ซ้ำ
$sql_chk = "SELECT count(email) as chk_email FROM tbl_user WHERE email = '$email'AND user_id != '$user_id'";
$rs_chk = mysqli_query($connection, $sql_chk) or die($connection->error);
$row_chk = mysqli_fetch_array($rs_chk);

if ($row_chk['username'] > 0) {
    $arr['result'] = 2;
} else {

    $sql_chk_pass = "SELECT change_password_status FROM tbl_user WHERE user_id = '$user_id'";
    $rs_chk_pass = mysqli_query($connection, $sql_chk_pass) or die($connection->error);
    $row_chk_pass = mysqli_fetch_array($rs_chk_pass);
    if ($row_chk_pass['change_password_status'] == 0) {
        $condition .= ",password = '$password'";
    }

    $sql = "UPDATE tbl_user SET 
                 user_code = '$user_code' 
                ,email = '$email'
                ,fullname = '$fullname'  
                ,phone = '$phone' 
                ,department = '$department'
                ,position = '$position' 
                $condition
        WHERE user_id = '$user_id'";
    $rs = mysqli_query($connection, $sql);

    //user_group
    $sql_delete = "DELETE FROM tbl_user_group WHERE user_id ='$user_id'";
    mysqli_query($connection, $sql_delete) or die($connection->error);

    foreach ($_POST['user_group'] as $key => $group_id) {
        $sql_group = "INSERT INTO tbl_user_group SET user_id = '$user_id',group_id = '$group_id' ";
        $rs_group = mysqli_query($connection, $sql_group) or die($connection->error);
    }

    if ($_FILES['profile_image'] != "") {
        $file = explode(".", $_FILES['profile_image']['name']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];
        $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], "../../../../images/" . $filename_images)) {

                $sql1 = "SELECT profile_image FROM tbl_user WHERE user_id='$user_id'";
                $rs1 = mysqli_query($connection, $sql1);
                $row1 = mysqli_fetch_array($rs1);
                unlink('../../../../images/' . $row1['profile_image']);

                $sql = "UPDATE tbl_user SET profile_image = '$filename_images' WHERE user_id='$user_id'";
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
