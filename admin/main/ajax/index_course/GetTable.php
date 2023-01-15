<?php
include("../../../../config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);

$active_status = mysqli_real_escape_string($connection, $_POST['active_status']);
$condition = "";

if ($active_status == 'active') {
    $condition = "WHERE active_status = '1'";
} else if ($active_status == 'noactive') {
    $condition = "WHERE active_status = '0'";
}

$sql = "SELECT * FROM tbl_course $condition ORDER BY course_name ASC ";
$rs  = mysqli_query($connection, $sql);

?>

<!--begin::Row-->
<div class="row g-6 g-xl-9">
    <!--begin::Col-->
    <?php while ($row = mysqli_fetch_array($rs)) { ?>
        <div class="col-md-6 col-xl-4" id="card_<?php echo $row['course_id'] ?>">
            <!--begin::Card-->
            <div class="card border-hover-primary">
                <!-- <div class="card-header border-0 ">
                    <div class="card-title m-0">

                    </div>
                    <div class="card-toolbar">

                        <span class="badge badge-light-primary fw-bolder me-auto px-4 py-3">In Progress</span>
                    </div>
                </div> -->

                <div class="card-body p-8">
                    <a href="view_course_overview.php?id=<?php echo $row['course_id'] ?>">
                        <img class="mb-5 h-150px w-100" src="../../images/<?php echo ($row['main_image'] != '') ?  $row['main_image'] : 'blank.png' ?>" alt="image" />
                    </a>

                    <a href="view_course_overview.php?id=<?php echo $row['course_id'] ?>">
                        <div class="fs-3 fw-bolder text-dark"><?php echo $row['course_name'] ?></div>
                    </a>
                    <p class="text-gray-400 fw-bold fs-5 mt-1 mb-7"><?php echo $row['short_description'] ?></p>

                    <div class="d-flex justify-content-between">
                        <div class="symbol-group symbol-hover">
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Emma Smith">
                                <img alt="Pic" src="../../template/assets/media/avatars/300-6.jpg" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Rudy Stone">
                                <img alt="Pic" src="../../template/assets/media/avatars/300-1.jpg" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                <span class="symbol-label bg-primary text-inverse-primary fw-bolder">+50</span>
                            </div>
                        </div>

                        <div class="form-check form-switch form-check-custom  form-check-solid <?php echo ($row['active_status'] == 1) ? 'form-check-purple' : ''; ?>" onchange="ChangeStatus(this,'<?php echo $row['course_id']; ?>')">
                            <input class="form-check-input h-25px w-45px" type="checkbox" <?php echo ($row['active_status'] == 1) ? 'checked' : ''; ?> />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


</div>
<!--end::Row-->


<!--begin::Pagination-->
<div class="d-flex flex-stack flex-wrap pt-10">
    <div class="fs-6 fw-bold text-gray-700">Showing 1 to 10 of 50 entries</div>
    <!--begin::Pages-->
    <ul class="pagination">
        <li class="page-item previous">
            <a href="#" class="page-link">
                <i class="previous"></i>
            </a>
        </li>
        <li class="page-item active">
            <a href="#" class="page-link">1</a>
        </li>
        <li class="page-item">
            <a href="#" class="page-link">2</a>
        </li>
        <li class="page-item">
            <a href="#" class="page-link">3</a>
        </li>
        <li class="page-item">
            <a href="#" class="page-link">4</a>
        </li>
        <li class="page-item">
            <a href="#" class="page-link">5</a>
        </li>
        <li class="page-item">
            <a href="#" class="page-link">6</a>
        </li>
        <li class="page-item next">
            <a href="#" class="page-link">
                <i class="next"></i>
            </a>
        </li>
    </ul>
    <!--end::Pages-->
</div>
<!--end::Pagination-->
