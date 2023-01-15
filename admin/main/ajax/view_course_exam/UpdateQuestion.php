<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$question_id = mysqli_real_escape_string($connection, $_POST['question_id']);
$question_text = mysqli_real_escape_string($connection, $_POST['question_text']);

$sql = "UPDATE tbl_question SET question_text ='$question_text' WHERE question_id='$question_id'";
$rs  = mysqli_query($connection, $sql) or die($connection->error);

if ($_FILES['question_image'] != "") {
    $file = explode(".", $_FILES['question_image']['name']); //แยกชื่อกับนามสกุลไฟล์
    $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
    $file_surname = $file[$count];
    $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
    if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
        if (move_uploaded_file($_FILES['question_image']['tmp_name'], "../../../../images/" . $filename_images)) {
            $sql1 = "SELECT question_image FROM tbl_question WHERE question_id='$question_id' ";
            $rs1 = mysqli_query($connection, $sql1);
            $row1 = mysqli_fetch_array($rs1);
            unlink('../../../../images/' . $row1['question_image']);

            $sql = "UPDATE tbl_question SET question_image = '$filename_images' WHERE question_id='$question_id'";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
        }
    }
}

// $sql = "SELECT choice_image FROM tbl_choice WHERE question_id='$question_id'";
// $rs = mysqli_query($connection, $sql) or die($connection->error);
// while ($row = mysqli_fetch_array($rs)) {
//     $path = "../../upload/lesson_img/" . $row['choice_image'];
//     unlink($path);
// }
// $sql_delete = "DELETE FROM tbl_choice WHERE question_id='$question_id'";
// $rs_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

$list_choice = json_decode($_POST['list_choice']);
$list_order = 0;
foreach ($list_choice as $value) {
    $choice_id = $value->choice_id;
    $choice_text = mysqli_real_escape_string($connection, $value->choice_text);
    $correct_choice_id = $value->correct_choice_id;
    $list_order++;

    $sql = "UPDATE tbl_choice SET list_order = '$list_order' ,choice_text = '$choice_text' WHERE choice_id='$choice_id' ";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);

    if ($correct_choice_id == 1) {
        $sql = "UPDATE tbl_question SET correct_choice_id ='$choice_id' WHERE question_id='$question_id'";
        $rs  = mysqli_query($connection, $sql) or die($connection->error);
    }

    if ($_FILES[$choice_id] != "") {
        $file = explode(".", $_FILES[$choice_id]['name']); //แยกชื่อกับนามสกุลไฟล์
        $count = count($file) - 1; //นับได้ 2 จาก array ชื่อกับนามสกุลภาพ
        $file_surname = $file[$count];
        $filename_images = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname;
        if (in_array($file_surname, array('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'))) {
            if (move_uploaded_file($_FILES[$choice_id]['tmp_name'], "../../../../images/" . $filename_images)) {

                $sql1 = "SELECT choice_image FROM tbl_choice WHERE choice_id='$choice_id' ";
                $rs1 = mysqli_query($connection, $sql1);
                $row1 = mysqli_fetch_array($rs1);
                unlink('../../../../images/' . $row1['choice_image']);

                $sql = "UPDATE tbl_choice SET choice_image = '$filename_images' WHERE choice_id='$choice_id'";
                $rs = mysqli_query($connection, $sql) or die($connection->error);
            }
        }
    }
}


if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
mysqli_close($connection);
