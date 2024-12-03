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
                    <!-- Add JavaScript to auto hide the message after 5 seconds -->
                    <script>
                        setTimeout(function () {
                            let flashMessage = document.getElementById('flashMessage');
                            if (flashMessage) {
                                flashMessage.style.display = 'none';
                            }
                        }, 5000); // 5000ms = 5 seconds
                    </script>
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
                                                            <?php echo $key['attandancePdf']; ?>
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
                                                                        <a class="dropdown-item text-primary" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#updateDetailsModal">
                                                                            <i class="fa fa-edit"></i> Edit
                                                                            Details
                                                                        </a>
                                                                        <a class="dropdown-item text-primary" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#EditProgScheduleModel">
                                                                            <i class="fa fa-file"></i> Edit Prog. Schedule(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-primary" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#EditAttendanceModel">
                                                                            <i class="fa fa-file"></i> Edit Attendance(pdf)
                                                                        </a>
                                                                        <a class="dropdown-item text-primary" href="#"
                                                                            data-toggle="modal" data-target="#lockPdfModal">
                                                                            <i class="fa fa-file-lock"></i> Lock (pdf)
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
            <!-- model start  -->
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
                                    <?php //echo form_close(); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="save_add_Button">Save
                                Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /models end -->
            <!--update Modal Structure -->
            <!-- <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Update Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="updateForm" enctype="multipart/form-data">
                                <input type="hidden" id="prog_id" name="prog_id">
                                <table class="table table-bordered">
                                    <tr>
                                        <td style="width: 30%;"><label for="progTitle">Programme Title</label></td>
                                        <td><input type="text" class="form-control" id="progTitle" name="progTitle"
                                                placeholder=""></td>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;"><label for="date">Date</label></td>
                                        <td><input type="date" class="form-control" id="date" name="date"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;"><label for="progDirector">Programme Director</label>
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
                                        <td style="width: 30%;"><label for="progPdf">Programme Schedule in PDF</label>
                                        </td>
                                        <td><input type="file" class="form-control mt-2" id="progPdf" name="progPdf">
                                        </td>
                                    </tr>
                                    
                                </table>
                                <button type="submit" id="updateButton" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>



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
        <!-- /models end -->

    </div>
</div>
</div>
<!-- update details ajax -->
<!-- <script>

    $(document).ready(function () {
        // Populate Modal Fields
        $(document).on('click', '.update-btn', function () {

            const progId = $(this).closest('a').data('id');
            $('#prog_id').val(progId);


            // Optionally, you can fetch existing data via AJAX to populate fields.
            $.ajax({
                url: `<?php echo base_url('admin/getDetails'); ?>/${progId}`,
                type: 'POST',
                success: function (response) {
                    // Assuming `response` contains JSON data of the record
                    $('#progTitle').val(response.progTitle);
                    $('#targetGroup').val(response.targetGroup);
                    $('#date').val(response.date);
                    $('#progDirector').val(response.progDirector);
                    // Populate other fields as needed
                },
            });
        });

        // Submit Form via AJAX
        $('#updateButton').click(function () {
            const formData = new FormData($('#updateForm')[0]);

            $.ajax({
                url: '<?php echo base_url('admin/updateDetails'); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        alert('Details updated successfully!');
                        location.reload(); // Reload the page or update the table dynamically
                    } else {
                        alert('Failed to update details: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                },
            });
        });
    });

</script> -->

<?php include('template/footer.php'); ?>
<!-- /page content -->