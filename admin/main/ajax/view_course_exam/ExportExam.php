<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$course_id = mysqli_real_escape_string($connection, $_GET['id']);

require('../../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */
require('../../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

///// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่
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
$styleHeaderLeft = array(
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
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
// 'color' => array('rgb' => '32CD32'),
$styleTextCenter = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    //เส้น
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => PHPExcel_Style_Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'font'  => array(
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$styleTextRIGHT = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'bold'  => true,
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$styleTextLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => PHPExcel_Style_Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'font'  => array(
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ข้อที่');
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[0] . '1')->applyFromArray($styleHeader);;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'คำถาม');
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . '1:' . $columnCharacter[1] . '1')->applyFromArray($styleHeaderLeft);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ตัวเลือกที่ถูกต้อง');
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . '1:' . $columnCharacter[2] . '1')->applyFromArray($styleHeader);

// เนื้อหาตาราง

$rowCell = 2;
$sql = "SELECT * FROM tbl_question WHERE course_id ='$course_id' ORDER BY  list_order ASC";
$rs = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_assoc($rs)) {

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['list_order']);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '0:' . $columnCharacter[0] . ($rowCell))->applyFromArray($styleTextCenter);
    //เว้นบรรทัดในexcel
    $objPHPExcel->getDefaultStyle()->getAlignment($columnCharacter[0])->setWrapText(true);
    //ตั้งค่าความสูงauto
    $objPHPExcel->getActiveSheet()->getRowDimension($rowCell)->setRowHeight(-1);


    $replaceArr = array("&nbsp;", "&amp;", "</p><p>", '<p>', '</p>', '<br>');
    $replacementArr = array(" ", "&", "\n", "", "", "\n");
    $question_text = str_replace($replaceArr, $replacementArr, $row['question_text']);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $question_text);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[1] . '2:' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextLeft);

    $sql2 = "SELECT * FROM tbl_choice WHERE question_id ='{$row['question_id']}' ORDER BY list_order ASC";
    $rs2 = mysqli_query($connection, $sql2) or die($connection->error);

    $correct_choice = "";
    $col = 3; // คอลั่มน์ที่เริ่ม choice
    $i = 1;
    while ($row2 = mysqli_fetch_assoc($rs2)) {
        if ($row2['choice_id'] == $row['correct_choice_id']) {
            $correct_choice = $i;
        }

        $replaceArr = array("&nbsp;",  "&amp;", "</p><p>", '<p>', '</p>', '<br>');
        $replacementArr = array(" ", "&", "\n", "", "", "\n");
        $choice_text = str_replace($replaceArr, $replacementArr, $row2['choice_text']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$col] . $rowCell, $choice_text);
        //-------------------------------------------------------------------------ตั้งค่าความกว้างแบบAuto
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$col])->setAutoSize(true);


        $col++;
        $i++;
    }
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . '2:' . $columnCharacter[$col - 1] . ($rowCell))->applyFromArray($styleTextLeft);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $correct_choice);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . '2:' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextCenter);


    $rowCell++;
}


/*-------------------------------------------------------------------------------------------------------------------------------*/
$objPHPExcel->setActiveSheetIndex(0);

//ตั้งชื่อไฟล์
$file_name = "Export-" . date("d-m-Y");

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
