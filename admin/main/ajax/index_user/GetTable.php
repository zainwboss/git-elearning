<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$sql = "SELECT *FROM tbl_user ORDER BY fullname ASC ";
$rs  = mysqli_query($connection, $sql);

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs_admin = mysqli_query($connection, $sql_admin);
$row_admin = mysqli_fetch_array($rs_admin);

?>

<div class="table-responsive">
    <table class="table table-row-dashed table-row-gray-300 gy-7" id="tbl_user">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                <th class="text-start min-w-100px">ชื่อ-นามสกุล</th>
                <th class="text-center">รหัสพนักงาน</th>
                <th class="text-center">เบอร์โทรศัพท์</th>
                <th class="text-center">แผนก</th>
                <th class="text-center">ตำแหน่ง</th>
                <th class="text-center min-w-75px">สถานะ</th>
                <th class="text-center min-w-75px"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($rs)) {
            ?>
                <tr>
                    <td class="text-start fw-bold">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-45px me-5">
                                <img style="object-fit:cover;" alt="image_user" src="../../images/<?php echo ($row['profile_image'] != '') ? $row['profile_image'] : 'blank.png' ?>">
                            </div>
                            <div class="d-flex justify-content-start flex-column">
                                <div class="">
                                    <div class="text-dark fw-bold text-hover-primary fs-6">
                                        <?php echo $row['fullname']; ?>
                                    </div>
                                    <?php $sql_user_group = "SELECT * FROM tbl_user_group a
                                   LEFT JOIN  tbl_group b ON a.group_id=b.group_id
                                   WHERE a.user_id ='{$row['user_id']}' ORDER BY b.group_name ASC ";
                                    $rs_user_group  = mysqli_query($connection, $sql_user_group);
                                    while ($row_user_group = mysqli_fetch_array($rs_user_group)) {
                                    ?>
                                        <span class="badge badge-light-info mt-2"><?php echo $row_user_group['group_name']; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center fw-bold"><?php echo $row['user_code']; ?></td>
                    <td class="text-center fw-bold"><?php echo ($row['phone'] != '') ? $row['phone'] : '-'; ?></td>
                    <td class="text-center fw-bold"><?php echo $row['department']; ?></td>
                    <td class="text-center fw-bold"><?php echo $row['position']; ?></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <div class="form-check form-switch form-check-custom form-check-solid <?php echo ($row['active_status'] == 1) ? 'form-check-purple' : ''; ?>" onchange="ChangeStatus(this,'<?php echo $row['user_id']; ?>')">
                                <input class="form-check-input" type="checkbox" <?php echo ($row['active_status'] == 1) ? 'checked' : ''; ?> <?php if ($row_admin['admin_status'] == '2') {echo 'disabled'; } ?>/>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <?php if ($row_admin['admin_status'] != '2') { ?>
                        <button class="btn btn-sm btn-icon btn-light-warning btn-hover-rise  me-1" data-bs-toggle="modal" data-bs-target="#modal" onclick="ModalEdit('<?php echo $row['user_id']; ?>')">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </button>
                        <?php } ?>
                        <!-- <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" >
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </a> -->

                        <!-- <a href="view_member.php?id=<?php echo $row['user_id']; ?>" target="_blank" class="btn btn-xs btn-info btn-block" type="button"><i class="fa fa-search"></i> ดูข้อมูล</a> -->
                        <!-- <button class="btn btn-sm btn-warning " type="button" onclick="ModalEdit('<?php echo $row['user_id']; ?>')"><i class="fa fa-edit"></i> แก้ไขข้อมูล</button> -->
                        <!-- <button class="btn btn-sm btn-secondary " type="button" onclick="SetPassword('<?php echo $row['user_id']; ?>','<?php echo $row['phone']; ?>')"><i class="fa fa-key"></i> รีเซ็ทรหัสผ่าน</button> -->

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($connection); ?>