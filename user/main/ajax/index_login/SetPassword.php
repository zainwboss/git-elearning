<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);
    $password = md5($confirm_password);

    $sql = "UPDATE tbl_user SET password = '$password' ,change_password_status = '1' WHERE user_id = '$user_id'";
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
