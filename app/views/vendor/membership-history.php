<?php
include VIEWPATH . 'vendor/header.php';
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
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('membership_history'); ?></h3>
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
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('price'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('max_event'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('remaining_event'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($membership_history) && count($membership_history) > 0) {
                                                foreach ($membership_history as $mem_key => $mem_row) {
                                                    if ($mem_row['membership_status'] == "A") {
                                                        $status_string = '<span class="alert alert-success">' . translate('active') . '</span>';
                                                    } else {
                                                        $status_string = '<span class="alert alert-danger">' . translate('expired') . '</span>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $mem_key + 1; ?></td>
                                                        <td class="text-center"><?php echo $mem_row['title']; ?></td>
                                                        <td class="text-center"><?php echo $mem_row['price']; ?></td>
                                                        <td class="text-center"><?php echo $mem_row['max_event']; ?></td>
                                                        <td class="text-center"><?php echo $mem_row['remaining_event']; ?></td>
                                                        <td class="text-center"><?php echo $status_string; ?></td>
                                                        <td class="text-center"><?php echo date("d-m-Y", strtotime($mem_row['created_on'])); ?></td>
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
include VIEWPATH . 'vendor/footer.php';
?>