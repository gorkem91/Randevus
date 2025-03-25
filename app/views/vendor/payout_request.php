<?php
include VIEWPATH . 'vendor/header.php';
?>

<!-- start dashboard -->
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
                        <div id="main_notification"></div>
                        <div class="alert alert-info" role="alert"><?php echo translate('payout_notice') . "$" . $minimum_vendor_payout; ?></div>
                        <div class="header bg-color-base">
                            <div class="d-flex justify-content-center">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('payout_request'); ?></h3>
                                </span>
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a style="font-size: 14px;"  data-toggle="modal" data-target="#paymentRequest" class="btn btn-sm btn-success"><?php echo translate('payout_request'); ?></a>
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class=" card mytablerecord">  
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table mdl-data-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center font-bold dark-grey-text">#</th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_gateway'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('payout_reference'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('amount'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('reference_no'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_gateway_fee'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('request_date'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('processed_date'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $post_status = '';

                                                if (isset($payment_data) && count($payment_data) > 0) {
                                                    foreach ($payment_data as $row) {
                                                        $status = "";
                                                        if ($row['status'] == 'P') {
                                                            $status = "Pending";
                                                        } else if ($row['status'] == 'S') {
                                                            $status = "Payout Successful";
                                                        } else if ($row['status'] == 'H') {
                                                            $status = "On Hold";
                                                        } else if ($row['status'] == 'F') {
                                                            $status = "Failed";
                                                        }

                                                        $other_charge = "";
                                                        if (isset($row['other_charge']) && $row['other_charge'] != 0) {
                                                            $other_charge = " + $" . $row['other_charge'];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td class="text-center"><?php echo isset($row['choose_payment_gateway']) ? $row['choose_payment_gateway'] : "NA"; ?></td>
                                                            <td class="text-center"><?php echo isset($row['payment_gateway_ref']) && $row['payment_gateway_ref'] != NULL ? "" . $row['payment_gateway_ref'] : "NA"; ?></td>
                                                            <td class="text-center">$<?php echo $row['amount']; ?></td>
                                                            <td class="text-center"><?php echo isset($row['reference_no']) ? $row['reference_no'] : "NA"; ?></td>
                                                            <td class="text-center"><?php echo isset($row['payment_gateway_fee']) && ($row['payment_gateway_fee'] != "") ? $row['payment_gateway_fee'] . "%" . $other_charge : "NA"; ?></td>
                                                            <td class="text-center"><?php echo $status; ?></td>
                                                            <td class="text-center"><?php echo date('m/d/Y, H:i A', strtotime($row['created_date'])); ?></td>
                                                            <td class="text-center"><?php echo date("m/d/Y H:i A", strtotime($row['processed_date'])); ?></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<div class="modal fade" id="paymentRequest">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'paymentrequestForm', 'name' => 'paymentrequestForm', 'method' => "post");
            echo form_open_multipart('vendor/payment-request-save', $attributes);
            ?>
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo translate('payout_request'); ?></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="payment_gateway"><?php echo translate('payment_gateway'); ?></label>
                    <select id="payment_gateway" name="payment_gateway" required=""  onchange="check_my_type(this.value)"  class="form-control" style="display: block !important;">
                        <option value=""><?php echo translate('select') . " " . translate('payment_gateway'); ?></option>
                        <option value="PayPal">PayPal</option>
                        <option value="Payoneer">Payoneer</option>
                        <option value="Stripe">Stripe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_id"><?php echo translate('payout_reference'); ?></label>
                    <input id="payment_gateway_ref"  name="payment_gateway_ref" value="" class="form-control" placeholder="<?php echo translate('payout_reference'); ?>" required="">
                </div>
                <div class="form-group">
                    <label for="payout_amount"><?php echo translate('payout_amount'); ?></label>
                    <input id="payout_amount" type="number" name="payout_amount" value="<?php echo isset($total_wallet) ? $total_wallet : 0; ?>" class="form-control" placeholder="<?php echo translate('payout_amount'); ?>" required="">
                </div>
                <div class="form-group">
                    <div class="alert alert-info" role="alert"><?php echo translate('gateway_fee_note') ?></div>
                </div>
            </div>
            <div class="modal-footer">

                <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="SaveRequestBtn" ><?php echo translate('submit'); ?></a>
                <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('cancel'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php
include VIEWPATH . 'vendor/footer.php';
?><script>
    function check_my_type(val) {
        if (val == "PayPal") {
            $("#payment_gateway_ref").attr("type", "email");
        } else {
            $("#payment_gateway_ref").attr("type", "text");
        }
    }

    $("#SaveRequestBtn").on("click", function (e) {
        var UpdateRecordForm = $("#paymentrequestForm").valid();
        if (UpdateRecordForm == true) {
            $("#paymentrequestForm").submit();
        } else {
            return false;
        }
    });
</script>