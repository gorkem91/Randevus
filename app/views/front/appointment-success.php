<?php include VIEWPATH . 'front/header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <?php $this->load->view('message'); ?>
                        <h3 class="text-center"><?php echo translate('appointment_details'); ?></h3>
                        <div class="table-responsive">
                            <table class="table mdl-data-table">
                                <tr>
                                    <th class="font-bold dark-grey-text w-24"><?php echo translate('title'); ?></th>
                                    <td><?php echo $event_data['title']; ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('category'); ?></th>
                                    <td><?php echo $event_data['category_title']; ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('slot_time'); ?></th>
                                    <td><?php echo $event_data['slot_time'] . " " . translate('minute'); ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('city'); ?></th>
                                    <td><?php echo $event_data['city_title']; ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('location'); ?></th>
                                    <td><?php echo $event_data['loc_title']; ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('appointment_date'); ?></th>
                                    <td><?php echo date('d-m-Y h:i a', strtotime($event_data['start_date'] . " " . $event_data['start_time'])); ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                    <td><?php echo check_appointment_status($event_data['status']); ?></td>
                                </tr>
                                <tr>
                                    <th class="font-bold dark-grey-text"><?php echo translate('invoice'); ?></th>
                                    <td><a class="btn blue-gradient btn-sm" href="<?php echo base_url(UPLOAD_PATH . "invoice/" . $invoice_path); ?>" download target="_blank"><?php echo translate("download"); ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<?php include VIEWPATH . 'front/footer.php'; ?>