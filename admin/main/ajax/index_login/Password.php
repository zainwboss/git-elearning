<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    $password = md5($confirm_password);
    $secure_text = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5);
    $secure_point = substr(str_shuffle('123456789'), 0, 1);
    $secure = substr_replace($password, $secure_text, $secure_point, 0);
    $password = md5($secure);

    $sql = "UPDATE tbl_admin SET 
             password = '$password' 
            ,secure_text = '$secure_text'
            ,secure_point = '$secure_point' 
            WHERE admin_id = '$admin_id'
    ";
    $rs = mysqli_query($connection, $sql);

    if ($rs) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}
echo json_encode($arr);
mysqli_close($connection);
