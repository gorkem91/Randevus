<?php
include VIEWPATH . 'admin/header.php';

$stripe = (set_value("stripe")) ? set_value("stripe") : (!empty($payment_data) ? $payment_data['stripe'] : 'N');
$paypal = (set_value("paypal")) ? set_value("paypal") : (!empty($payment_data) ? $payment_data['paypal'] : 'N');
$on_cash = (set_value("on_cash")) ? set_value("on_cash") : (!empty($payment_data) ? $payment_data['on_cash'] : 'N');
$stripe_secret = (set_value("stripe_secret")) ? set_value("stripe_secret") : (!empty($payment_data) ? $payment_data['stripe_secret'] : '');
$stripe_publish = (set_value("stripe_publish")) ? set_value("stripe_publish") : (!empty($payment_data) ? $payment_data['stripe_publish'] : '');
$paypal_merchant_email = (set_value("paypal_merchant_email")) ? set_value("paypal_merchant_email") : (!empty($payment_data) ? $payment_data['paypal_merchant_email'] : '');
$paypal_sendbox_live = (set_value("paypal_sendbox_live")) ? set_value("paypal_sendbox_live") : (!empty($payment_data) ? $payment_data['paypal_sendbox_live'] : '');
$id = !empty($payment_data) ? $payment_data['id'] : 0;

if ($stripe == 'Y') {
    $stripe_yes = 'checked';
} else {
    $stripe_no = 'checked';
}

if ($paypal == 'Y') {
    $paypal_yes = 'checked';
} else {
    $paypal_no = 'checked';
}

if ($on_cash == 'Y') {
    $on_cash_yes = 'checked';
} else {
    $on_cash_no = 'checked';
}
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold">
                                    <?php echo translate('update_payment_setting'); ?>
                                </h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                echo form_open('admin/save-payment-setting', array('name' => 'PaymentForm', 'id' => 'PaymentForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>
                                <label style="color: #757575;" > <?php echo translate('stripe'); ?></label>
                                <div class="form-group form-inline">
                                    <div class="form-group">
                                        <input name='stripe' value="Y" type='radio' id='stripe_yes'   <?php echo isset($stripe_yes) ? $stripe_yes : ''; ?> onchange="check_stripe_val(this.value);">
                                        <label for="stripe_yes"><?php echo translate('yes'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='stripe' type='radio'  value='N' id='stripe_no'  <?php echo isset($stripe_no) ? $stripe_no : ''; ?> onchange="check_stripe_val(this.value);">
                                        <label for='stripe_no'><?php echo translate('no'); ?></label>
                                    </div>
                                </div>
                                <div class="form-group stripe-html d-none">
                                    <label for="stripe_secret"> <?php echo translate('stripe_secret_key'); ?><small class="required">*</small></label>
                                    <input type="text" id="stripe_secret" name="stripe_secret" value="<?php echo $stripe_secret; ?>" class="form-control" placeholder="<?php echo translate('stripe_secret_key'); ?>">                                    
                                    <?php echo form_error('stripe_secret'); ?>
                                </div>
                                <div class="form-group stripe-html d-none">
                                    <label for="stripe_publish"> <?php echo translate('stripe_publish_key'); ?><small class="required">*</small></label>
                                    <input type="text" id="stripe_publish" name="stripe_publish" value="<?php echo $stripe_publish; ?>" class="form-control" placeholder="<?php echo translate('stripe_publish_key'); ?>">                                    
                                    <?php echo form_error('stripe_publish'); ?>
                                </div>
                                <hr/>

                                <label style="color: #757575;" > <?php echo translate('paypal'); ?></label>
                                <div class="form-group form-inline">
                                    <div class="form-group">
                                        <input name='paypal' value="Y" type='radio' id='paypal_yes'   <?php echo isset($paypal_yes) ? $paypal_yes : ''; ?> onchange="check_paypal_val(this.value);">
                                        <label for="paypal_yes"><?php echo translate('yes'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='paypal' type='radio'  value='N' id='paypal_no'  <?php echo isset($paypal_no) ? $paypal_no : ''; ?> onchange="check_paypal_val(this.value);">
                                        <label for='paypal_no'><?php echo translate('no'); ?></label>
                                    </div>
                                </div>
                                <div class=" palpal-html">
                                    <div class="form-group">
                                        <label for="paypal_sendbox_live"> <?php echo translate('paypal_mode'); ?></label>
                                        <select class="form-control" id="paypal_sendbox_live" name="paypal_sendbox_live" style="display: block !important;">
                                            <option <?php echo ($paypal_sendbox_live == 'S') ? "selected='selected'" : ""; ?> value="S"><?php echo translate('paypal_sendbox'); ?></option>
                                            <option <?php echo ($paypal_sendbox_live == 'L') ? "selected='selected'" : ""; ?> value="L"><?php echo translate('paypal_live'); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="stripe_publish"> <?php echo translate('paypal_merchant_email'); ?></label>
                                        <input type="email" id="paypal_merchant_email" name="paypal_merchant_email" value="<?php echo $paypal_merchant_email; ?>" class="form-control" placeholder="<?php echo translate('paypal_merchant_email'); ?>">                                    
                                        <?php echo form_error('paypal_merchant_email'); ?>
                                    </div>
                                </div>


                                <hr/>
                                <label style="color: #757575;" > <?php echo translate('on_cash'); ?></label>
                                <div class="form-group form-inline">
                                    <div class="form-group">
                                        <input name='on_cash' value="Y" type='radio' id='on_cash_yes'   <?php echo isset($on_cash_yes) ? $on_cash_yes : ''; ?>>
                                        <label for="on_cash_yes"><?php echo translate('yes'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='on_cash' type='radio'  value='N' id='on_cash_no'  <?php echo isset($on_cash_no) ? $on_cash_no : ''; ?>>
                                        <label for='on_cash_no'><?php echo translate('no'); ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo translate('save'); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
            <!-- End Login-->
        </div>
    </div>
</div>
<script>
    check_stripe_val('<?php echo $stripe; ?>');
    check_paypal_val('<?php echo $paypal; ?>');

    function check_stripe_val(e) {
        if (e == 'Y') {
            $('.stripe-html').removeClass('d-none');
            $('#stripe_secret').attr('required', true);
            $('#stripe_publish').attr('required', true);
        } else {
            $('.stripe-html').addClass('d-none');
            $('#stripe_secret').attr('required', false);
            $('#stripe_publish').attr('required', false);
        }
    }
    function check_paypal_val(e) {
        if (e == 'Y') {
            $('.palpal-html').removeClass('d-none');
            $('#paypal_merchant_email').attr('required', true);
        } else {
            $('.palpal-html').addClass('d-none');
            $('#paypal_merchant_email').attr('required', false);
        }
    }
</script>
<?php
include VIEWPATH . 'admin/footer.php';
?>