<?php
session_start();
require('main_function.php');
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

if (empty($_SESSION['admin_id'])) {
    session_destroy();
?>
    <script>
        alert("เซสชั่นหมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง");
        location.href = "../";
    </script>
<?php
    exit();
}

// //กำหนดเวลาที่สามารถอยู่ในระบบ
// $sessionlifetime = 60; //กำหนดเป็นนาที

// if(isset($_SESSION["timeLasetdActive"])){
//     $seclogin = (time()-$_SESSION["timeLasetdActive"])/60;

//     //หากไม่ได้ Active ในเวลาที่กำหนด
//     if($seclogin>$sessionlifetime){
//         header("location:../");
//         exit;
//     }else{
//         $_SESSION["timeLasetdActive"] = time();
//     }
// }else{
//     $_SESSION["timeLasetdActive"] = time();
// }

?>

