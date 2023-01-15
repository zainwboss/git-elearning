<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (!empty($_SESSION['admin_id'])) {
    $create_admin_id = $_SESSION['admin_id'];
    $course_id = mysqli_real_escape_string($connection, $_POST['course_id']);

    $course_name = mysqli_real_escape_string($connection, $_POST['course_name']);
    $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
    $teacher_id = mysqli_real_escape_string($connection, $_POST['teacher_id']);

    $pass_percent = mysqli_real_escape_string($connection, ($_POST['pass_percent'] == '') ? 0 : $_POST['pass_percent']);
    $exam_time = mysqli_real_escape_string($connection, ($_POST['exam_time'] == '') ? 0 : $_POST['exam_time']);
    $solve_type = mysqli_real_escape_string($connection, ($_POST['solve_type'] == '') ? 0 : $_POST['solve_type']);

    $shuffle_choice = mysqli_real_escape_string($connection, ($_POST['shuffle_choice'] == '') ? 0 :  $_POST['shuffle_choice']);
    $shuffle_exam = mysqli_real_escape_string($connection, ($_POST['random_exam'] == 1) ? 1 :  $_POST['shuffle_exam']);
    $random_exam = mysqli_real_escape_string($connection, ($_POST['random_exam'] == '') ? 0 :  $_POST['random_exam']);
    $random_amount = mysqli_real_escape_string($connection, ($_POST['random_amount'] == '') ? 0 : $_POST['random_amount']);

    $short_description = mysqli_real_escape_string($connection, $_POST['short_description']);
    $vimeo_embed = mysqli_real_escape_string($connection, $_POST['vimeo_embed']);
    $course_start_date = date('Y-m-d', strtotime(str_replace("/", "-", $_POST['course_start_date'])));

    $condition = "";
    if (!empty($_POST['course_finish_date'])) {
        $course_finish_date = date('Y-m-d', strtotime(str_replace("/", "-", $_POST['course_finish_date'])));
        $condition = ",course_finish_date='$course_finish_date'";
    } else {
        $condition = ",course_finish_date=NULL";
    }

    $sql = "INSERT INTO tbl_course SET 
                 course_id = '$course_id' 
                ,create_admin_id = '$create_admin_id'
                ,course_name = '$course_name' 
                ,course_code = '$course_code' 
                ,teacher_id = '$teacher_id' 
                ,pass_percent = '$pass_percent' 
                ,exam_time = '$exam_time'  
                ,solve_type = '$solve_type'  
                ,shuffle_choice = '$shuffle_choice'  
                ,shuffle_exam = '$shuffle_exam'  
                ,random_exam = '$random_exam'  
                ,random_amount = '$random_amount'  
                ,short_description = '$short_description'  
                ,vimeo_embed = '$vimeo_embed'  
                ,course_start_date = '$course_start_date'  
                $condition
        ";

    $rs = mysqli_query($connection, $sql) or die($connection->error);

    //course_group
    foreach ($_POST['course_group'] as $key => $group_id) {
        $sql_group = "INSERT INTO tbl_course_group SET course_id = '$course_id',group_id = '$group_id' ";
        $rs_group = mysqli_query($connection, $sql_group) or die($connection->error);
    }

    if ($_FILES['main_image'] != "") {
        $file = explode(".", $_FILES['main_image']['name']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];
        $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], "../../../../images/" . $filename_images)) {
                $sql = "UPDATE tbl_course SET main_image = '$filename_images' WHERE course_id='$course_id'";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
            }
        }
    }

    if ($rs) {
        $arr['result'] = 1;
        $arr['course_id'] = $course_id;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}
echo json_encode($arr);
mysqli_close($connection);
