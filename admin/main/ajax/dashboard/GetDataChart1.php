<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$data = [];
for ($i = 0; $i < 24; $i++) {
    if ($i < 10) {
        $hours = "0" . $i;
    } else {
        $hours =  $i;
    }

    $sql = "SELECT COUNT(log_id) AS val FROM tbl_login_log WHERE TIME(login_datetime) BETWEEN '$hours:00:00' AND '$hours:59:59'";
    $rs =  mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    array_push($data, ["time" => $hours . ':00', "value" =>  intval($row['val'])]);

}

echo json_encode($data);
mysqli_close($connection);
