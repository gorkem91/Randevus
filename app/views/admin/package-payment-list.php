<?php
include VIEWPATH . 'admin/header.php';
?>
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
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('package_payment'); ?></h3>
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
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('name'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('title'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('price'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('max_event'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('remaining_event'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($payment_history) && count($payment_history) > 0) {
                                                foreach ($payment_history as $payment_key => $payment_row) {
                                                    if ($payment_row['membership_status'] == "A") {
                                                        $status_string = '<span class="alert alert-success">' . translate('active') . '</span>';
                                                    } else {
                                                        $status_string = '<span class="alert alert-danger">' . translate('expired') . '</span>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $payment_key + 1; ?></td>
                                                        <td class="text-center"><?php echo ucfirst($payment_row['first_name']) . " " . ucfirst($payment_row['last_name']); ?></td>
                                                        <td class="text-center"><?php echo $payment_row['title']; ?></td>
                                                        <td class="text-center"><?php echo price_format(number_format($payment_row['price'], 0)); ?></td>
                                                        <td class="text-center"><?php echo $payment_row['max_event']; ?></td>
                                                        <td class="text-center"><?php echo $payment_row['remaining_event']; ?></td>
                                                        <td class="text-center"><?php echo $status_string; ?></td>
                                                        <td class="text-center"><?php echo date("d-m-Y", strtotime($payment_row['created_on'])); ?></td>
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
<?php
include VIEWPATH . 'admin/footer.php';
?>