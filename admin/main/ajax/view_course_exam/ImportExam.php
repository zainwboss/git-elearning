<?php
session_start();

use function PHPSTORM_META\map;

include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$fileImport = $_FILES["file_excel"]["tmp_name"];
$course_id = $_POST['import_course_id'];

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
//  $highestColumm = $objPHPExcel->setActiveSheetIndex()->getHighestColumn();
//  echo 'getHighestColumn() =  [' . $highestColumm . ']';
$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CC', 'CC', 'CD', 'CE', 'CF',
    'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'
);


// $sql = "SELECT * FROM tbl_question WHERE course_id ='$course_id'";
// $rs = mysqli_query($connection, $sql) or die($connection->error);
// while ($row = mysqli_fetch_array($rs)) {

//     $sql_del_choice = "DELETE FROM tbl_choice WHERE question_id ='{$row['question_id']}'";
//     $sql_del_choice = mysqli_query($connection, $sql_del_choice) or die($connection->error);
// }
// $sql_del_question = "DELETE FROM tbl_question WHERE course_id ='$course_id'";
// mysqli_query($connection, $sql_del_question) or die($connection->error);

for ($row = 2; $row <= $highestRow; $row++) {

    $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);

    $list_order = mysqli_real_escape_string($connection, $dataRow[$row]['A']);
    $question_text =   mysqli_real_escape_string($connection, $dataRow[$row]['B']);

    $replaceArr = array(" ",  '\n');
    $replacementArr = array("&nbsp;",  "</p><p>");
    $question_text = str_replace($replaceArr, $replacementArr, $question_text);
    $question_text = "<p>" . $question_text . "</p>";

    $correct_choice_id =  mysqli_real_escape_string($connection, $dataRow[$row]['C']);

    if (strlen($list_order) > 0) {

        $sql_q = "SELECT * FROM tbl_question WHERE course_id ='$course_id' AND list_order= '$list_order'";
        $rs_q = mysqli_query($connection, $sql_q) or die($connection->error);
        $row_q = mysqli_fetch_array($rs_q);

        if ($rs_q->num_rows > 0) {
            $question_id = $row_q['question_id'];
            $sql = "UPDATE tbl_question SET question_text = '$question_text' WHERE course_id ='$course_id' AND list_order= '$list_order'";
        } else {
            $question_id = getRandomID(10, 'tbl_question', 'question_id');
            $sql = "INSERT INTO tbl_question SET 
                course_id = '$course_id' 
                ,question_id = '$question_id' 
                ,question_text = '$question_text' 
                ,list_order = '$list_order'";
        }

        $rs = mysqli_query($connection, $sql) or die($connection->error);


        $countcol =  $objWorksheet->getHighestDataColumn($row); //เอาคอลัมน์สุดท้ายของแถวนี้ 
        $dataRow2 = $objWorksheet->rangeToArray('D' . $row . ':' . $countcol . $row, null, true, true, true);
        //ได้ข้อมูล array 2 มิติ 
        // Array
        // (
        //     [2] => Array
        //         (
        //             [D] => a
        //             [E] => b
        //             [F] => c
        //             [G] => d
        //         )

        // )
        $i2 = 0;
        foreach ($dataRow2[$row] as $key => $value) {
            $choice_text = mysqli_real_escape_string($connection, $value);

            $replaceArr = array(" ", '\n');
            $replacementArr = array("&nbsp;", "</p><p>");
            $choice_text = str_replace($replaceArr, $replacementArr, $choice_text);
            $choice_text = "<p>" . $choice_text . "</p>";

            $i2++;

            $sql_c = "SELECT * FROM tbl_choice WHERE question_id ='$question_id' AND list_order= '$i2'";
            $rs_c = mysqli_query($connection, $sql_c) or die($connection->error);
            $row_c = mysqli_fetch_array($rs_c);

            if ($rs_c->num_rows > 0) {
                $sql = "UPDATE tbl_choice SET choice_text = '$choice_text' WHERE question_id ='$question_id' AND list_order= '$i2'";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
                $choice_id = $row_c['choice_id'];
            } else {
                $sql = "INSERT INTO tbl_choice SET 
                    question_id = '$question_id' 
                    ,choice_text = '$choice_text' 
                    ,list_order = '$i2'
                   ";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
                $choice_id = mysqli_insert_id($connection);
            }

            if ($i2 == $correct_choice_id) {
                $sql2 = "UPDATE tbl_question SET correct_choice_id = '$choice_id' WHERE question_id = '$question_id' ";
                $rs2 = mysqli_query($connection, $sql2) or die($connection->error);
            }
        }

        // for ($i = 3; $i <= $countcol; $i++) {
        //     $choice_text =$columnCharacter[$i][$row];
        // }

        // $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $text);
        // $objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getAlignment()->setWrapText(true);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    }
}

// $file =  $_FILES["file_excel"]["name"];
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save($file);
$arr['result'] = 1;
echo json_encode($arr);



//  echo $highestRow." - ".$highestColumn;
//
// echo "<pre>";
// echo print_r($temp_array);
// echo "</pre>";