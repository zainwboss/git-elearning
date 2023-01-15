<?php
session_start();
include("../../../../PHPExcel-1.8/Classes/PHPExcel.php");
include('../../../../config/main_function.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
$filter_status = mysqli_real_escape_string($connection, $_POST['filter_status']);

$now = date('Y-m-d');
$sql_course = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
$rs_course  = mysqli_query($connection, $sql_course) or die($connection->error);
$row_course = mysqli_fetch_array($rs_course);
// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่
$objPHPExcel = new PHPExcel();

// กำหนดค่าต่างๆ
$objPHPExcel->getProperties()->setCreator("Company Co., Ltd.");
$objPHPExcel->getProperties()->setLastModifiedBy("Company Co., Ltd.");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setDescription("ReportQuery from Company Co., Ltd.");

$sheet = $objPHPExcel->getActiveSheet();
$pageMargins = $sheet->getPageMargins();

// margin is set in inches (0.5cm)
$margin = 0.5 / 2.54;

$pageMargins->setTop($margin);
$pageMargins->setBottom($margin);
$pageMargins->setLeft($margin);
$pageMargins->setRight(0);


$styleHeader = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeader2 = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'bold'  => true,
        'size'  => 16,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleNumber = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_green = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
        'color' => array('rgb' => '21BA21'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_red = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
        'color' => array('rgb' => 'FF0000'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_blue = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
        'color' => array('rgb' => '0000FF'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

// 'color' => array('rgb' => '32CD32'),
$styleTextCenter = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'
);

/*------------------------------------------------------------------------------------------------------------------------------*/
// $i = 0;
// $sql = "SELECT * FROM salary_history a LEFT JOIN tbl_user b ON a.user_id=b.user_id ";
// $rs  = mysqli_query($connection, $sql) or die($connection->error);

// while ($row = $rs->fetch_assoc()) {
//     $i++;




// $rowCell = 2;

// // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ประจำรอบ');
// // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
// // $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);

// // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row1['use_date']);
// // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
// // $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(16);


// // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ถึง');
// // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
// // $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(16);

// // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row1['salary_date']);
// // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
// // $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(16);



// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'เอกสารดาวน์โหลดวันที่');
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
// $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(16);

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $datenow );
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
// $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16);



// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[4] . ($rowCell))->applyFromArray($styleHeader);

// $rowCell++; //Loop

// }

// หัวตาราง
$rowCell_head = 1;
$rowCell = 2;


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell_head, 'รายงานผู้เข้าเรียนหลักสูตร ดึงรายงาน ณ วันที่ ' . date("d/m/Y"));
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell_head . ':' . $columnCharacter[8] . ($rowCell_head));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ลำดับที่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ชื่อ-นามสกุล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'วันที่ลงทะเบียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'คะแนนก่อนเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'คะแนนหลังเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'เปอร์เซนต์');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'จำนวนที่สอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ระยะเวลาการเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'สถานะ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(16);

/* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ยอดรวม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16); */





/* $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[3] . ($rowCell))->applyFromArray($styleHeader); */

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[8] . ($rowCell_head))->applyFromArray($styleHeader2);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '2:' . $columnCharacter[8] . ($rowCell))->applyFromArray($styleHeader);



// เนื้อหาตาราง
$rowCell = 3;
$total_income = 0;
$date_change  = "";
$daily_income = 0;
$salary = 0;
$position_bonus = 0;
$welfare = 0;
$ability = 0;
$total_amount = 0;
$note = "";

$i = 0;

$sql = "SELECT * FROM tbl_user WHERE active_status='1' 
            AND user_id IN(SELECT user_id FROM tbl_user_group WHERE group_id IN(SELECT group_id FROM tbl_course_group WHERE course_id ='$course_id')) 
            ORDER BY fullname ASC";
            $rs  = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_array($rs)) { 

                $user_id = $row['user_id'];
                $sql_cr = "SELECT * FROM tbl_course_register WHERE user_id='$user_id' AND course_id ='$course_id'";
                $rs_cr  = mysqli_query($connection, $sql_cr);
                $row_cr = mysqli_fetch_array($rs_cr);

                // คะแนนสอบก่อนเรียน
                $sql_pre = "SELECT correct_amount,finish_datetime FROM tbl_exam_head 
                            WHERE exam_count='1' AND finish_datetime IS NOT NULL AND course_id='$course_id' AND user_id='$user_id' ";
                $rs_pre   = mysqli_query($connection, $sql_pre) or die($connection->error);
                $row_pre  = mysqli_fetch_array($rs_pre);

                //คะแนนสอบหลังเรียน
                $sql_post = "SELECT COUNT(exam_count) AS exam_amount , MAX(correct_amount) AS correct_amount  FROM tbl_exam_head 
                             WHERE exam_count !='1' AND finish_datetime IS NOT NULL AND course_id='$course_id' AND user_id='$user_id'";
                $rs_post   = mysqli_query($connection, $sql_post) or die($connection->error);
                $row_post  = mysqli_fetch_array($rs_post);

                // เปรียบเทียบคะแนนสอบก่อนเรียนและหลังเรียน
                $percent = 0;
                $pre_correct_amount = $row_pre['correct_amount'];
                $post_correct_amount = $row_post['correct_amount'];
                if ($pre_correct_amount == 0) { //ถ้าสอบครั้งก่อนได้ 0 
                    $percent =  $post_correct_amount * 100;
                } else {
                    $percent = (($post_correct_amount - $pre_correct_amount) / $pre_correct_amount) * 100;
                }

                //สถานะ
                $status = "";
                $status_certificate = 0;
                if ($rs_cr->num_rows > 0) { //มีการลงทะเบียน (เริ่มทำพรีแล้วแต่ไม่รู้ว่าทำเสร็จรึยังเช็คต่อในเงื่อนไขต่อไป)**
                    if ($row_cr['finish_exam_head_id'] != '') { //ทำข้อสอบหลังเรียนผ่านแล้ว
                        $status_certificate = 1;
                        $status = 'ผ่านการอบรม';
                        $chk_status = '4';
                    } else { //ทำข้อสอบหลังเรียนยังไม่ผ่าน
                        if ($row_course['course_finish_date'] >= $now || $row_course['course_finish_date'] == '') { //ยังไม่ผ่านแต่หมดระยะเวลาคอร์สแล้ว
                            if ($row_pre['finish_datetime'] != '') {  //ทำพรีเสร็จแล้ว**
                                $status = 'อยู่ระหว่างอบรม';
                                $chk_status = '3';
                            } else {
                                $status = 'ยังไม่ลงทะเบียน';
                                $chk_status = '1';
                            }
                        } else {
                            $status = 'ไม่ผ่านหลักสูตร';
                            $chk_status = '5';
                        }
                    }
                } else { //ไม่มีการลงทะเบียน (ยังไม่เริ่มทำพรี)
                    if ($row_course['course_finish_date'] >= $now || $row_course['course_finish_date'] == '') { //ไม่มีการลงทะเบียนและหมดระยะเวลาคอร์สแล้ว
                        $status = 'ยังไม่ลงทะเบียน';
                        $chk_status = '1';
                    } else {
                        $status = 'ไม่ผ่านหลักสูตร';
                        $chk_status = '5';
                    }
                }



    if ($filter_status == 'all' || ($filter_status == '2' && ($chk_status == '3' || $chk_status == '4')) || ($filter_status != '2' && $chk_status == $filter_status)) { $i++;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $i);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['fullname']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, ($row_cr['register_datetime'] != '') ? date('d/m/Y', strtotime($row_cr['register_datetime'])) : '-');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, ($row_pre['correct_amount'] != '') ? $row_pre['correct_amount'] : '-');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, ($row_post['correct_amount'] != '') ? $row_post['correct_amount'] : '-');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));


        if ($rs_cr->num_rows > 0 &&  $row_post['exam_amount'] != '0') { //ต้องมีการลงทะเบียนและมีการเริ่มทำหลังเรียนแล้ว
            if ($post_correct_amount > $pre_correct_amount) {
                $per_c = number_format($percent, 2) . ' %';
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $per_c);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
            } else if ($post_correct_amount < $pre_correct_amount) {
                $per_c = number_format($percent, 2) . ' %';
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $per_c);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
            } else {
                $per_c =  "คงที่";
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $per_c);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
            }
        } else {
            $per_c = '-';
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $per_c);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, ($row_post['exam_amount'] != '' && $row_post['exam_amount'] != '0') ? $row_post['exam_amount'] : '-');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, ($rs_cr->num_rows > 0) ? date('H:i:s', mktime(0, 0, $row_cr['study_time'])) : '-');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $status);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

        $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '3:' . $columnCharacter[0] . ($rowCell))->applyFromArray($styleTextCenter);
        $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . '3:' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . '3:' . $columnCharacter[8] . ($rowCell))->applyFromArray($styleTextCenter);

        $rowCell++;
    }


    /* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $i);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, ($row_cr['register_datetime'] != '') ? date('d/m/Y', strtotime($row_cr['register_datetime'])) : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, ($row_pre['correct_amount'] != '') ? $row_pre['correct_amount'] : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, ($row_post['correct_amount'] != '') ? $row_post['correct_amount'] : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell)); */

    /*  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $per_c);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell)); */

    /* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, ($row_post['exam_amount'] != '' && $row_post['exam_amount'] != '0') ? $row_post['exam_amount'] : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell)); */

    /* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, ($rs_cr->num_rows > 0) ? date('H:i:s', mktime(0, 0, $row_cr['study_time'])) : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell)); */

    /* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $status);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell)); */



    /* $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '2:' . $columnCharacter[3] . ($rowCell))->applyFromArray($styleText); */
    //Loop

}



/* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, number_format($total_amount));
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[5] . '3:' . $columnCharacter[5] . ($rowCell))->applyFromArray($styleNumber); */





/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "course_member-" . date("d-m-Y");
//

// Save Excel 2007 file
#echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx');
$objWriter->save('php://output');

exit();
