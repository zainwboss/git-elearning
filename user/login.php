<?php
session_start();
require("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if ($connection) {

	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	$sql_chk = "SELECT * FROM tbl_user WHERE email = '$email'";
	$rs_chk = mysqli_query($connection, $sql_chk);
	$chk_admin = mysqli_num_rows($rs_chk);

	if ($chk_admin == 1) {

		$row_chk = mysqli_fetch_array($rs_chk);

		if ($row_chk['active_status'] == 1) {

			$myPassword = md5($password);

			$sql = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$myPassword'";
			$rs = mysqli_query($connection, $sql);
			$num = mysqli_num_rows($rs);

			if ($num == 1) {
				$row = mysqli_fetch_array($rs);

				$sql_login_log = "INSERT INTO tbl_login_log SET user_id = '{$row['user_id']}'";
				$rs_login_log = mysqli_query($connection, $sql_login_log) or die($connection->error);

				$_SESSION['user_id'] = $row['user_id'];

				$result = 4; // login สำเร็จ 
			} else {
				$result = 3; //รหัสผ่านไม่ถูกต้อง
			}
		} else {
			$result = 2; // status ไม่ Active
		}
	} else {
		$result = 1; // ไม่พบ admin 
	}
} else {
	$result = 9;
}

$arr['result'] = $result;
echo json_encode($arr);
