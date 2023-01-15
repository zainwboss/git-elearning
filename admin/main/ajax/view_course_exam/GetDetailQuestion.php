<?php
session_start();
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$question_id = mysqli_real_escape_string($connection, $_POST['question_id']);

$sql = "SELECT * FROM tbl_question WHERE question_id='$question_id'";
$rs = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($rs);

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$rs_admin = mysqli_query($connection, $sql_admin);
$row_admin = mysqli_fetch_array($rs_admin);

?>

<input type="hidden" id="question_id" name="question_id" value="<?php echo $question_id ?>">
<div class="row g-6 g-xl-9 table-loading">
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-header ribbon ribbon-top ribbon-vertical">
                <?php if ($row_admin['admin_status'] != '2') { ?>
                    <div class="ribbon-label bg-danger" style="cursor:pointer" onclick="DeleteQuestion('<?php echo $question_id ?>');">
                        <!-- <span class="svg-icon svg-icon-white svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                        </svg>
                    </span> -->
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                <?php } ?>
                <div class="card-title">
                    <h3 class="fw-bolder">คำถาม
                        <span class="svg-icon svg-icon-muted svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                <path d="M11.276 13.654C11.276 13.2713 11.3367 12.9447 11.458 12.674C11.5887 12.394 11.738 12.1653 11.906 11.988C12.0833 11.8107 12.3167 11.61 12.606 11.386C12.942 11.1247 13.1893 10.896 13.348 10.7C13.5067 10.4947 13.586 10.2427 13.586 9.944C13.586 9.636 13.4833 9.356 13.278 9.104C13.082 8.84267 12.69 8.712 12.102 8.712C11.486 8.712 11.066 8.866 10.842 9.174C10.6273 9.482 10.52 9.82267 10.52 10.196L10.534 10.574H8.826C8.78867 10.3967 8.77 10.2333 8.77 10.084C8.77 9.552 8.90067 9.07133 9.162 8.642C9.42333 8.20333 9.81067 7.858 10.324 7.606C10.8467 7.354 11.4813 7.228 12.228 7.228C13.1987 7.228 13.9687 7.44733 14.538 7.886C15.1073 8.31533 15.392 8.92667 15.392 9.72C15.392 10.168 15.322 10.5507 15.182 10.868C15.042 11.1853 14.874 11.442 14.678 11.638C14.482 11.834 14.2253 12.0533 13.908 12.296C13.544 12.576 13.2733 12.8233 13.096 13.038C12.928 13.2527 12.844 13.528 12.844 13.864V14.326H11.276V13.654ZM11.192 15.222H12.928V17H11.192V15.222Z" fill="currentColor" />
                            </svg>
                        </span>
                    </h3>
                </div>
            </div>
            <div class="card-body p-10">
                <div class="d-flex flex-column mb-6 mb-xl-9 fv-row">
                    <textarea class="ckeditor" id="question_text" name="question_text"><?php echo $row['question_text']; ?></textarea>
                </div>

                <div class="d-flex align-items-center">
                    <?php if ($row_admin['admin_status'] != '2') { ?>
                        <div class="col-10 col-sm-10 col-md-6">
                            <input type="file" class="form-control" id="question_image" name="question_image" />
                        </div>
                    <?php } ?>
                    <div class="col-2 col-sm-2 col-md-6 <?php if ($row_admin['admin_status'] != '2') {
                                                            echo 'ps-5';
                                                        } ?>">
                        <button class="btn bg-light btn-active-icon-info p-1" data-bs-toggle="modal" data-bs-target="#modal_img_question">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx m-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z" fill="currentColor" />
                                    <path d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z" fill="currentColor" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    <div class="modal fade" id="modal_img_question" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-500px">
                            <div class="modal-content rounded">
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
                                    <div class="mb-13 text-center">
                                        <h1 class="mb-3">รูปภาพ</h1>
                                    </div>
                                    <div class="d-flex justify-content-center mb-8">
                                        <img class="w-250px h-250px" src="../../images/<?php echo ($row['question_image'] != '') ? $row['question_image'] : 'blank.png'; ?>" id="img_question">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="fw-bolder">คำตอบ
                        <span class="svg-icon svg-icon-muted svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                            </svg>
                        </span>
                    </h3>
                </div>
            </div>
            <div class="card-body p-10">
                <div data-kt-buttons="true" id="ShowChoice" class="row">
                    <?php
                    $sql_choice = "SELECT * FROM tbl_choice WHERE question_id='$question_id' ORDER BY list_order ASC";
                    $rs_choice = mysqli_query($connection, $sql_choice);
                    while ($row_choice = mysqli_fetch_array($rs_choice)) {
                        $choice_id =  $row_choice['choice_id']
                    ?>
                        <div class="col-md-6 fv-row Choice_<?php echo $choice_id ?>">
                            <div class="btn btn-outline btn-outline-dashed text-start p-6 mb-5 w-100 rowChoice_<?php echo $choice_id ?> <?php if ($choice_id == $row['correct_choice_id']) {
                                                                                                                                            echo 'active';
                                                                                                                                        } ?>" id="rowChoice">
                                <div class="d-flex align-items-center mb-5 mb-xl-8">
                                    <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                        <input class="form-check-input" type="radio" name="correct_status" id="correct_status_<?php echo $choice_id ?>" value="1" onclick="ChoiceActive('<?php echo $choice_id ?>');" <?php if ($choice_id == $row['correct_choice_id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?> <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                                                } ?> />
                                        <input type="hidden" id="choice_id" name="choice_id" value="<?php echo $choice_id ?>">
                                    </div>
                                    <div class="flex-grow-1 w-100">
                                        <textarea class="ckeditor" name="choice_text" id="choice_text_<?php echo $choice_id ?>"><?php echo $row_choice['choice_text']; ?></textarea>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="me-13">
                                        <?php if ($row_admin['admin_status'] != '2') { ?>
                                            <button class="btn btn-sm btn-icon btn-danger w-25px h-25px" style="border-radius: 15px;" onclick="DeleteChoice('<?php echo $choice_id ?>');">
                                                <span class="svg-icon svg-icon-muted svg-icon-1x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </button>
                                        <?php } ?>
                                    </div>
                                    <?php if ($row_admin['admin_status'] != '2') { ?>
                                        <div class="w-100">
                                            <input type="file" class="form-control" name="choice_image" id="choice_image_<?php echo $choice_id ?>" />
                                        </div>
                                    <?php } ?>
                                    <div class="text-end <?php if ($row_admin['admin_status'] != '2') {
                                                                echo 'ps-2';
                                                            } ?>">
                                        <button class="btn bg-light btn-active-icon-info p-1" data-bs-toggle="modal" data-bs-target="#modal_img_choice_<?php echo $choice_id ?>">
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx m-0 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z" fill="currentColor" />
                                                    <path d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal_img_choice_<?php echo $choice_id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-500px">
                                    <div class="modal-content rounded">
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
                                            <div class="mb-13 text-center">
                                                <h1 class="mb-3">รูปภาพ</h1>
                                            </div>
                                            <div class="d-flex justify-content-center mb-8 ">
                                                <img class="w-250px h-250px" src="../../images/<?php echo ($row_choice['choice_image'] != '') ? $row_choice['choice_image'] : 'blank.png'; ?>" id="img_choice_<?php echo $choice_id ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card-footer">
                <?php if ($row_admin['admin_status'] != '2') { ?>
                    <button type="button" class="btn btn-primary btn-sm btn-hover-rise me-5" id="addChoice" onclick="AddChoice('<?php echo $question_id ?>');">
                        <span class="svg-icon svg-icon-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <span class="indicator-label"> เพิ่มตัวเลือก</span>
                        <span class="indicator-progress">โปรดรอสักครู่...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col col-12">
        <div class="d-flex justify-content-end">
            <!-- <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light btn-hover-scale me-3" ></button> -->
            <?php if ($row_admin['admin_status'] != '2') { ?>
                <button type="button" data-kt-contacts-type="submit" class="btn btn-primary btn-hover-scale" id="exam_submit" onclick="submit();">
                    <span class="indicator-label">บันทึก</span>
                    <span class="indicator-progress">โปรดรอสักครู่...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            <?php } ?>
        </div>
    </div>
</div>