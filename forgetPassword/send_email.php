<?
require("../PHPMailer/class.phpmailer.php");
include('../config/main_function.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$sql_setting = "SELECT * FROM tbl_setting WHERE setting_id ='1'";
$rs_setting  = mysqli_query($connection, $sql_setting) or die($connection->error);
$row_setting = mysqli_fetch_array($rs_setting);

$status = mysqli_real_escape_string($connection, $_POST['status']);
$email = mysqli_real_escape_string($connection, $_POST['email']);

if ($status == '1') {
	$sql = "SELECT fullname,admin_id AS ref_id FROM tbl_admin WHERE email = '$email' AND active_status = '1'";
} elseif ($status == '2') {
	$sql = "SELECT fullname,user_id AS ref_id FROM tbl_user WHERE email = '$email' AND active_status = '1'";
}
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

if ($rs->num_rows > 0) {

	$serial_id = getRandomID(10, 'tbl_forget_password', 'serial_id');
	$expire_datetime = date('Y-m-d H:i:s', strtotime('+10 minutes'));
	$sql_insert_log = "INSERT INTO tbl_forget_password SET
							 serial_id = '$serial_id'
							,status = '$status'
							,ref_id = '{$row['ref_id']}'
							,expire_datetime = '$expire_datetime'";

	$rs_insert_log = mysqli_query($connection, $sql_insert_log) or die($connection->error);

	$mail = new PHPMailer();

	$mail_txt = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
						<tbody>
							<tr>
								<td align="center" valign="center" style="text-align:center; padding: 40px">
										<img src="../images/' . $row_setting['logo_image'] . '" style="height:120px;" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="center">
									<div style="text-align:left; margin-bottom: 70px; padding: 40px; background-color:#ffffff; border-radius: 6px">
										<div style="padding-bottom: 30px; font-size: 17px;">
											<strong>สวัสดี คุณ ' . $row['fullname'] . ' !</strong>
										</div>
										<div style="padding-bottom: 30px">คุณได้รับอีเมลนี้ เนื่องจากเราได้รับคำขอรีเซ็ตรหัสผ่านสำหรับบัญชีของคุณ โปรดคลิกที่ลิงก์ด้านล่างเพื่อดำเนินการกำหนดรหัสผ่านใหม่ต่อไป</div>
										<div style="padding-bottom: 30px">ลิงก์รีเซ็ทรหัสผ่านนี้จะหมดอายุใน 10 นาที หากคุณไม่ได้ร้องขอการรีเซ็ตรหัสผ่าน กรุณาติดต่อผู้เกี่ยวข้อง</div>
										<div style="border-bottom: 1px solid #eeeeee; margin: 15px 0"></div>
										<div style="padding-bottom: 50px; word-wrap: break-all;">
											<p style="margin-bottom: 10px;">ลิงก์กำหนดรหัสผ่านใหม่ :</p>
											<a href="https://bigsara-service.com/elearning/forgetPassword/new_password.php?status=' . $status . '&id=' . $serial_id . '" rel="noopener" target="_blank" style="text-decoration:none;color: #009EF7">https://bigsara-service.com/elearning/forgetPassword/new_password.php?status=' . $status . '&id=' . $serial_id . '</a>
										</div>
										<div style="padding-bottom: 10px">ขอแสดงความนับถือ ทีมงาน Albatross Cybersec</div>
									</div>
								</td>
							</tr>
						</tbody>
				    </table>
				</div>';

	$body = $mail_txt;

	$mail->CharSet = "utf-8";
	$mail->IsHTML(true);
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->Debugoutput = 'html';
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com"; // SMTP server
	$mail->Port = 465; // พอร์ท
	$mail->Username = "anankarnkit@gmail.com"; // account SMTP
	$mail->Password = "nzqluaarvgsjdnqn"; // รหัสผ่าน SMTP
	$mail->SMTPAuth = true;

	$mail->SetFrom("albatrosscybersec@gmail.com", "Albatross Cybersec");
	$mail->Subject = "ตั้งค่ารหัสผ่านใหม่";
	$mail->MsgHTML($body);
	$mail->AddAddress($email, "email");
	$mail->Send();

	$arr['result'] = 1;
} else {
	$arr['result'] = 0;
}
echo json_encode($arr);
