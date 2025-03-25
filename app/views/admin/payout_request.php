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
                                <span>
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('payout_request') ?></h3>
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
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('vendor_name'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_gateway'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('payout_reference'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('amount'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('reference_no'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_gateway_fee'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('request_date'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('processed_date'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
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
                                                        <td class="text-center"><?php echo $row['vendor_name']; ?></td>
                                                        <td class="text-center"><?php echo isset($row['choose_payment_gateway']) ? $row['choose_payment_gateway'] : "NA"; ?></td>
                                                        <td class="text-center"><?php echo isset($row['payment_gateway_ref']) && $row['payment_gateway_ref'] != NULL ? "" . $row['payment_gateway_ref'] : "NA"; ?></td>
                                                        <td class="text-center">$<?php echo $row['amount']; ?></td>
                                                        <td class="text-center"><?php echo isset($row['reference_no']) ? $row['reference_no'] : "NA"; ?></td>
                                                        <td class="text-center"><?php echo isset($row['payment_gateway_fee']) && $row['payment_gateway_fee'] != "" ? $row['payment_gateway_fee'] . "%" . $other_charge : "NA"; ?></td>
                                                        <td class="text-center"><?php echo $status; ?></td>
                                                        <td class="text-center"><?php echo date("m/d/Y H:i A", strtotime($row['created_date'])); ?></td>
                                                        <td class="text-center"><?php echo date("m/d/Y H:i A", strtotime($row['processed_date'])); ?></td>
                                                        <td class="text-center">
                                                            <?php if ($row['status'] != 'S') { ?>
                                                                <a id="" data-toggle="modal" onclick='UpdateStatus(this)' data-amount="<?php echo $row['amount']; ?>" data-cpayment="<?php echo isset($row['choose_payment_gateway']) ? $row['choose_payment_gateway'] : ""; ?>" data-target="#update_details" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-amber" title="Post">PROCESS</a>
                                                            <?php } else if ($row['status'] == 'S') { ?>
                                                                Paid
                                                                <?php
                                                            } else {
                                                                echo translate('paid');
                                                            }
                                                            ?>
                                                        </td>
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
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<!-- Modal -->
<div class="modal fade" id="update_details">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="UpdateRecordForm" name="UpdateRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo translate('payout_request'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment_gateway"><?php echo translate('payment_gateway'); ?></label>
                        <select id="payment_gateway" name="payment_gateway"required="" class="form-control" style="display: block !important;">
                            <option value=""><?php echo translate('select') . " " . translate('payment_gateway'); ?></option>
                            <option value="PayPal">PayPal</option>
                            <option value="Payoneer">Payoneer</option>
                            <option value="Stripe">Stripe</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_gateway_fee"><?php echo translate('payment_gateway_fee_in_percentage'); ?>:</label>
                        <input type="number" id="payment_gateway_fee" min="1" name="payment_gateway_fee" value="" class="form-control" placeholder="<?php echo translate('payment_gateway_fee_in_percentage'); ?>" required=""/>
                    </div>
                    <div class="form-group">
                        <label for="updated_amount"><?php echo translate('updated_payment_amount'); ?>:</label>
                        <input type="number" id="updated_amount" name="updated_amount" value="" class="form-control" placeholder="<?php echo translate('updated_payment_amount'); ?>" required=""/>
                    </div>
                    <div class="form-group">
                        <label for="updated_amount"><?php echo translate('other_charges') ?>:</label>
                        <input type="number" min="0" id="other_charge" name="other_charge" value="" class="form-control" placeholder="<?php echo translate('other_charges') ?>" required=""/>
                    </div>
                    <div class="form-group">
                        <label for="reference_no"><?php echo translate('reference_no'); ?>:</label>
                        <input id="reference_no" name="reference_no" value="" class="form-control" placeholder="<?php echo translate('reference_no'); ?>" required=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="UpdateStatusBtn" ><?php echo translate('save'); ?></a>
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('cancel'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php
include VIEWPATH . 'admin/footer.php';
?>
<script>
    function payment_gateway_fee() {
        var payment_gateway_fee = $("#payment_gateway_fee").val();
        var amount = $("#updated_amount").val();
        var calcPrice = (amount - (amount * (payment_gateway_fee / 100)));
        $("#updated_amount").val(calcPrice);
    }
    function other_charge() {
        var other_charge = $("#other_charge").val();
        var updated_amount = $("#updated_amount").val();
        $("#updated_amount").val(updated_amount - other_charge);
    }
    function UpdateStatus($this) {
        var record_id = ($($this).attr('data-id'));
        var gateway = ($($this).attr('data-cpayment'));
        var amount = ($($this).attr('data-amount'));
        $("#payment_gateway").val(gateway);
        $("#payment_gateway").attr("disabled", true);
        $("#record_id").val(record_id);
        $("#updated_amount").val(amount);
    }
    $("#other_charge").on("blur", function (e) {
        other_charge();
    });
    $("#payment_gateway_fee").on("blur", function (e) {
        payment_gateway_fee();
    });
    $("#UpdateStatusBtn").on("click", function (e) {
        var UpdateRecordForm = $("#UpdateRecordForm").valid();
        var formData = $("#UpdateRecordForm").serialize();
        if (UpdateRecordForm == true) {
            var record_id = $("#record_id").val();
            $.ajax({
                url: base_url + "admin/payment_update/" + record_id,
                type: "post",
                data: formData,
                beforeSend: function () {
                    $("body").preloader({
                        percent: 10,
                        duration: 15000
                    });
                },
                success: function (responseJSON) {
                    window.location.reload();
                }
            });
        }

    });
</script>