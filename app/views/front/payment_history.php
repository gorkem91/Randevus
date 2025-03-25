<?php include VIEWPATH . 'front/header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
    <!-- Start Container -->
    <div class="container">
        <h3 class="text-center mt-20"><?php echo translate('payment_history'); ?></h3>
        <section class="form-light px-2 sm-margin-b-20">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-12 m-auto">
                            <?php $this->load->view('message'); ?>
                            <div class="table-responsive">
                                <table class="table mdl-data-table table-striped" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-bold dark-grey-text">#</th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('title'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('price'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_method'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_status'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($payment_history) && count($payment_history) > 0) {
                                            foreach ($payment_history as $key => $row) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $key + 1; ?></td>
                                                    <td class="text-center"><?php echo $row['title']; ?></td>
                                                    <td class="text-center"><?php echo $row['payment_type'] == 'F' ? "Free" : price_format($row['price']); ?></td>
                                                    <td class="text-center"><?php echo $row['Payment_method'] == '' ? "-" : $row['Payment_method']; ?></td>
                                                    <td class="text-center"><?php echo $row['Payment_status'] == '' ? "-" : $row['Payment_status']; ?></td>
                                                    <td class="text-center"><?php echo date("m/d/Y", strtotime($row['payment_date'])); ?></td>

                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--col-md-12-->
                    </div>
                    <!--Row-->
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: 'mdl-data-table__cell--non-numeric'
                }
            ]
        });
    });
</script>
<?php include VIEWPATH . 'front/footer.php'; ?>