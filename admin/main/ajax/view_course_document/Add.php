<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['admin_id'])) {

    $create_admin_id = $_SESSION['admin_id'];
    $course_id = mysqli_real_escape_string($connection, $_POST['doc_course_id']);
    $doc_id = mysqli_real_escape_string($connection, $_POST['doc_id']);
    $doc_description = mysqli_real_escape_string($connection, $_POST['doc_description']);
    $doc_type = mysqli_real_escape_string($connection, $_POST['doc_type']);

    $condition = "";
    if ($doc_type == '6') {
        $doc_path = mysqli_real_escape_string($connection, $_POST['doc_path_link']);
        $condition = ",doc_path = '$doc_path'";
    }

    $sql_list = "SELECT MAX(list_order) AS list_order FROM tbl_course_document WHERE course_id='$course_id' ";
    $rs_list = mysqli_query($connection, $sql_list) or die($connection->error);
    if ($rs_list->num_rows > 0) {
        $row_list = mysqli_fetch_assoc($rs_list);
        $list_order =  $row_list['list_order'] + 1;
    } else {
        $list_order = 1;
    }
    $sql = "INSERT INTO tbl_course_document SET 
                doc_id = '$doc_id'
                ,course_id = '$course_id'  
                ,create_admin_id= '$create_admin_id'  
                ,doc_description = '$doc_description' 
                ,doc_type = '$doc_type' 
                ,list_order= '$list_order' 
                $condition
        ";
    $rs = mysqli_query($connection, $sql);

    if ($_FILES['doc_path_file'] != "") {
        $file = explode(".", $_FILES['doc_path_file']['name']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];

        // $sql_course = "SELECT * FROM tbl_course WHERE course_id='$course_id'";
        // $rs_course  = mysqli_query($connection, $sql_course) or die($connection->error);
        // $row_course = mysqli_fetch_array($rs_course);
        // $course_code = "[" . $row_course['course_code'] . "]";

        $sql_chk = "SELECT doc_path FROM tbl_course_document WHERE doc_path LIKE '%$file[0]%'";
        $rs_chk = mysqli_query($connection, $sql_chk);
        $row_chk = mysqli_fetch_array($rs_chk);

        if ($rs_chk->num_rows > 0) {
            $filename_images = $file[0] . '(' . $rs_chk->num_rows . ').' . $file_surname;
        } else {
            $filename_images = $_FILES['doc_path_file']['name'];
        }

        // $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('pdf', 'jpeg', 'jpg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'PDF', 'JPEG', 'JPG', 'PNG', 'DOC', 'DOCX', 'XLS', 'XLSX', 'PPT', 'PPTX'))) {
            if (move_uploaded_file($_FILES['doc_path_file']['tmp_name'], "../../../../images/" . $filename_images)) {
                $sql = "UPDATE tbl_course_document SET doc_path = '$filename_images' WHERE doc_id='$doc_id'";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
            }
        }
    }

    if ($rs) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

echo json_encode($arr);
mysqli_close($connection);
