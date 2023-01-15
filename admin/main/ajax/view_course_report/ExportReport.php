<?php
session_start();
include("../../../../PHPExcel-1.8/Classes/PHPExcel.php");
include('../../../../config/main_function.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

$filter_status = mysqli_real_escape_string($connection, $_POST['filter_status']);
$filter_date = mysqli_real_escape_string($connection, $_POST['filter_date']);
$filter_type = mysqli_real_escape_string($connection, $_POST['filter_type']);

$condition = "";
if ($filter_status == '1') {
    if (!empty($filter_date)) {
        $startDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[0])));
        $endDate = date('Y-m-d', strtotime(str_replace("/", "-", explode('-', $filter_date)[1])));

        $condition .= "AND (DATE(a.start_datetime) BETWEEN '$startDate' AND '$endDate')";
    }
}

if ($filter_type == 'pre') {
    $condition .= "AND a.exam_count ='1' ";
} else if ($filter_type == 'post') {
    $condition .= "AND a.exam_count !='1' ";
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


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell_head, 'รายงานข้อมูลการสอบ ดึงรายงาน ณ วันที่ ' . date("d/m/Y"));
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell_head . ':' . $columnCharacter[6] . ($rowCell_head));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ลำดับที่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ชื่อ-นามสกุล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(18);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ประเภท');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'วัน/เวลาที่เริ่มทำ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'วัน/เวลาที่ทำเสร็จ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ระยะเวลา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'คะแนน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(16);

/* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ระยะเวลาการเรียน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'สถานะ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(16); */

/* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ยอดรวม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16); */





/* $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[3] . ($rowCell))->applyFromArray($styleHeader); */

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[6] . ($rowCell_head))->applyFromArray($styleHeader2);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '2:' . $columnCharacter[6] . ($rowCell))->applyFromArray($styleHeader);



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



$sql = "SELECT a.*,b.fullname,b.profile_image FROM tbl_exam_head a 
                    JOIN tbl_user b ON a.user_id = b.user_id
                    WHERE a.course_id ='$course_id' AND a.finish_datetime IS NOT NULL $condition ORDER BY a.start_datetime DESC";
$rs = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_array($rs)) {
    $i++;
    $list_type = "";
    if ($row['exam_count'] == 1) {
        $list_type = 'ข้อสอบก่อนเรียน';
    } else {
        $list_type = 'ข้อสอบหลังเรียนครั้งที่ ' . ($row['exam_count'] - 1);
    }

    $sql_ea = "SELECT * FROM tbl_exam_answer WHERE exam_head_id='{$row['exam_head_id']}' ";
    $rs_ea  = mysqli_query($connection, $sql_ea) or die($connection->error);

    //เปอร์เซ็นต์ที่ทำได้ 
    $exam_percent = ($row['correct_amount'] / $rs_ea->num_rows) * 100;


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $i);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $list_type);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, date('d/m/Y', strtotime($row['start_datetime'])) . date('H:i:s', strtotime($row["start_datetime"])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, date('d/m/Y', strtotime($row['finish_datetime'])) . "\n" . date('H:i:s', strtotime($row['finish_datetime'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, round(abs(strtotime($row['finish_datetime']) - strtotime($row['start_datetime'])) / 60) . ' นาที');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['correct_amount'] . '/' .  $rs_ea->num_rows . "\n" . '(' . number_format($exam_percent, 2) . '%)');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

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
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '3:' . $columnCharacter[0] . ($rowCell))->applyFromArray($styleTextCenter);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . '3:' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleText);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . '3:' . $columnCharacter[6] . ($rowCell))->applyFromArray($styleTextCenter);



    $rowCell++; //Loop

}



/* $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, number_format($total_amount));
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[5] . '3:' . $columnCharacter[5] . ($rowCell))->applyFromArray($styleNumber); */





/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "course_view_report-" . date("d-m-Y");
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
