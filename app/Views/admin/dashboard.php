<!-- page content -->
<?php include('template/header.php'); ?>
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: inline-block;width:fixed">
            <!-- main content -->
            <div class="col-md-12 col-lg-12">
                <div class="x_panel">
                    <!-- show success and error messages through SweetAlert -->
                    <div class="title float-right mb-2 mt-2" id="flashMessage">
                        <?php if (session()->getFlashdata('success')): ?>
                            <!-- Success message in SweetAlert -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    Swal.fire({
                                        icon: 'success',
                                        text: '<?= addslashes(session()->getFlashdata('success')) ?>',
                                        timer: 2000,
                                        showConfirmButton: false,  // Hide the OK button
                                        willClose: () => { // Optional: you can add any additional actions when the alert closes
                                            // You can do something after the alert closes, like redirecting
                                        }
                                    });
                                });
                            </script>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <!-- Error message in SweetAlert -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    Swal.fire({
                                        icon: 'error',
                                        text: '<?= addslashes(session()->getFlashdata('error')) ?>',
                                        timer: 2000,
                                        showConfirmButton: false,  // Hide the OK button
                                        willClose: () => { // Optional: you can add any additional actions when the alert closes
                                            // You can do something after the alert closes, like redirecting
                                        }
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    </div>
                    <!-- success and error messages  -->
                    <!-- <div class="title float-right mb-2 mt-2" id="flashMessage">
                        <?php //if (session()->getFlashdata('success')): ?>
                            <span class="alert alert-success"><i class="fa fa-check"></i>
                                <?//= session()->getFlashdata('success') ?>
                            </span>
                        <?php //endif; ?>
                        <?php //if (session()->getFlashdata('error')): ?>
                            <span class="alert alert-danger"><i class="fa fa-warning"></i>
                                <?//= session()->getFlashdata('error') ?>
                            </span>
                        <?php //endif; ?>
                    </div> -->
                    <div class="mb-1">
                        <div class="add-details mt-1">
                            <button type="submit" class="btn btn-primary float-right mt-0 mb-0" data-toggle="modal"
                                data-target="#addDetailsModal">
                                Add Details <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Add Search Bar -->
                    <div class="col-2 mb-1" style="margin-left: -11px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search..." />
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="fixed">
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap datatable-responsive"
                                        cellspacing="0" width="100%">
                                        <thead class="text-center mt-0">
                                            <tr>
                                                <th class="text-center" style="width:10%;">#</th>
                                                <th class="text-center" style="width:20%;">Programme<br>
                                                    Title</th>
                                                <th class="text-center" style="width:15%;">Target<br>
                                                    Group</th>
                                                <th class="text-center" style="width:15%;">Date</th>
                                                <th class="text-center" style="width:15%;">Programme<br>
                                                    Director</th>
                                                <th class="text-center" style="width:15%;">Dealing<br>
                                                    Assitant</th>
                                                <th class="text-center" style="width:25%;">Programme<br>
                                                    Schedule<br>
                                                    (In pdf)</th>
                                                <th class="text-center" style="width:25%;">Attendance<br>
                                                    (In pdf)</th>
                                                <th class="text-center" style="width:25%;">Reading<br>
                                                    matrial</th>

                                                <th class="text-center" style="width:15%;">Payment Done</th>
                                                <th class="text-center" style="width:25%;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php $i = 1;
                                        if ($prog_data) {
                                            // print_r($prog_data);die;
                                            foreach ($prog_data as $key) { ?>
                                                <tbody id="form_details_table">
                                                    <tr>
                                                        <td class="text-center text-capitalize">
                                                            <?php echo $i++; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php echo $key['progTitle']; ?>
                                                        </td>
                                                        <td c class="text-center text-capitalize text-wrap">
                                                            <?php echo $key['targetGroup']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php echo $key['date']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php echo $key['progDirector']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php echo $key['dealingAsstt']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <?php echo $key['progPdf'] . ' - by ' . $_SESSION['name']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <?php echo $key['attendancePdf'] . ' - by ' . $_SESSION['name']; ?>
                                                        </td>
                                                        <!-- <td class="text-center text-capitalize text-wrap"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <?php //echo $key['progPdf']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <?php //echo $key['attendancePdf']; ?>
                                                        </td> -->
                                                        <td class="text-center text-success"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <a href="<?php echo $key['materialLink']; ?>" target="_blank">
                                                                <?php echo $key['materialLink']; ?>
                                                            </a>
                                                        </td>
                                                        <td
                                                            class="text-center text-capitalize text-wrap 
                                                        <?php echo ($key['paymentdone'] == 'yes') ? 'text-success' : 'text-danger'; ?>">
                                                            <?php echo ucfirst($key['paymentdone']); ?>
                                                        </td>
                                                        <td class="">
                                                            <!-- edit and delete actions -->
                                                            <div
                                                                class="row d-flex justify-content-between align-items-start w-100">
                                                                <!-- edit details-->
                                                                <div role="presentation" class="dropdown ml-4">
                                                                    <a id="drop5" href="#" class="#" data-toggle="dropdown"
                                                                        aria-haspopup="true" role="button"
                                                                        aria-expanded="false">
                                                                        <i class="fa fa-bars fa-lg text-primary"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu"
                                                                        aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item text-dark edit_btn"
                                                                            id="edit_btn" href="#" data-toggle="modal"
                                                                            data-target="#editDetailsModal"
                                                                            data-id="<?php echo $key['prog_id']; ?>"
                                                                            value="<?php echo $key['prog_id']; ?>"
                                                                            title="Edit Details">
                                                                            <i class="fa fa-edit"></i> Edit
                                                                            Details
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#edit_program_pdf_Modal">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit Prog.
                                                                            Schedule(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#edit_attendance_pdf_Modal">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit
                                                                            Attendance(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal" data-target="#lockPdfModal">
                                                                            <i class="fa fa-lock"></i> Lock (pdf)
                                                                        </a>
                                                                        <!-- for delete details -->
                                                                        <a class="dropdown-item text-dark"
                                                                            href="<?php echo base_url("admin/delete/" . $key['prog_id']); ?>">
                                                                            <i class="fa fa-trash fa-lg delete-btn"
                                                                                name="prog_id"></i> Delete details
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <!-- Trigger Button -->
                                                                <!-- <div class="update-details ml-2 mr-3">
                                                                    <a href="#" data-toggle="modal" data-target="#updateModal"
                                                                        data-id="<?php //echo $key['prog_id']; ?>">
                                                                        <i class="fa fa-edit text-primary fa-lg update-btn"
                                                                            name="prog_id"></i>
                                                                    </a>
                                                                </div> -->
                                                                <!-- <div class="delete-details ml-2 mr-3">
                                                                    <a
                                                                        href="<?php //echo base_url("admin/delete/" . $key['prog_id']); ?>">
                                                                        <i class="fa fa-trash text-danger fa-lg delete-btn"
                                                                            name="prog_id"></i>
                                                                    </a>
                                                                </div> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                        } else { ?>
                                                <tr>
                                                    <td colspan="11" class="text-center text-danger">No Data Found
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <!-- modals start  -->
            <!-- add details modal -->
            <div class="modal fade" id="addDetailsModal" tabindex="-1" role="dialog"
                aria-labelledby="addDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="addDetailsModalLabel">Add Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="add_form_details" action="<?php echo base_url('/admin/saveDetails'); ?>"
                                    method="POST">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle" name="progTitle"
                                                    value="" placeholder="" required></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="targetGroup">Target Group</label></td>
                                            <td>
                                                <select class="form-control" id="targetGroup" name="targetGroup">
                                                    <option value="">Select</option>
                                                    <option value="TG-1">TG-1</option>
                                                    <option value="TG-2">TG-2</option>
                                                    <option value="TG-3">TG-3</option>
                                                </select>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="date">Date</label></td>
                                            <td><input type="date" class="form-control" value="" id="date" name="date"
                                                    required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="progDirector">Programme
                                                    Director</label>
                                            </td>
                                            <td>
                                                <select class="form-control" id="progDirector" name="progDirector">
                                                    <option value="">Select</option>
                                                    <option value="PD-1">PD-1</option>
                                                    <option value="PD-2">PD-2</option>
                                                    <option value="PD-3">PD-3</option>
                                                </select>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="dealingAsstt">Dealing Assistant</label>
                                            </td>
                                            <td>
                                                <select class="form-control" id="dealingAsstt" name="dealingAsstt">
                                                    <option value="">Select</option>
                                                    <option value="DA-1">DA-1</option>
                                                    <option value="DA-2">DA-2</option>
                                                    <option value="DA-3">DA-3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="progPdf">Programme Schedule in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf" name="progPdf"
                                                    accept="image/*,application/pdf" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf"
                                                    name="attendancePdf" accept="image/*,application/pdf" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="materialLink">Reading Material
                                                    Link</label>
                                            </td>
                                            <td><input class="form-control" id="materialLink" name="materialLink"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="paymentdone">Payment Done</label></td>
                                            <td>
                                                <select class="form-control" id="paymentdone" name="paymentdone">
                                                    <option value="">Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="save_add_Button"
                                style="background-color: #2A3F54;">Save <i class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /end add details modal  -->
            <!--update or edit details modal  -->
            <div class="modal fade" id="editDetailsModal" tabindex="-1" role="dialog"
                aria-labelledby="editDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="editDetailsModalLabel">Edit Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details" action="<?php echo base_url('/admin/updateDetails'); ?>"
                                    method="POST">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle_666"
                                                    name="progTitle" value="" placeholder=""></td>
                                            <td style="display: none;"><input type="text" class="form-control"
                                                    id="progid" name="progid" value="" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="targetGroup_666">Target Group</label>
                                            </td>
                                            <td>
                                                <select class="form-control" id="targetGroup_666" name="targetGroup">
                                                    <option value="">Select</option>
                                                    <option value="TG-1">TG-1</option>
                                                    <option value="TG-2">TG-2</option>
                                                    <option value="TG-3">TG-3</option>
                                                </select>

                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="date">Date</label></td>
                                            <td><input type="date" class="form-control" value="" id="date_666"
                                                    name="date">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="progDirector">Programme
                                                    Director</label>
                                            </td>
                                            <td>
                                                <select class="form-control" id="progDirector_666" name="progDirector">
                                                    <option value="">Select</option>
                                                    <option value="PD-1">PD-1</option>
                                                    <option value="PD-2">PD-2</option>
                                                    <option value="PD-3">PD-3</option>
                                                </select>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="dealingAsstt">Dealing Assistant</label>
                                            </td>
                                            <td>
                                                <select class="form-control" id="dealingAsstt_666" name="dealingAsstt">
                                                    <option value="">Select</option>
                                                    <option value="DA-1">DA-1</option>
                                                    <option value="DA-2">DA-2</option>
                                                    <option value="DA-3">DA-3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td style="width: 30%;"><label for="progPdf">Programme Schedule in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf_666"
                                                    name="progPdf_edit">
                                            </td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attandancePdf"
                                                    name="attandancePdf">
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <td style="width: 30%;"><label for="materialLink">Reading Material
                                                    Link</label>
                                            </td>
                                            <td><input type="text" class="form-control" id="materialLink_666"
                                                    name="materialLink" value="" placeholder=""></td>
                                            <!-- <input class="form-control" id="materialLink_666" name="materialLink"></td> -->
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="paymentdone">Payment Done</label></td>
                                            <td>
                                                <select class="form-control" id="paymentdone_666" name="paymentdone">
                                                    <option value="">Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                    </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="edit_Button"
                                style="background-color: #2A3F54;">Edit Details <i class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div>
            <!--/end update or edit details modal -->
            <!-- edit Program(pdf) details modal -->
            <!-- <div class="modal fade" id="edit_program_pdf_Modal" tabindex="-1" role="dialog"
                aria-labelledby="editProgramPdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="editProgramPdfModalLabel">Edit Program Schedule PDF
                                <i class="fa fa-file-pdf-o"></i>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details" action="<?php //echo base_url('/admin/edit_prog_schedule_pdf'); ?>" method="POST">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle" name="progTitle"
                                                    value="Demo" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="progPdf">Programme Schedule in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf"
                                                    name="progPdf">
                                            </td>
                                        </tr>
                                    </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="edit_Button"
                                style="background-color: #2A3F54;">Update <i class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div> -->
            <!-- /end program (pdf)  -->
            <!-- edit attendance(pdf) details modal -->
            <!-- <div class="modal fade" id="edit_attendance_pdf_Modal" tabindex="-1" role="dialog"
                aria-labelledby="editAttendancePdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="editAttendancePdfModalLabel">Edit Attendance PDF
                                <i class="fa fa-file-pdf-o"></i>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details" action="<?php //echo base_url('/admin/edit_attendance_pdf'); ?>" method="POST">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle" name="progTitle"
                                                    value="Demo" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf"
                                                    name="attendancePdf">
                                            </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="edit_Button"
                                style="background-color: #2A3F54;">Update <i class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div> -->
            <!-- /end program (pdf)  -->
            <!-- lock Pdf modal -->
            <div class="modal fade" id="lockPdfModal" tabindex="-1" role="dialog" aria-labelledby="lockPdfModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #d9534f;">
                            <h5 class="modal-title text-white" id="lockPdfModalLabel">Lock PDF</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-danger">
                                <strong>Are you sure you want to lock this PDF?</strong>
                            </p>
                            <p class="text-center text-muted">
                                Once locked, the PDF cannot be modified or changed.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmLockButton">Lock PDF</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /lock Pdf modal -->
            <!-- user images modal  -->
            <!-- <div class="modal fade" id="user_images_modal" tabindex="-1" role="dialog"
                aria-labelledby="UserImagesModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="UserImagesModalLabel">User Images</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="images-area">
                                <div class="row d-flex">
                                    <div class="col-md-3">
                                        <img src="uploads/user_images/123.png" accept="image/*" alt="" width="100%" height="">
                                    </div>
                                    <div class="col-md-3">
                                        <img src="uploads/user_images/123.png" accept="image/*" alt="" width="100%" height="">
                                    </div>
                                </div>
                                <div class="row d-flex">
                                    <div class="col-md-3">
                                        <img src="uploads/user_images/123.png" accept="image/*" alt="" width="100%" height="">
                                    </div>
                                    <div class="col-md-3">
                                        <img src="uploads/user_images/123.png" accept="image/*" alt="" width="100%" height="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- /end user images modal -->
        </div>
    </div>
</div>
</div>
<!-- JQUERY.MIN.JS v-3.7.1 created by ritika  -->
<script src="<?php echo base_url("../public/assets/build/js/jquery.min.js"); ?>"></script>
<script>

    $(".edit_btn").click(function () {

        // alert("sameer");
        var progId = $(this).data('id');
        // alert(progId);
        // alert("progId:" + progId);

        $.ajax({

            url: '<?php echo base_url() . "/admin/get-data-for-update/" ?>',
            dataType: 'json',
            contentType: 'application/json',
            type: 'GET',
            data: {
                prog_id: progId,//all, branch, court, both, individual, deputation & diverted


            },
            beforeSend: function () { },
            success: function (data) {
                // console.log(data);
                // alert(data[0]['progTitle']);
                $("#progTitle_666").val(data[0]['progTitle']);
                $("#targetGroup_666").val(data[0]['targetGroup']);
                $("#date_666").val(data[0]['date']);
                $("#progDirector_666").val(data[0]['progDirector']);
                $("#dealingAsstt_666").val(data[0]['dealingAsstt']);
                // $("#progPdf_666").val(data[0]['progPdf']);
                $("#materialLink_666").val(data[0]['materialLink']);
                $("#paymentdone_666").val(data[0]['paymentdone']);

                $("#progid").val(data[0]['prog_id']);
            },




            error: function (data) {
                console.log(data);
            }
        }).done(function (data) {
        });
    });

</script>


<?php include('template/footer.php'); ?>
<!-- /page content -->