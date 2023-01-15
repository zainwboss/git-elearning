<?php
session_start();
require('fpdf/alphapdf.php');
include("../config/main_function.php");

$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = $_GET['id'];
$user_id = $_GET['id2'];

$sql_course = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_course  = mysqli_query($connection, $sql_course) or die($connection->error);
$row_course = mysqli_fetch_array($rs_course);

$sql_cr = "SELECT a.*,b.* FROM tbl_course_register a 
           LEFT JOIN tbl_user b ON a.user_id = b.user_id 
           WHERE a.course_id='$course_id' AND a.user_id='$user_id'";
$rs_cr  = mysqli_query($connection, $sql_cr) or die($connection->error);
$row_cr = mysqli_fetch_array($rs_cr);

//$pdf->Line(145, 25, 190, 25); โค้ดเส้นบรรทัด
//$pdf->Image('check_mark.png', 27.5, 131.5, 5, 5, 'PNG');//ติ๊กถูก -3.3 จากตัวหนังสือ
//$pdf->Image('circle_mark.png', 64, 76, 8, 6, 'PNG');//วงกลม -2.3 จากตัวหนังสือ (สั้น 8 ยาว 14)
//$pdf->Image('wing_mark.png', 50, 71, 5, 7, 'PNG');//สี่เหลี่ยมด้านมน -3.3 จากตัวหนังสือ
//$pdf->Image('scissors_mark.png', 50, 71, 5, 7, 'PNG');//กรรไกร

$pdf = new FPDF();
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

if ($row_course['certificate_type'] == 1) { //แนวนอน
    $pdf->AddPage('L');
} else if ($row_course['certificate_type'] == 2) { //แนวตั้ง
    $pdf->AddPage('P');
}

if (!empty($row_course['certificate_image'])) {

    $file = explode(".", $row_course['certificate_image']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = strtoupper($file[$count]);

    if ($row_course['certificate_type'] == 1) { //แนวนอน
        $pdf->Image('../images/' . $row_course['certificate_image'], 0, 0, 297, 210, $file_surname);
    } else if ($row_course['certificate_type'] == 2) { //แนวตั้ง
        $pdf->Image('../images/' . $row_course['certificate_image'], 0, 0, 210, 297, $file_surname);
    }

    $sql = "SELECT * FROM tbl_course_cer_setting WHERE course_id='$course_id' ORDER BY list_order ASC";
    $rs = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($rs)) {

        $x = $row['pointer_x'];
        $y = $row['pointer_y'];
        $width = $row['width'];
        $height = $row['height'];

        if ($row['setting_type'] == '1') { //ภาพ
            $image_file = ($row['image_file'] != '') ? $row['image_file'] : 'no-image.jpg';

            $file2 = explode(".", $row_course['image_file']); //แยกชื่อกับนามสกุลไฟล์
            $count2 = count($file2) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
            $file_surname2 =  strtoupper($file2[$count2]);

            $pdf->Image('../images/' . $image_file, $x, $y, $width,  $height, $file_surname2);
        } else {
            $setting_text = $row['setting_text'];
            $setting_text = str_replace('&nbsp;', ' ', $row['setting_text']);
            $setting_text = strip_tags($setting_text);
            $setting_text = str_replace('[course_name]', $row_course['course_name'], $setting_text);
            $setting_text = str_replace('[fullname]', $row_cr['fullname'], $setting_text);
            $setting_text = str_replace('[finish_datetime]', date('d/m/Y', strtotime($row_cr['finish_datetime'])), $setting_text);

            $size = $row['text_size'];

            if ($row['text_font'] == 1) {
                $font = 'THSarabunNew';
            } elseif ($row['text_font'] == 2) {
                $font = 'THSarabunNew Bold';
            }

            if ($row['text_position'] == 1) {
                $position = 'L';
            } elseif ($row['text_position'] == 2) {
                $position = 'C';
            } elseif ($row['text_position'] == 3) {
                $position = 'R';
            };

            $pdf->SetFont($font, '', $size);
            $pdf->SetXY($x, $y);
            $pdf->MultiCell($width, $height, iconv('UTF-8', 'cp874',  $setting_text), 0,  $position, 0);
        }
    }
}

$pdf->Output();
