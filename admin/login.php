<?php
session_start();
require("../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if ($connection) {

	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	$sql_chk = "SELECT * FROM tbl_admin WHERE email = '$email'";
	$rs_chk = mysqli_query($connection, $sql_chk);
	$chk_admin = mysqli_num_rows($rs_chk);

	if ($chk_admin == 1) {

		$row_chk = mysqli_fetch_array($rs_chk);

		if ($row_chk['active_status'] == 1) {

			$mb_password = md5($password);
			$secure_text = $row_chk['secure_text'];
			$secure_point = $row_chk['secure_point'];
			$secure_password = substr_replace($mb_password, $secure_text, $secure_point, 0);
			$myPassword = md5($secure_password);

			$sql = "SELECT * FROM tbl_admin WHERE email = '$email' AND password = '$myPassword'";
			$rs = mysqli_query($connection, $sql) or die($connection->error);

			if ($rs->num_rows > 0) {
				$row = mysqli_fetch_array($rs);

				$_SESSION['admin_id'] = $row['admin_id'];
				
				$arr['admin_status'] = $row['admin_status'];
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
