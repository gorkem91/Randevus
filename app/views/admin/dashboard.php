<?php
include VIEWPATH . 'admin/header.php';
?>
<!-- start dashboard -->
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content pt-0">
        <!-- Start Container -->
        <div class="container-fluid">
            <!-- Start Section -->
            <div class="row">
                <div class="col-md-12 pt-2">
                    <?php $this->load->view('message'); ?>
                </div>
            </div>
            <!-- Card Color Section -->
            <section class="form-light content px-2 sm-margin-b-20 pt-0">
                <div class="row">
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a href='<?php echo base_url('admin/customer'); ?>' type="button" class="btn-floating mt-0 btn-lg blue-gradient ml-3 waves-effect waves-light"><i class="fa fa-user" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_customer; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('customer'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-12 col-12 text-left">
                                    <a href='<?php echo base_url('admin/customer'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('manage'); ?> <?php echo translate('customer'); ?></span></p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a href='<?php echo base_url('admin/vendor'); ?>' type="button" class="btn-floating mt-0 btn-lg deep-orange ml-3 waves-effect waves-light"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_vendor; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('vendor'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-12 col-12 text-left">
                                    <a href='<?php echo base_url('admin/vendor'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('manage'); ?> <?php echo translate('vendor'); ?></span></p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('admin/event'); ?>' class="btn-floating mt-0 success-color btn-lg dark-blue lighten-1 ml-3 waves-effect waves-light"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_event; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('event'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-7 col-7 text-left pr-0">
                                    <a href='<?php echo base_url('admin/event'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('manage'); ?> <?php echo translate('event'); ?></span></p></a>
                                </div>
                                <div class="col-md-5 col-5 text-right">
                                    <a href='<?php echo base_url('admin/add-event'); ?>'><p class="font-small grey-text"><span class="badge green"><?php echo translate('add'); ?></span> </p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('admin/manage-appointment'); ?>' class="btn-floating mt-0 btn-lg warning-color ml-3 waves-effect waves-light"><i class="fa fa-users" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_appointment; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('appointment'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-12 col-12 text-left">
                                    <a href='<?php echo base_url('admin/manage-appointment'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('manage'); ?> <?php echo translate('appointment'); ?></span></p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('admin/package-payment'); ?>' class="btn-floating mt-0 btn-lg blue-gradient ml-3 waves-effect waves-light"><i class="fa fa-trophy" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold">$<?php echo $total_my_wallet; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('earnings'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-12 col-12 text-left">
                                    <a href='javascript:void(0)'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('total'); ?> <?php echo translate('earnings'); ?></span></p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='javascript:void(0)' class="btn-floating mt-0 btn-lg success-color ml-3 waves-effect waves-light"><i class="fa fa-money" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo isset($total_payout_request) ? $total_payout_request : 0; ?></h5>
                                    <p class="font-small grey-text"><?php echo translate('total'); ?> <?php echo translate('payout_request'); ?></p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-12 col-12 text-left">
                                    <a href='<?php echo base_url('admin/payout-request'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue"><?php echo translate('manage'); ?> <?php echo translate('payout_request'); ?></span></p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->

                </div>
            </section>
            <!-- Card Color Section -->
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center"><?php echo translate('upcoming_appointment'); ?></h3>
                    <hr>
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
        <!-- End Container -->
    </div> 
    <!-- End Content -->
</div> 
<!-- End dashboard -->
<?php include VIEWPATH . 'admin/footer.php'; ?>
