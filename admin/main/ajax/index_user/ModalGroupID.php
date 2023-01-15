<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$sql = "SELECT *FROM tbl_group WHERE active_status='1' ORDER BY group_id ASC ";
$rs  = mysqli_query($connection, $sql);
?>

<div class="modal-header pb-0 border-0 justify-content-end">
    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
        <span class="svg-icon svg-icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
            </svg>
        </span>
    </div>
</div>
<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
    <div class="text-center">
        <h1 class="mb-3">ID การเข้าถึง</h1>
        <div class="text-muted fw-bold fs-5">คั่นด้วย , หากพนักงานใดอยู่มากกว่า 1 กลุ่ม
            <div class="fw-bolder">ตัวอย่างเช่น 1,2,3 </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-row-dashed table-row-gray-300 gy-7" id="tbl_group_id">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                    <th class="text-center min-w-100px">ID</th>
                    <th class="text-center">ชื่อกลุ่ม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($rs)) {
                ?>
                    <tr>
                        <td class="text-center fw-bold"><?php echo $row['group_id']; ?></td>
                        <td class="text-center fw-bold"><?php echo $row['group_name']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>