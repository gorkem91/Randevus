<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('manage'); ?> <?php echo translate('appointment'); ?></h3>
                                </span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center font-bold dark-grey-text">#</th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('customer_name'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('slot_time'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('appointment_date'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('payment'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($appointment_data) && count($appointment_data) > 0) {
                                                foreach ($appointment_data as $key => $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $key + 1; ?></td>
                                                        <td class="text-center"><?php echo ucfirst($row['first_name']) . " " . ucfirst($row['last_name']); ?></td>
                                                        <td class="text-center"><?php echo $row['slot_time'] . " " . translate('minute'); ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['start_date'])) . " " . date('h:i a', strtotime($row['start_time'])); ?></td>
                                                        <td class="text-center"><?php echo check_appointment_pstatus($row['payment_status']); ?></td>
                                                        <td class="text-center"><?php echo check_appointment_status($row['status']); ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                                $created_by = $this->session->userdata('Vendor_ID');
                                                            } else {
                                                                $created_by = $this->session->userdata('ADMIN_ID');
                                                            }
                                                            if ($created_by == $row['created_by']) {
                                                                if ($row['status'] != 'A') {
                                                                    ?>
                                                                    <a id="" data-toggle="modal" onclick='AppointmentAction(this)' data-target="#appointment-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-floating btn-sm blue-gradient" title="<?php echo translate('appointment_action'); ?>"><i class="fa fa-eye"></i></a>
                                                                    <?php if ($row['start_date'] >= date("Y-m-d")) { ?>
                                                                        <a id="" data-toggle="modal" onclick='AppointmentReminderAction(this)' data-target="#remainder-appointment" data-id="<?php echo (int) $row['id']; ?>" class="btn-floating btn-sm blue-gradient" title="<?php echo translate('send_mail'); ?>"><i class="fa fa-envelope"></i></a>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<!-- Modal -->
<div class="modal fade" id="appointment-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="AppointmentRecordForm" name="AppointmentRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px;"><?php echo translate('appointment_action'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_val"><?php echo translate('change_status'); ?></label>
                        <select class="form-control d-block" name="status_val" id="status_val" required="">
                            <option value=""><?php echo translate('change_status'); ?></option>
                            <option value="C"><?php echo translate('completed'); ?></option>
                            <option value="A"><?php echo translate('approved'); ?></option>
                            <option value="P"><?php echo translate('pending'); ?></option>
                            <option value="R"><?php echo translate('rejected'); ?></option>
                            <option value="D"><?php echo translate('deleted'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" onclick="change_appointment(this);"><?php echo translate('confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="appointment-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="AppointmentRecordForm" name="AppointmentRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px;"><?php echo translate('appointment_action'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_val"><?php echo translate('change_status'); ?></label>
                        <select class="form-control d-block" name="status_val" id="status_val" required="">
                            <option value=""><?php echo translate('change_status'); ?></option>
                            <option value="C"><?php echo translate('completed'); ?></option>
                            <option value="A"><?php echo translate('approved'); ?></option>
                            <option value="P"><?php echo translate('pending'); ?></option>
                            <option value="R"><?php echo translate('rejected'); ?></option>
                            <option value="D"><?php echo translate('deleted'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" onclick="change_appointment(this);"><?php echo translate('confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="remainder-appointment">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="AppointmentRecordForm" name="AppointmentRemainderForm" method="post">
                <input type="hidden" id="event_book_id" name="event_book_id"/>
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px;"><?php echo translate('appointment_action'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="confirm_msg" style="font-size: 15px;"><?php echo translate('send_event_reminder'); ?></p>
                </div>
                <div class="modal-footer">
                    <button  class="btn purple-gradient btn-rounded" type="button" onclick="send_mail(this);"><?php echo translate('yes'); ?></button>
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('no'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    function change_appointment(e) {
        id = $("#record_id").val();
        folder_name = $("#folder_name").val();
        val = $("#status_val").val().toLowerCase();
        if ($('#AppointmentRecordForm').valid()) {
            $.ajax({
                url: site_url + folder_name + "/change-appointment/" + id + "/" + val,
                type: "post",
                data: {token_id: csrf_token_name},
                beforeSend: function () {
                    $("body").preloader({
                        percent: 10,
                        duration: 15000
                    });
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    }
    function send_mail(e) {
        var event_book_id = $("#event_book_id").val();
        var folder_name = $("#folder_name").val();
        $.ajax({
            url: site_url + folder_name + "/send-remainder",
            type: "post",
            data: {token_id: csrf_token_name, event_book_id : event_book_id},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                window.location.reload();
            }
        });

    }
    function AppointmentAction(e) {
        $('#record_id').val($(e).data('id'));
    }
    function AppointmentReminderAction(e) {
        $('#event_book_id').val($(e).data('id'));
    }

</script>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>