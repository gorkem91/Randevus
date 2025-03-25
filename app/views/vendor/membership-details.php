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
                    <div class="col-md-6 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('membership_details'); ?></h3>
                                </span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <?php
                                echo form_open_multipart('vendor/package-purchase', array('name' => 'PackageForm', 'id' => 'PackageForm'));
                                ?>
                                <input type="hidden" id="package_id" name="package_id" value="<?php echo $package_data['id']; ?>">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table">
                                        <thead>
                                            <tr>
                                                <th class="font-bold dark-grey-text" style="width: 30%"><?php echo translate('package'); ?></th>
                                                <th><?php echo $package_data['title']; ?></th>
                                            </tr>
                                            <tr>
                                                <th class="font-bold dark-grey-text" style="width: 30%"><?php echo translate('price'); ?></th>
                                                <th><?php echo price_format($package_data['price']); ?></th>
                                            </tr>
                                            <tr>
                                                <th class="font-bold dark-grey-text" style="width: 30%"><?php echo translate('max_event'); ?></th>
                                                <th><?php echo $package_data['max_event']; ?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div> 
                                <div class="form-group">
                                    <p class="black-text"><?php echo translate('select'); ?> <?php echo translate('payment_method'); ?><small class="required">*</small></p>
                                    <select class="kb-select initialized" id="payment_method" name="payment_method" onchange="get_stripe(this.value);"> 
                                        <option value=""><?php echo translate('select') . " " . translate('payment_method'); ?></option>
                                        <?php if (check_payment_method('stripe')) { ?>
                                            <option value="stripe"><?php echo translate('stripe'); ?></option>
                                        <?php }if (check_payment_method('on_cash')) { ?>
                                            <option value="on_cash"><?php echo translate('on_cash'); ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('payment_method'); ?>
                                </div>

                                <div id="verify"></div>
                                <div class="form-group">
                                    <button type="button" onclick="history.go(-1);" class="btn btn-outline-danger waves-effect" style="margin-top: 25px;"><?php echo translate('cancel'); ?></button>
                                    <button type="submit" class="btn btn-outline-success waves-effect pull-right" style="margin-top: 25px;"><?php echo translate('purchase'); ?></button>
                                </div>
                                <?php echo form_close(); ?>
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

<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">
                                        var handler = StripeCheckout.configure({
                                            key: '<?php echo get_Stripepublish(); ?>',
                                            image: '',
                                            token: function (token) {
                                                // Use the token to create the charge with a server-side script.
                                                // You can access the token ID with `token.id`
                                                $('#PackageForm').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                                                $.activeitNoty({
                                                    type: 'success',
                                                    icon: 'fa fa-check',
                                                    message: 'done',
                                                    container: 'floating',
                                                    timer: 3000
                                                });
                                                $('#verify').html('done');
                                            }
                                        });

                                        function get_stripe(type) {
                                            package_id = $('#package_id').val();
                                            if (type == 'stripe') {
                                                $.ajax({
                                                    url: site_url + "vendor/check-package-price/" + package_id,
                                                    success: function (total) {
                                                        total = total * 100;
                                                        handler.open({
                                                            name: '<?php echo get_CompanyName(); ?>',
                                                            amount: total
                                                        });
                                                    }
                                                });

                                            }
                                        }
                                        // Close Checkout on page navigation
                                        $(window).on('popstate', function () {
                                            handler.close();
                                        });
                                        $("#PackageForm").submit(function () {
                                            if ($("#PackageForm").valid()) {
                                                $('.paymentloadingmessage').show();
                                            }
                                        });
</script>
<?php
include VIEWPATH . 'vendor/footer.php';
?>