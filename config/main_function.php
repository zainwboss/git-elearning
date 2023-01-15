<?php
error_reporting(E_ERROR | E_PARSE);

function connectDB($secure)
{

	if ($secure == "-%eA|y).m0%%1A7") {

		$dbhost = "localhost";
		$dbuser = "awareness_elearn";
		$dbpass = "QX0yajewIL";
		$dbname = "awareness_elearn";
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		mysqli_set_charset($connection, "utf8");
		if (!$connection) {
			die("Connection failed: " . mysqli_connect_error());
		} else {

			return $connection;
		}
	} else {

		return false;
	}
}

function url()
{
	if (isset($_SERVER['HTTPS'])) {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	} else {
		$protocol = 'http';
	}
	return $protocol . "://" . $_SERVER['HTTP_HOST'] . "/demo";
}



function checkAdmin($admin_id)
{

	$secure = "-%eA|y).m0%%1A7";
	$connection = connectDB($secure);

	if ($connection) {

		$sql = "SELECT active_status FROM tbl_admin WHERE admin_id = '$admin_id';";
		$rs = mysqli_query($connection, $sql);
		$row = mysqli_fetch_array($rs);

		$sql2 = "SELECT count(*) as count_check FROM tbl_admin WHERE active_status = '" . $row['active_status'] . "';";
		$rs2 = mysqli_query($connection, $sql2);
		$row2 = mysqli_fetch_array($rs2);

		if ($row2['count_check'] > 0) {

			return 1;
		} else {

			return 0;
		}
	} else {

		return 0;
	}
}


function stringInsert($str, $insertstr, $pos)
{
	$str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
	return $str;
}


function recheck_query($r)
{
	$search_array = array(";", "'", chr(34));
	$new_string = str_replace($search_array, "", $r);

	$new_string = str_ireplace("SELECT", "", $new_string);
	$new_string = str_ireplace("INSERT", "", $new_string);
	$new_string = str_ireplace("UPDATE", "", $new_string);
	$new_string = str_ireplace("DELETE", "", $new_string);
	$new_string = str_ireplace("DROP", "", $new_string);
	$new_string = str_ireplace("CREATE", "", $new_string);
	$new_string = str_ireplace("TRUNCATE", "", $new_string);
	$new_string = str_ireplace("TABLE", "", $new_string);

	return $new_string;
}


function check_access($user_id, $access_id)
{
	$secure = "-%eA|y).m0%%1A7";
	$connection = connectDB($secure);

	$sql = "SELECT access_level FROM tbl_user WHERE user_id = '$user_id';";
	$rs = mysqli_query($connection, $sql) or die(mysqli_error());
	$row = mysqli_fetch_array($rs);

	$page_id = $access_id;
	$level = $row['access_level'];

	$access_code = strrev(decbin($level));
	$accessible = substr($access_code, $page_id - 1, 1);


	if ($accessible) {
		return 1;
	} else {
		return 0;
	}

	mysqli_close($connection);
}


function getRandomID($size, $table, $column_name)
{

	$check_status = 0;
	$secure = "-%eA|y).m0%%1A7";
	$connection = connectDB($secure);

	while ($check_status == 0) {
		$random_id = randomCode($size);


		$sql = "SELECT count(*) as count FROM $table WHERE $column_name = '$random_id';";
		$rs_check = mysqli_query($connection, $sql) or die(mysqli_error());
		$row_check = mysqli_fetch_assoc($rs_check);
		$check_repeat = $row_check['count'];

		if ($check_repeat == 0) {

			$check_status = 1;
		}
	}

	return $random_id;
}

function getRandomID2($size, $table, $column_name)
{
	$check_status = 0;
	$secure = "-%eA|y).m0%%1A7";
	$connection = connectDB($secure);

	while ($check_status == 0) {
		$random_id = randomCode2($size);


		$sql = "SELECT count(*) as count FROM $table WHERE $column_name = '$random_id';";
		$rs_check = mysqli_query($connection, $sql) or die(mysqli_error());
		$row_check = mysqli_fetch_assoc($rs_check);
		$check_repeat = $row_check['count'];

		if ($check_repeat == 0) {

			$check_status = 1;
		}
	}


	return $random_id;
}


function randomCode($length)
{
	$possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghigklmnopqrstuvwxyz"; //ตัวอักษรที่ต้องการสุ่ม
	$str = "";
	while (strlen($str) < $length) {
		$str .= substr($possible, (rand() % strlen($possible)), 1);
	}
	return $str;
}


function randomCode2($length)
{
	$possible = "0123456789"; //ตัวอักษรที่ต้องการสุ่ม
	$str = "";
	while (strlen($str) < $length) {
		$str .= substr($possible, (rand() % strlen($possible)), 1);
	}
	return $str;
}


function getBaseUrl()
{
	if (isset($_SERVER['HTTPS'])) {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	} else {
		$protocol = 'http';
	}
	return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

function dateThai($date)
{
	$strYear = date("Y", strtotime($date)) + 543;
	$strMonth = date("m", strtotime($date));
	$strDay = date("d", strtotime($date));
	$strHour = date("H", strtotime($date));
	$strMinute = date("i", strtotime($date));
	$strSeconds = date("s", strtotime($date));
	$thaimonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strthaimounth = $thaimonth[$strMonth - 1];
	return $strDay . " " . $strthaimounth . " " . $strYear;
}

function dateThai2($date)
{
	$strYear = date("Y", strtotime($date)) + 543;
	$strMonth = date("m", strtotime($date));
	$strDay = date("d", strtotime($date));
	$strHour = date("H", strtotime($date));
	$strMinute = date("i", strtotime($date));
	$strSeconds = date("s", strtotime($date));
	$thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$strthaimounth = $thaimonth[$strMonth - 1];
	return $strDay . " " . $strthaimounth . " " . $strYear;
}

function dateEng($date)
{
	$strYear = date("Y", strtotime($date)) + 543;
	$strMonth = date("m", strtotime($date));
	$strDay = date("d", strtotime($date));
	$strHour = date("H", strtotime($date));
	$strMinute = date("i", strtotime($date));
	$strSeconds = date("s", strtotime($date));
	$thaimonth = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	$strthaimounth = $thaimonth[$strMonth - 1];
	return $strDay . " " . $strthaimounth . " " . $strYear;
}

function getData($tbl, $field, $id)
{
	$conn = connectDB('-%eA|y).m0%%1A7');
	$sql = "SELECT * FROM $tbl WHERE $field = '$id'";
	$rs = $conn->query($sql);
	$row = $rs->fetch_assoc();
	return $row;
}
?>
