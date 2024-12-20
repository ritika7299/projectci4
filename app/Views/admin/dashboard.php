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
                                                <th class="text-center" style="width:5%;">#</th>
                                                <th class="text-center" style="width:20%;">Programme<br>
                                                    Title</th>
                                                <th class="text-center" style="width:10%;">Target<br>
                                                    Group</th>
                                                <th class="text-center" style="width:10%;">Date</th>
                                                <th class="text-center" style="width:10%;">Programme<br>
                                                    Director</th>
                                                <th class="text-center" style="width:12%;">Dealing<br>
                                                    Assitant</th>
                                                <th class="text-center" style="width:25%;">Programme<br>
                                                    Schedule<br>
                                                    <span class="text-danger">(Pdf)</span>
                                                </th>
                                                <th class="text-center" style="width:25%;">Attendance<br>
                                                    <span class="text-danger">(Pdf)</span>
                                                </th>
                                                <th class="text-center" style="width:25%;">Reading<br>
                                                    matrial</th>
                                                <th class="text-center" style="width:10%;">Payment Done</th>
                                                <th class="text-center" style="width:10%;">Action</th>
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
                                                        <td class="text-center text-capitalize text-wrap">
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
                                                        <!-- programs pdf -->
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php if (!empty($key['progPdf'])): ?>
                                                                <button type="button" class="btn btn-outline-primary" style="padding:
                                                                        8px 16px; font-size: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0,
                                                                        0.1);"
                                                                    onclick="window.open('<?= base_url('public/uploads/programsPdf/' . $key['progPdf']); ?>', '_blank');"
                                                                    title="Click to view the PDF">
                                                                    View PDF <i class="fa fa-eye"></i>
                                                                </button>
                                                                <br>
                                                                <?php
                                                                // Extract the username from the file name
                                                                $fileName = $key['progPdf'];
                                                                $fileParts = explode(' by ', $fileName); // Split the filename at ' by '
                                                                $uploadedBy = isset($fileParts[1]) ? $fileParts[1] : 'Unknown'; // Extract username or set as 'Unknown'
                                                                ?>
                                                                <span class="text-info">
                                                                    <?= 'uploaded by ' . $uploadedBy; ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-danger font-italic">No PDF Available</span>
                                                                <br>
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- /programs pdf end -->
                                                        <!-- attendance pdf -->
                                                        <td class="text-center text-capitalize text-wrap">
                                                            <?php if (!empty($key['attendancePdf'])): ?>
                                                                <button type="button" class="btn btn-outline-primary"
                                                                    style="padding: 8px 16px; font-size: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"
                                                                    onclick="window.open('<?= base_url('public/uploads/attendancePdf/' . $key['attendancePdf']); ?>', '_blank');"
                                                                    title="Click to view the PDF">
                                                                    View PDF <i class="fa fa-eye"></i>
                                                                </button>
                                                                <br>
                                                                <?php
                                                                // Extract the username from the file name
                                                                $fileName = $key['attendancePdf'];
                                                                $fileParts = explode(' by ', $fileName); // Split the filename at ' by '
                                                                $uploadedBy = isset($fileParts[1]) ? $fileParts[1] : 'Unknown'; // Extract username or set as 'Unknown'
                                                                ?>
                                                                <span class="text-info">
                                                                    <?= 'uploaded by ' . $uploadedBy; ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-danger font-italic">No PDF Available</span>
                                                                <br>
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- /attendance pdf end -->
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
                                                            <!-- actions -->
                                                            <div class="row d-flex">
                                                                <!-- edit and delete details action-->
                                                                <div role="presentation" class="dropdown">
                                                                    <a id="drop5" href="#" class="#" data-toggle="dropdown"
                                                                        aria-haspopup="true" role="button"
                                                                        aria-expanded="false">
                                                                        <i class="fa fa-bars fa-lg text-primary"></i>
                                                                    </a>
                                                                    <!-- edit details -->
                                                                    <div class="dropdown-menu mr-5"
                                                                        aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item text-primary edit_btn"
                                                                            id="edit_btn" href="#" data-toggle="modal"
                                                                            data-target="#editDetailsModal"
                                                                            data-id="<?php echo $key['prog_id']; ?>"
                                                                            value="<?php echo $key['prog_id']; ?>"
                                                                            title="Edit Details">
                                                                            <i class="fa fa-edit"></i> Edit Details
                                                                        </a>
                                                                        <!-- edit prog. Schedule pdf -->
                                                                        <a class="dropdown-item text-primary edit_btn_program"
                                                                            data-toggle="modal"
                                                                            data-target="#edit_program_pdf_Modal"
                                                                            data-id="<?php echo $key['prog_id']; ?>"
                                                                            value="<?php echo $key['prog_id']; ?>"
                                                                            title="Edit program pdf">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit Prog.
                                                                            Schedule(pdf)
                                                                        </a>
                                                                        <!-- edit attendance Schedule pdf -->
                                                                        <a class="dropdown-item text-primary edit_btn_attendance"
                                                                            href="#" data-toggle="modal"
                                                                            data-target="#edit_attendance_pdf_Modal"
                                                                            data-id="<?php echo $key['prog_id']; ?>"
                                                                            value="<?php echo $key['prog_id']; ?>"
                                                                            title="Edit Attendance pdf">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit
                                                                            Attendance(pdf)
                                                                        </a>
                                                                        <!-- lock pdf details -->
                                                                        <a class="dropdown-item text-primary lock-btn" href="#"
                                                                            onclick="lockActions('<?php echo $key['prog_id']; ?>')">
                                                                            <i class="fa fa-lock"></i> Lock Details
                                                                        </a>
                                                                        <!-- delete details -->
                                                                        <a class="dropdown-item text-primary delete-btn"
                                                                            href="#"
                                                                            onclick="confirmDelete('<?php echo base_url('admin/delete/' . $key['prog_id']); ?>');">
                                                                            <i class="fa fa-trash"></i> Delete
                                                                            details
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <style>
                                                            .dropdown-item.disabled {
                                                                color: #ccc;
                                                                /* Light gray color to indicate disabled state */
                                                                pointer-events: none;
                                                                /* Prevent interactions */
                                                            }
                                                        </style>
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
                                    method="POST" enctype="multipart/form-data">
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
                                                    accept="image/*,application/pdf">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf"
                                                    name="attendancePdf" accept="image/*,application/pdf">
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
            <div class="modal fade" id="edit_program_pdf_Modal" tabindex="-1" role="dialog"
                aria-labelledby="editProgramPdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="editProgramPdfModalLabel">Edit Program Schedule
                                <i class="fa fa-file-pdf-o"></i>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details"
                                    action="<?php echo base_url('/admin/updateProgramRecord'); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle_id"
                                                    name="progTitle" value="" placeholder="" readonly></td>
                                            <td class="d-none"><input type="text" class="form-control" id="progidd"
                                                    name="progid" value="" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="progPdf_11">Programme Schedule in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf_666"
                                                    name="progPdf">
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf"
                                                    name="attendancePdf">
                                            </td>
                                        </tr> -->
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
            </div>
            <!-- /end program (pdf)  -->
            <!-- edit attendance(pdf) details modal -->

            <div class="modal fade" id="edit_attendance_pdf_Modal" tabindex="-1" role="dialog"
                aria-labelledby="editProgramPdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2A3F54;">
                            <h5 class="modal-title text-white" id="editProgramPdfModalLabel">Edit Attendance pdf
                                <i class="fa fa-file-pdf-o"></i>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details"
                                    action="<?php echo base_url('/admin/updateAttendanceRecord'); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;">
                                                <label for="progTitle">Programme Title</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="att_Title_id"
                                                    name="attTitle" value="" placeholder="" readonly>
                                            </td>
                                            <td class="d-none"><input type="text" class="form-control" id="attidd"
                                                    name="progid" value="" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf_666"
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

            </div>
        </div>
    </div>
</div>
<!-- JQUERY.MIN.JS v-3.7.1 created by ritika  -->
<script src="<?php echo base_url("../public/assets/build/js/jquery.min.js"); ?>"></script>
<!-- details edit script  -->
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
<!-- /details edit script end -->
<!-- edit programs and attendance pdf script -->
<!-- programs pdf -->
<script>
    $(".edit_btn_program").click(function () {
        // alert("ProgramsPDF");
        var progId = $(this).data('id');
        // alert(progId);
        $("#progidd").val(progId);
        // $("#progTitle").val(progTitle);
        // alert("progId:" + progId);
        $.ajax({
            url: '<?php echo base_url() . "/admin/get-data-for-program/" ?>',
            dataType: 'json',
            contentType: 'application/json',
            type: 'GET',
            data: {
                prog_id: progId,//all, branch, court, both, individual, deputation & diverted
            },
            beforeSend: function () { },
            success: function (data) {
                console.log(data);
                //     alert(data[0]['progid']);
                $("#progTitle_id").val(data[0]['progTitle']);
                $("#progid").val(data[0]['prog_id']);
            },
            error: function (data) {
                console.log(data);
            }
        }).done(function (data) {
        });
    });
</script>
<!-- attendance pdf -->
<script>
    $(".edit_btn_attendance").click(function () {
        // alert("AttendancePDF");                 // alert for attendance pdf 
        var progId = $(this).data('id');
        // alert(progId);                          // alert for program ID
        $("#attidd").val(progId);
        // $("#att_Title_id").val(progTitle);
        // alert("progId:" + progId);              // alert again for program ID
        $.ajax({

            url: '<?php echo base_url() . "/admin/get-data-for-program/" ?>',
            dataType: 'json',
            contentType: 'application/json',
            type: 'GET',
            data: {
                prog_id: progId,//all, branch, court, both, individual, deputation & diverted
            },

            beforeSend: function () { },
            success: function (data) {
                console.log(data);
                //   alert(data[0]['progid']);
                $("#att_Title_id").val(data[0]['progTitle']);
                $("#attid").val(data[0]['prog_id']);
            },
            error: function (data) {
                console.log(data);
            }
        }).done(function (data) {
        });
    });

</script>
<!-- /edit programs and attendance pdf script -->
<!-- this script for lock details  -->
<script>
    // Key to store locked state in localStorage
    const LOCK_STORAGE_KEY = 'lockedActions';

    // Initialize locked actions on page load
    document.addEventListener('DOMContentLoaded', function () {
        const lockedActions = JSON.parse(localStorage.getItem(LOCK_STORAGE_KEY)) || [];

        // Disable locked actions
        lockedActions.forEach(progId => {
            disableDropdownActions(progId);
        });
    });
    // Function to lock actions for a specific prog_id
    function lockActions(progId) {
        // Retrieve current locked state
        let lockedActions = JSON.parse(localStorage.getItem(LOCK_STORAGE_KEY)) || [];

        // Check if the row is already locked
        if (lockedActions.includes(progId)) {
            Swal.fire({
                icon: 'info',
                title: 'Already Locked',
                text: 'This actions is already locked. Locked actions cannot be changed or modified.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
            return; // Exit the function if already locked
        }
        // Show confirmation dialog before locking actions
        Swal.fire({
            icon: 'warning',
            title: 'Confirm Lock',
            text: 'Are you sure you want to lock these actions? Locked actions cannot be changed or modified.',
            showCancelButton: true, // Enable the Cancel button
            confirmButtonText: 'Yes, Lock it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6', // Blue for confirm
            cancelButtonColor: '#d33' // Red for cancel
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, lock the actions
                lockedActions.push(progId);
                localStorage.setItem(LOCK_STORAGE_KEY, JSON.stringify(lockedActions));
                disableDropdownActions(progId);
                // Show feedback message after locking
                Swal.fire({
                    icon: 'info',
                    title: 'Details Locked',
                    text: 'If all actions are locked, they cannot be changed or modified.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Optional: Add logic if the user cancels, e.g., show a canceled message
                Swal.fire({
                    icon: 'info',
                    title: 'Action Canceled',
                    text: 'No changes have been made.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Function to disable dropdown actions for a specific prog_id
    function disableDropdownActions(progId) {
        const dropdownMenu = document.querySelectorAll(`.dropdown-menu [data-id="${progId}"]`);
        dropdownMenu.forEach(item => {
            item.classList.add('disabled');
            item.setAttribute('aria-disabled', 'true');
            item.removeAttribute('href'); // Disable the href to prevent navigation
        });

        // Disable delete action explicitly
        const deleteBtn = document.querySelector(`.dropdown-menu .delete-btn[href *= "${progId}"]`);
        if (deleteBtn) {
            deleteBtn.classList.add('disabled');
            deleteBtn.setAttribute('aria-disabled', 'true');
            deleteBtn.removeAttribute('href');
        }
        // Disable delete action explicitly
        const lockBtn = document.querySelector(`.dropdown-menu .lock-btn[href *= "${progId}"]`);
        if (lockBtn) {
            lockBtn.classList.add('disabled');
            lockBtn.setAttribute('aria-disabled', 'true');
            lockBtn.removeAttribute('href');
        }
    }

    // Function to unlock actions (optional, for reset functionality)
    function unlockActions(progId) {
        // Retrieve current locked state
        let lockedActions = JSON.parse(localStorage.getItem(LOCK_STORAGE_KEY)) || [];
        lockedActions = lockedActions.filter(id => id !== progId); // Remove the progId
        localStorage.setItem(LOCK_STORAGE_KEY, JSON.stringify(lockedActions));

        // Re-enable dropdown actions
        const dropdownMenu = document.querySelectorAll(`.dropdown-menu [data-id="${progId}"]`);
        dropdownMenu.forEach(item => {
            item.classList.remove('disabled');
            item.removeAttribute('aria-disabled');
            item.setAttribute('href', '#'); // Restore href
        });

        // Re-enable delete action explicitly
        const deleteBtn = document.querySelector(`.dropdown-menu .delete-btn[href *= "${progId}"]`);
        if (deleteBtn) {
            deleteBtn.classList.remove('disabled');
            deleteBtn.removeAttribute('aria-disabled');
            deleteBtn.setAttribute('href', '<?php echo base_url("admin/delete/"); ?>' + progId);
        }
    }
</script>
<!-- /this script for lock details  -->
<style>
    .dropdown-item.disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
<!-- delete details -->
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirect to the delete URL
            }
        });
    }
</script>

<!-- this script for session expire time -->
<script>
    // Get the session expiration time passed from PHP
    let sessionExpiryTime = <?= $session_expiry_time ?>; // The timestamp when the session will expire
    let lastActivityTime = Date.now(); // Store the last activity time (initially the page load time)
    let inactivityLimit = 120 * 1000; // 10 minute in milliseconds

    // Function to reset the inactivity timer on user activity
    function resetInactivityTimer() {
        lastActivityTime = Date.now(); // Reset the last activity time
    }
    // Attach event listeners for user activity (mousemove, keypress)
    document.addEventListener("mousemove", resetInactivityTimer);
    document.addEventListener("keypress", resetInactivityTimer);
    document.addEventListener("click", resetInactivityTimer);

    // Update the countdown every second
    let countdown = setInterval(function () {
        let currentTime = Math.floor(Date.now() / 1000); // Get the current time in seconds
        let remainingTime = sessionExpiryTime - currentTime; // Calculate the remaining time in seconds


        // Check for inactivity (if the last activity was more than 1 minute ago)
        if (Date.now() - lastActivityTime > inactivityLimit) {
            // If inactive for more than 1 minute, consider the session expired
            clearInterval(countdown); // Stop the countdown

            // Show SweetAlert for session expiry
            Swal.fire({
                title: 'Session Expired',
                text: 'You have been inactive for too long. Please log in again.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false, // Disable closing by clicking outside
                allowEscapeKey: false, // Disable closing with escape key
            }).then(() => {
                // Redirect to login page after SweetAlert closes
                window.location.href = "/"; // Modify this URL as per your requirement
            });
        } else {
            // Calculate minutes and seconds
            let minutes = Math.floor(remainingTime / 60);
            let seconds = remainingTime % 60;
            document.getElementById("session-timer").innerText = `Session will expire in: ${minutes}m ${seconds}s`;
        }
    }, 1000); // Update every 1 second
</script>
<?php include('template/footer.php'); ?>
<!-- /page content -->