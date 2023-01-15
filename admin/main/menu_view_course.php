<?php
$pagename = basename($_SERVER['PHP_SELF']);

?>
<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div class="d-flex flex-center flex-sm-shrink-0 bg-light w-300px h-125px w-lg-350px h-lg-150px me-sm-7 mb-4 ">
                <img class="rounded w-100 h-100" style="object-fit:cover;" src="../../images/<?php echo ($row['main_image'] != '') ? $row['main_image'] : 'blank.png' ?>" alt="image" />
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <div class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3"><?php echo $row['course_name'] ?></div>

                        </div>
                        <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400"><?php echo $row['short_description'] ?></div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="form-check form-switch form-check-custom  form-check-solid <?php echo ($row['active_status'] == 1) ? 'form-check-purple' : ''; ?>" onchange="ChangeStatus(this)">
                            <input class="form-check-input h-25px w-45px" type="checkbox" <?php echo ($row['active_status'] == 1) ? 'checked' : ''; ?> <?php if ($row_admin['admin_status'] == '2') {
                                                                                                                                                            echo 'disabled';
                                                                                                                                                        } ?> />
                        </div>
                    </div>
                </div>

                <!-- <div class="d-flex flex-wrap justify-content-start">
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bolder">29 Jan, 2022</div>
                            </div>
                            <div class="fw-bold fs-6 text-gray-400">Due Date</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                            </div>
                            <div class="fw-bold fs-6 text-gray-400">Open Tasks</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-value="15000" data-kt-countup-prefix="$">0</div>
                            </div>
                            <div class="fw-bold fs-6 text-gray-400">Budget Spent</div>
                        </div>
                    </div>
                  
                    <div class="symbol-group symbol-hover mb-3">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                            <span class="symbol-label bg-warning text-inverse-warning fw-bolder">A</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                            <img alt="Pic" src="../../template/assets/media/avatars/300-11.jpg" />
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
                            <img alt="Pic" src="../../template/assets/media/avatars/300-7.jpg" />
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Francis Mitcham">
                            <img alt="Pic" src="../../template/assets/media/avatars/300-20.jpg" />
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                            <span class="symbol-label bg-primary text-inverse-primary fw-bolder">S</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                            <img alt="Pic" src="../../template/assets/media/avatars/300-2.jpg" />
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                            <span class="symbol-label bg-info text-inverse-info fw-bolder">P</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                            <img alt="Pic" src="../../template/assets/media/avatars/300-12.jpg" />
                        </div>
                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                            <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bolder" data-bs-toggle="tooltip" data-bs-trigger="hover" title="View more users">+42</span>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="separator"></div>
        <!-- tab -->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_overview.php') ? 'active' : '' ?>" href="view_course_overview.php?id=<?php echo $course_id ?>">ภาพรวม</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_member.php') ? 'active' : '' ?>" href="view_course_member.php?id=<?php echo $course_id ?>">ผู้เข้าเรียนหลักสูตร</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_report.php') ? 'active' : '' ?>" href="view_course_report.php?id=<?php echo $course_id ?>">ข้อมูลการสอบ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_exam.php') ? 'active' : '' ?>" href="view_course_exam.php?id=<?php echo $course_id ?>">ข้อสอบ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_document.php') ? 'active' : '' ?>" href="view_course_document.php?id=<?php echo $course_id ?>">สื่อประกอบหลักสูตร</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'view_course_certificate.php') ? 'active' : '' ?>" href="view_course_certificate.php?id=<?php echo $course_id ?>">ใบประกาศ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 <?php echo ($pagename == 'form_edit_course.php') ? 'active' : '' ?>" href="form_edit_course.php?id=<?php echo $course_id ?>">แก้ไขหลักสูตร</a>
            </li>
        </ul>
        <!-- end tap -->
    </div>
</div>

<script>
    function ChangeStatus(button) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var course_id = urlParams.get('id');

        $.ajax({
            type: "post",
            url: "ajax/index_course/ChangeStatus.php",
            data: {
                course_id: course_id
            },
            dataType: "json",
            success: function(response) {
                if (response.result == 1) {
                    if (response.status == 1) {
                        $(button).addClass('form-check-purple');
                    } else if (response.status == 0) {
                        $(button).removeClass('form-check-purple');
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }
</script>