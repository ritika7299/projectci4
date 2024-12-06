<!-- page content -->
<?php include('template/header.php'); ?>
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: inline-block">
            <!-- main content -->
            <div class="col-md-12 col-lg-12">
                <div class="x_panel">
                    <div class="title float-right mb-2 mt-2" id="flashMessage">
                        <?php if (session()->getFlashdata('success')): ?>
                            <span class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </span>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <span class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-1">
                        <div class="add-details mt-5">
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
                                <div class="">
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
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
                                                <!-- <th class="text-center" style="width:15%;">User<br>
                                                    Images</th> -->
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
                                                            <?php echo $key['progPdf']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize text-wrap"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <?php echo $key['attendancePdf']; ?>
                                                        </td>
                                                        <td class="text-center text-capitalize"
                                                            style="word-wrap: break-word; white-space: normal;">
                                                            <a href="<?php echo $key['materialLink']; ?>" target="_blank">
                                                                <?php echo $key['materialLink']; ?>
                                                            </a>
                                                        </td>
                                                        <!-- <td class="text-center text-capitalize"
                                                            style="word-wrap: break-word; white-space: normal;"> -->
                                                        <!-- <a href="<?php //echo $key['']; ?>" target="_blank">
                                                                <?php //echo $key['']; ?>
                                                            </a> -->
                                                        <!-- <i class="fa fa-eye"></i>
                                                        </td> -->
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
                                                                            title="Edit Details">
                                                                            <i class="fa fa-edit"></i> Edit
                                                                            Details
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#EditProgScheduleModel">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit Prog.
                                                                            Schedule(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#EditAttendanceModel">
                                                                            <i class="fa fa-file-pdf-o"></i> Edit
                                                                            Attendance(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-dark" href="#"
                                                                            data-toggle="modal" data-target="#lockPdfModal">
                                                                            <i class="fa fa-lock"></i> Lock (pdf)
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
                                                                <div class="delete-details ml-2 mr-3">
                                                                    <a
                                                                        href="<?php echo base_url("admin/delete/" . $key['prog_id']); ?>">
                                                                        <i class="fa fa-trash text-danger fa-lg delete-btn"
                                                                            name="prog_id"></i>
                                                                    </a>
                                                                </div>
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
                        <div class="modal-header bg-primary">
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
                                                    value="" placeholder=""></td>
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
                                            <td><input type="date" class="form-control" value="" id="date" name="date">
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
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf"
                                                    name="progPdf">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attendancePdf"
                                                    name="attendancePdf">
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
                                        <tr></tr>
                                    </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="save_add_Button">Save <i
                                    class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /end add details modal  -->
            <!--edit details modal  -->
            <div class="modal fade" id="editDetailsModal" tabindex="-1" role="dialog"
                aria-labelledby="editDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="editDetailsModalLabel">Edit Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-area custom-background">
                                <form id="edit_form_details" action="<?php echo base_url('/admin/updateRecord'); ?>"
                                    method="POST">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                            <td><input type="text" class="form-control" id="progTitle" name="progTitle"
                                                    value="" placeholder=""></td>
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
                                            <td><input type="date" class="form-control" value="" id="date" name="date">
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
                                            </td>
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
                                            <td><input type="file" class="mt-2 text-primary" id="progPdf"
                                                    name="progPdf">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;"><label for="attandancePdf">Attendance in
                                                    PDF</label>
                                            </td>
                                            <td><input type="file" class="mt-2 text-primary" id="attandancePdf"
                                                    name="attandancePdf">
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
                                        <tr></tr>
                                    </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="edit_Button">Save <i
                                    class="fa fa-paper-plane"></i>
                            </button>
                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div>
            <!--/end edit details modal -->
            <!-- lock Pdf modal -->
            <!-- <div class="modal fade" id="lockPdfModal" tabindex="-1" role="dialog" aria-labelledby="lockPdfModalLabel"
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
        </div> -->
            <!-- /lock Pdf modal -->
        </div>


    </div>
</div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- JQUERY.MIN.JS v-3.7.1 created by ritika  -->
<script src="<?php echo base_url("../public/assets/build/js/jquery.min.js"); ?>"></script>
<script>
    $("#edit_btn").click(function () {
        alert();
        var progId = $(this).data('id');
        alert(progId);
        $.ajax({
            url: '<?php echo base_url() . "/admin/get-data-for-update/" ?>',
            dataType: 'json',
            contentType: 'application/json',
            type: 'GET',
            data: {
                prog_id: progId,

            },
            beforeSend: function () { },
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        }).done(function (data) {

            if (data != '') {
                alert("hh");
            } else {
                alert("jj");
            }
            $("#prog_id").val(data['prog_id']);
            $("#prog_id1").val(data[0]['progTitle']);
            $("#prog_id2").val(data[0]['paymentdone']);
            $("#prog_id3").val(data[0]['date']);
            // $("#progTitle").val(data[0]['prog_id']);
            $("#targetGroup").val(data[0]['progTitle']);
        });
        // alert('prog_id1');
        // die;
        //console.log('prog_id1');
    });
</script>
<!-- <script>
    $("#edit_btn").click(function () {
        var progId = $(this).data('id'); // Get the program ID from the clicked button
        $.ajax({
            url: '<?php echo base_url() . "/admin/updateRecord"; ?>',
            dataType: 'json',
            type: 'GET',
            data: {
                prog_id: progId
            },
            success: function (data) {
                if (data.status === 'success' && data.data) {
                    // Fill in the modal form fields
                    var record = data.data;
                    $("#prog_id").val(record.progTitle);
                    $("#targetGroup").val(record.targetGroup);
                    $("#date").val(record.date);
                    $("#progDirector").val(record.progDirector);
                    $("#dealingAsstt").val(record.dealingAsstt);
                    $("#materialLink").val(record.materialLink);
                    $("#paymentdone").val(record.paymentdone);

                    // Show the modal
                    $('#editDetailsModal').modal('show');
                } else {
                    alert("No data found or error occurred");
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                alert("Something went wrong while fetching data.");
            }
        });
    });
</script> -->


<?php include('template/footer.php'); ?>
<!-- /page content -->