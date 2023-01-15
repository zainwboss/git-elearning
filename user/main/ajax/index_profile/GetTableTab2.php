<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$now = date('Y-m-d');
$sql = "SELECT * FROM tbl_course a 
        WHERE active_status='1' 
        AND course_id IN(SELECT course_id FROM tbl_course_group WHERE active_status='1' AND group_id IN(SELECT group_id FROM tbl_user_group WHERE user_id ='$user_id')) 
        AND course_id NOT IN (SELECT course_id FROM tbl_exam_head WHERE user_id ='$user_id' AND exam_count ='1' AND finish_datetime IS NOT NULL)
        AND (('$now' BETWEEN course_start_date AND course_finish_date) OR ('$now' >= course_start_date AND course_finish_date IS NULL))
        ORDER BY course_name ASC";
$rs  = mysqli_query($connection, $sql);
?>
<div class="row g-5">
    <?php while ($row = mysqli_fetch_array($rs)) {
            $length = strlen(utf8_decode($row['short_description']));
            if ($length > 100) {
                $short_description =  mb_substr($row['short_description'], 0, 100, "utf-8") . '...';
            } else {
                $short_description = $row['short_description'];
            }
    ?>
            <div class="col-md-6 col-xl-4" id="card_<?php echo $row['course_id'] ?>">
                <div class="card card-md-stretch mb-md-5">
                    <div class="card-body p-4">
                        <a href="view_user_course.php?id=<?php echo $row['course_id'] ?>">
                            <img style="height:265px" class="mb-5 w-100" src="../../images/<?php echo ($row['main_image'] != '') ?  $row['main_image'] : 'blank.png' ?>" alt="image" />
                        </a>
                        <a href="view_user_course.php?id=<?php echo $row['course_id'] ?>">
                            <div class="fs-3 fw-bolder text-dark"><?php echo $row['course_name'] ?></div>
                        </a>
                        <p class="text-gray-400 fw-bold fs-5 my-1"><?php echo $short_description; ?></p>
                    </div>
                </div>
            </div>
    <?php } ?>
</div>