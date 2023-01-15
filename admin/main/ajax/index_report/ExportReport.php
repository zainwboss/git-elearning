<?php
session_start();
include("../../../../PHPExcel-1.8/Classes/PHPExcel.php");
include('../../../../config/main_function.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$filter_date = mysqli_real_escape_string($connection, $_POST['filter_date']);
$now = date('Y-m-d');
$condition = "";
if (!empty($filter_date)) {
    $startDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[0])));
    $endDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[1])));
    $condition = "AND (CASE WHEN a.course_finish_date IS NOT NULL 
                            THEN DATE(a.course_finish_date) >= '$now' AND DATE(a.course_start_date) <='$endDate' 
                            ELSE DATE(a.course_start_date) <='$endDate' 
                       END)";
}

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
        'size'  => 12,
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
// หัวตาราง


$rowCell = 1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'รายงานข้อมูลการสอบ ดึงรายงาน ณ วันที่ ' . date("d/m/Y"));
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' .  $columnCharacter[10] . $rowCell)->applyFromArray($styleHeader2);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

$rowCell = 2;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ชื่อหลักสูตร');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(60);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ก่อนเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'หลังเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . ($rowCell + 1), 'คะแนนต่ำสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . ($rowCell + 1) . ':' . $columnCharacter[1] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . ($rowCell + 1), 'คะแนนเฉลี่ย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . ($rowCell + 1) . ':' . $columnCharacter[2] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . ($rowCell + 1), 'คะแนนสูงสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . ($rowCell + 1) . ':' . $columnCharacter[3] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . ($rowCell + 1), 'รายชื่อพนักงานที่ได้คะแนนสูงสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . ($rowCell + 1) . ':' . $columnCharacter[4] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . ($rowCell + 1), 'คะแนนต่ำสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . ($rowCell + 1) . ':' . $columnCharacter[5] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . ($rowCell + 1), 'คะแนนเฉลี่ย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . ($rowCell + 1) . ':' . $columnCharacter[6] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . ($rowCell + 1), 'คะแนนสูงสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . ($rowCell + 1) . ':' . $columnCharacter[7] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . ($rowCell + 1), 'รายชื่อพนักงานที่ได้คะแนนสูงสุด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . ($rowCell + 1) . ':' . $columnCharacter[8] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . ($rowCell + 1), 'เวลาเฉลี่ยการเรียนจบหลักสูตร (นาที)');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . ($rowCell + 1) . ':' . $columnCharacter[9] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(35);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . ($rowCell + 1), 'จำนวนครั้งของการสอบหลังเรียนจนสอบผ่าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . ($rowCell + 1) . ':' . $columnCharacter[10] . ($rowCell + 1));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(40);

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' .  $columnCharacter[10] . ($rowCell + 1))->applyFromArray($styleHeader);

// เนื้อหาตาราง
$rowCell = 4;

$sql = "SELECT a.* FROM tbl_course a WHERE 1 $condition ORDER BY a.course_name ASC";
$rs = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_array($rs)) {
    $course_id = $row['course_id'];

    // ค่าเฉลี่ยคะแนนสอบก่อนเรียน
    $sql_pre = "SELECT IFNULL(MAX(a.correct_amount),0) AS max_pre,IFNULL(MIN(a.correct_amount),0) AS min_pre,IFNULL(AVG(a.correct_amount),0) AS avg_pre,b.fullname
                 FROM tbl_exam_head a
                 JOIN tbl_user b ON a.user_id = b.user_id
                 WHERE a.exam_count='1' AND a.finish_datetime IS NOT NULL AND a.course_id='$course_id'";
    $rs_pre   = mysqli_query($connection, $sql_pre) or die($connection->error);
    $row_pre  = mysqli_fetch_array($rs_pre);

    // ค่าเฉลี่ยคะแนนสอบหลังเรียน
    $sql_post = "SELECT  IFNULL(MAX(a.correct_amount),0) AS max_post,IFNULL(MIN(a.correct_amount),0) AS min_post,IFNULL(AVG(a.correct_amount),0) AS avg_post,b.fullname 
                 FROM tbl_exam_head a
                 JOIN tbl_user b ON a.user_id = b.user_id
                 WHERE a.exam_count !='1' AND a.finish_datetime IS NOT NULL AND a.course_id='$course_id'";
    $rs_post   = mysqli_query($connection, $sql_post) or die($connection->error);
    $row_post  = mysqli_fetch_array($rs_post);

    // เวลาเฉลี่ยการเรียนจบหลักสูตร
    $sql_cr = "SELECT IFNULL(AVG(study_time),0) AS avg_finish FROM tbl_course_register WHERE finish_datetime IS NOT NULL AND course_id='$course_id'";
    $rs_cr   = mysqli_query($connection, $sql_cr) or die($connection->error);
    $row_cr  = mysqli_fetch_array($rs_cr);

    $sql_exam = "SELECT COUNT(*) AS count_exam FROM tbl_exam_head WHERE finish_datetime IS NOT NULL AND course_id='$course_id' AND pass_status ='0'";
    $rs_exam   = mysqli_query($connection, $sql_exam) or die($connection->error);
    $row_exam  = mysqli_fetch_array($rs_exam);


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['course_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell))->applyFromArray($styleText);

    //ก่อนเรียน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row_pre['min_pre']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, number_format($row_pre['avg_pre'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row_pre['max_pre']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, ($row_pre['fullname'] != '') ? $row_pre['fullname'] : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell))->applyFromArray($styleTextCenter);

    //หลังเรียน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row_post['min_post']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, number_format($row_post['avg_post'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row_post['max_post']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, ($row_post['fullname'] != '') ? $row_post['fullname'] : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, number_format($row_cr['avg_finish']));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell))->applyFromArray($styleTextCenter);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, number_format($row_exam['count_exam']));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell))->applyFromArray($styleTextCenter);

    $rowCell++;
}
//เปอร์เซ็นต์ที่ทำได้ 
// $exam_percent = ($row['correct_amount'] / $rs_ea->num_rows) * 100;


// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $i);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));


// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['fullname']);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));


// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $list_type);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));


// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, date('d/m/Y', strtotime($row['start_datetime'])) . date('H:i:s', strtotime($row["start_datetime"])));
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, date('d/m/Y', strtotime($row['finish_datetime'])) . "\n" . date('H:i:s', strtotime($row['finish_datetime'])));
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, round(abs(strtotime($row['finish_datetime']) - strtotime($row['start_datetime'])) / 60) . ' นาที');
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['correct_amount'] . '/' .  $rs_ea->num_rows . "\n" . '(' . number_format($exam_percent, 2) . '%)');
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

/*     $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, ($rs_cr->num_rows > 0) ? date('H:i:s', mktime(0, 0, $row_cr['study_time'])) : '-');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $status);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell)); */

/*   PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT); */

/*   foreach (range('A', 'B') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
    } */

/* $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '2:' . $columnCharacter[3] . ($rowCell))->applyFromArray($styleText); */
// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '3:' . $columnCharacter[0] . ($rowCell))->applyFromArray($styleTextCenter);
// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . '3:' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleText);
// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . '3:' . $columnCharacter[6] . ($rowCell))->applyFromArray($styleTextCenter);

/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "report-" . date("d-m-Y");

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
