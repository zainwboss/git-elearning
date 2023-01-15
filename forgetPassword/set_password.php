<?php
session_start();
include("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$status = mysqli_real_escape_string($connection, $_POST['status']);
$serial_id = mysqli_real_escape_string($connection, $_POST['serial_id']);

$sql_serial = "SELECT * FROM tbl_forget_password WHERE serial_id = '$serial_id'";
$rs_serial = mysqli_query($connection, $sql_serial) or die($connection->error);
$row_serial = mysqli_fetch_array($rs_serial);

$datenow = date('Y-m-d H:i:s');
$expire_datetime = date('Y-m-d H:i:s', strtotime($row_serial['expire_datetime']));

if ($datenow <= $expire_datetime) {

    if ($status == '1') {
        $sql = "SELECT * FROM tbl_admin WHERE admin_id = '{$row_serial['ref_id']}'";
    } elseif ($status == '2') {
        $sql = "SELECT * FROM tbl_user WHERE user_id = '{$row_serial['ref_id']}'";
    }
    $rs = mysqli_query($connection, $sql) or die($connection->error);

    if ($rs->num_rows > 0) {

        if ($status == '1') {
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
                    ,change_password_status = '1' 
                WHERE admin_id = '{$row_serial['ref_id']}'";
        } elseif ($status == '2') {
            $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);
            $password = md5($confirm_password);
            $sql = "UPDATE tbl_user SET password = '$password' ,change_password_status = '1' WHERE user_id = '{$row_serial['ref_id']}'";
        }
        $rs = mysqli_query($connection, $sql) or die($connection->error);

        if ($rs) {
            $sql_log = "UPDATE tbl_forget_password SET used_datetime = '$datenow' WHERE serial_id = '$serial_id'";
            $rs_log = mysqli_query($connection, $sql_log) or die($connection->error);

            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }
} else {
    $arr['result'] = 2; //ลิงค์หมดอายุแล้ว
}
echo json_encode($arr);
mysqli_close($connection);
