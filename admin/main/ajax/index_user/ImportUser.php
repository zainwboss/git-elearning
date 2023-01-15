<?php
use function PHPSTORM_META\map;

include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$fileImport = $_FILES["file_excel"]["tmp_name"];

// set_time_limit(0);

/** PHPExcel */
require('../../../../PHPExcel-1.8/Classes/PHPExcel.php');
/** PHPExcel_IOFactory - Reader */
require('../../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

$inputFileType = PHPExcel_IOFactory::identify($fileImport);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($fileImport);
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();

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

$styleTextCenter = array(
    // 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // เส้น
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
//  $highestColumm = $objPHPExcel->setActiveSheetIndex()->getHighestColumn();
//  echo 'getHighestColumn() =  [' . $highestColumm . ']';
$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CC', 'CC', 'CD', 'CE', 'CF',
    'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'
);

//Setความกว้าง
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(15);

$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(18);

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1:' . $columnCharacter[7] . '1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[9] . '2:' . $columnCharacter[13] . '2')->applyFromArray($styleTextCenter);

//บอกerror
$rowCell = 2;
$objPHPExcel->setActiveSheetIndex()->setCellValue($columnCharacter[9] . $rowCell, 'บังคับกรอก');
$objWorksheet->getStyle('j' . $rowCell)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF0000'),
        )
    )
);
$objPHPExcel->setActiveSheetIndex()->setCellValue($columnCharacter[10] . $rowCell, 'ข้อมูลซ้ำ');
$objWorksheet->getStyle('k' . $rowCell)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00'),
        )
    )
);
$objPHPExcel->setActiveSheetIndex()->setCellValue($columnCharacter[11] . $rowCell, 'รูปแบบไม่ถูกต้อง');
$objWorksheet->getStyle('l' . $rowCell)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF7000'),
        )
    )
);

$objPHPExcel->setActiveSheetIndex()->setCellValue($columnCharacter[12] . $rowCell, 'IDไม่ถูกต้อง');
$objWorksheet->getStyle('m' . $rowCell)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF00CD'),
        )
    )
);

$objPHPExcel->setActiveSheetIndex()->setCellValue($columnCharacter[13] . $rowCell, 'แบบฟอร์มไม่ถูกต้อง');
$objWorksheet->getStyle('n' . $rowCell)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '009ef7'),
        )
    )
);


$status =0;
for ($row = 2; $row <= $highestRow; $row++) {
    $status_check = 0;
    //ดึงส่วนหัวมาเช็ค
    $dataRow = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
    $head_email =   mysqli_real_escape_string($connection, $dataRow[1]['A']);
    $head_phone =  mysqli_real_escape_string($connection, $dataRow[1]['B']);
    $head_user_code = mysqli_real_escape_string($connection, $dataRow[1]['C']);
    $head_fullname =  mysqli_real_escape_string($connection, $dataRow[1]['D']);
    $head_department =  mysqli_real_escape_string($connection, $dataRow[1]['E']);
    $head_position =  mysqli_real_escape_string($connection, $dataRow[1]['F']);
    $head_birthdate =  mysqli_real_escape_string($connection, $dataRow[1]['G']);
    $head_group =  mysqli_real_escape_string($connection, $dataRow[1]['H']);

    if ($head_email == 'Email' && $head_phone == 'เบอร์โทรศัพท์' && $head_user_code == 'รหัสพนักงาน' && $head_fullname == 'ชื่อ-นามสกุล' && $head_department == 'แผนก' && $head_position == 'ตำแหน่ง' && $head_birthdate == 'วันเกิด(30.01.2001)' && $head_group == 'การเข้าถึง') {

        //เคลียร์สีขาว
        $objWorksheet->getStyle($columnCharacter[0] . $row . ':' . $columnCharacter[7] . $row)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF'),
                )
            )
        );

        $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);

        $email =   mysqli_real_escape_string($connection, $dataRow[$row]['A']);
        $phone =  mysqli_real_escape_string($connection, $dataRow[$row]['B']);
        $user_code = mysqli_real_escape_string($connection, $dataRow[$row]['C']);
        $fullname =  mysqli_real_escape_string($connection, $dataRow[$row]['D']);
        $department =  mysqli_real_escape_string($connection, $dataRow[$row]['E']);
        $position =  mysqli_real_escape_string($connection, $dataRow[$row]['F']);
        $birthdate =  mysqli_real_escape_string($connection, $dataRow[$row]['G']);
        $group = mysqli_real_escape_string($connection, $dataRow[$row]['H']);
        $password = md5($phone);

        //birthdate
        $condition = "";
        if ($birthdate != "") {
            if (!DateTime::createFromFormat('d.m.Y', $birthdate)) { //เช็ค format 12.09.2022 แต่จะไม่เช็คจำนวนที่ถูกต้อง 99/99/9999 เช่นเดือนมีแค่ 12 ใส่เกินได้ 
                $status_check = 1;
                $status=1;
                $objWorksheet->getStyle('G' . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF7000'),
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            } 
            else {
                $date =  date_parse_from_format("d.m.Y", $birthdate); //ได้ข้อมูลเป็น array
                if (checkdate($date['month'], $date['day'], $date['year'])) { //เช็คจำนวนที่ถูกต้อง 99/99/9999 เช่นเดือนมีแค่ 12 ใส่เกินไม่ได้ 
                    // if (count($date['month']) == 2 && count($date['day']) == 2 && count($date['year']) == 4) {
                        $birthdate = date('Y-m-d', strtotime(str_replace(".", "-", $birthdate)));
                        $condition = ",birthdate='$birthdate'";
                    // } else {
                    //     $status_check = 1;
                    //     $objWorksheet->getStyle('G' . $row)->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                 'color' => array('rgb' => 'FF7000'),
                    //             )
                    //         )
                    //     );
                    //     $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setWrapText(true);
                    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                    // }
                } else {
                    $status_check = 1;
                    $status=1;
                    $objWorksheet->getStyle('G' . $row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'FF7000'),
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                }
            }
        }

        //fullname
        if ($fullname == "") {
            $status_check = 1;
            $status=1;
            $objWorksheet->getStyle('D' . $row)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000'),
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('D' . $row)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        }

        // email
        if ($email == "") {
            $status_check = 1;
            $status=1;
            $objWorksheet->getStyle('A' . $row)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000'),
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql_chk = "SELECT count(email) as chk_email FROM tbl_user WHERE email = '$email'";
                $rs_chk = mysqli_query($connection, $sql_chk) or die($connection->error);
                $row_chk = mysqli_fetch_array($rs_chk);

                if ($row_chk['chk_email'] > 0) {
                    $status_check = 1;
                    $status=1;
                    $objWorksheet->getStyle('A' . $row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'FFFF00'),
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                }
            } else {
                $status_check = 1;
                $status=1;
                $objWorksheet->getStyle('A' . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF7000'),
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            }
        }

        //phone
        if ($phone == "") {
            $status_check = 1;
            $status=1;
            $objWorksheet->getStyle('B' . $row)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000'),
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        } else {
            if (preg_match('/^[0-9]{10}+$/', $phone)) {
                $sql_chk2 = "SELECT count(phone) as chk_phone FROM tbl_user WHERE phone = '$phone'";
                $rs_chk2 = mysqli_query($connection, $sql_chk2) or die($connection->error);
                $row_chk2 = mysqli_fetch_array($rs_chk2);

                if ($row_chk2['chk_phone'] > 0) {
                    $status_check = 1;
                    $status=1;
                    $objWorksheet->getStyle('B' . $row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'FFFF00'),
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                }
            } else {
                $status_check = 1;
                $status=1;
                $objWorksheet->getStyle('B' . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF7000'),
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            }
        }

        //user_code
        if ($user_code != "") {
            $sql_chk4 = "SELECT count(user_code) as user_code FROM tbl_user WHERE user_code = '$user_code'";
            $rs_chk4 = mysqli_query($connection, $sql_chk4) or die($connection->error);
            $row_chk4 = mysqli_fetch_array($rs_chk4);

            if ($row_chk4['user_code'] > 0) {
                $status_check = 1;
                $status=1;
                $objWorksheet->getStyle('C' . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00'),
                        )

                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('C' . $row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            }
        }

        //group_id
        if ($group != "") {
            $data_group = explode(',', $group);
            foreach ($data_group as $group_id) {
                //user_group
                $sql_chk5 = "SELECT count(group_id) as group_id FROM tbl_group WHERE group_id = '$group_id'";
                $rs_chk5 = mysqli_query($connection, $sql_chk5) or die($connection->error);
                $row_chk5 = mysqli_fetch_array($rs_chk5);

                if ($row_chk5['group_id'] == 0) {
                    $status_check = 1;
                    $status=1;
                    $objWorksheet->getStyle('H' . $row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'FF00CD'),
                            )

                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                }
            }
        }

        if ($status_check == 0) {
            $user_id = getRandomID(10, 'tbl_user', 'user_id');
            $sql = "INSERT INTO tbl_user SET
                        user_id = '$user_id'
                        ,user_code = '$user_code'
                        ,email = '$email'
                        ,password = '$password'
                        ,fullname = '$fullname'
                        ,phone = '$phone'
                        ,department = '$department'
                        ,position = '$position'
                        $condition";
            // echo $sql ;
            $rs = mysqli_query($connection, $sql);

            if ($group != "") {
                $data_group = explode(',', $group);
                foreach ($data_group as $group_id) {
                    //user_group
                    $sql_group = "INSERT INTO tbl_user_group SET user_id = '$user_id',group_id = '$group_id'";
                    $rs_group = mysqli_query($connection, $sql_group) or die($connection->error);
                }
            }
        }
    } else { 
        $status_check = 1;
        $status=1;
        $objWorksheet->getStyle($columnCharacter[0] . '1:' . $columnCharacter[7] . '1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '009ef7'),
                )
            )
        );
    }
}

$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '2:' . $columnCharacter[7] . ($row - 1))->applyFromArray($styleTextCenter);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// unlink('error7.xlsx');
if ($status == 1) {

    $file_name = 'error' . date('H.i_d.m.y') . '.xlsx';
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
    // header('Content-Disposition: attachment;filename="' . $file_name . '"'); //tell browser what's the file name
    // header('Cache-Control: max-age=0'); //no cache 
    // ob_end_clean();
    $objWriter->save($file_name);

    $arr['file_name'] = $file_name;
    $arr['result'] = 0;
} else {
    $arr['result'] = 1;
}
echo json_encode($arr);