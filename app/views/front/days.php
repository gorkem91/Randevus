<?php
include VIEWPATH . 'front/header.php';
$type = $this->uri->segment(1);
$current_date_month = date("m", strtotime($current_date));
$customer_id_sess = (int) $this->session->userdata('CUST_ID');
?>
<style>
    select{
        display: block !important;
    }
</style>
<div class="container">
    <div class="mt-20">
        <?php $this->load->view('message'); ?>        
    </div>
    <h3 class="text-center mt-20"><?php echo translate('appointment_booking'); ?></h3>
    <hr>
    <div class="pointer">        
        <div class="row">
            <div class="col-md-6 col-5">
                <div class="marker" style="background-color: #fff200"></div>
                <h3 class="mb-0"><?php echo ($event_title); ?></h3>
            </div>
            <div class="col-md-6 col-7 text-right">
                <h3 class="mb-0"><?php echo date_default_timezone_get() . "(" . date("h:i A") . ")"; ?></h3>
            </div>
        </div>
    </div>
    <hr>
    <h3 class="text-center"><?php echo translate('select_a_day'); ?></h3>
    <div class="text-center">
        <div class="pointer-info">
            <div class="marker-info" style="background-color: #289612"></div>
            <div class="pointer-info-text"><?php echo translate('today'); ?></div>
            <div class="marker-info" style="background-color: #00a2ff"></div>
            <div class="pointer-info-text"><?php echo translate('available'); ?></div>
            <div class="marker-info" style="background-color: #ccc"></div>
            <div class="pointer-info-text"><?php echo translate('unavailable'); ?></div>
            <div class="marker-info" style="background-color: #fb0e0e"></div>
            <div class="pointer-info-text"><?php echo translate('today_unavailable'); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br> 
            <?php
            if ($this->session->flashdata('message')) {
                echo $this->session->flashdata('message');
            }
            ?>	
            <div class="text-center mb-4">
                <div class="row">
                    <div class="col-md-1 m-auto resp_icon left">
                        <span class="week-control left" onclick="check_pos(this);"><i class="fa fa-chevron-left"></i></span>
                    </div>
                    <div class="col-md-10 resp_w-250 m-auto">
                        <!--Carousel Wrapper-->
                        <div id="day-carousel" class="carousel slide carousel-multi-item" data-ride="carousel">
                            <div class="carousel-inner text-center" role="listbox">
                                <?php
                                $ci = 0;
                                foreach ($day_data as $key => $value) {
                                    $today_class = $un_class = $un_style = '';
                                    if (date('Y-m-d') == date('Y-m-d', strtotime($value['full_date']))) {
                                        $today_class = "today-day";
                                    }
                                    if ($value['check'] == 0) {
                                        $un_class = "unavailable";
                                        if (date('Y-m-d') == $value['full_date']) {
                                            $un_class = 't-unavailable';
                                        }
                                        $un_style = "style='pointer-events: none;'";
                                    }

                                    if ($ci % 7 == 0) {
                                        $dt = isset($key) && $key == 0 ? 'active' : '';
                                        echo '<div class="carousel-item ' . $dt . '">';
                                    }
                                    ?>
                                    <div class="mb-2 resp_w-48 d-inline-block">
                                        <?php if ($customer_id_sess == 0): ?>
                                            <div class="position-r"  data-toggle="modal" data-target="#login_register_modal">
                                            <?php else: ?>
                                                <div class="position-r" onclick="get_time_slots(this);" data-date="<?php echo $value['full_date']; ?>"<?php echo isset($un_style) ? " " . $un_style : ''; ?>>
                                                <?php endif; ?>

                                                <div class="day-circle m-1<?php echo isset($today_class) ? " " . $today_class : ''; ?><?php echo isset($un_class) ? " " . $un_class : ''; ?>">
                                                    <div class="text-center">
                                                        <strong class="shorthand"><?php echo $value['week']; ?></strong>
                                                    </div>
                                                    <div>
                                                        <div><?php echo $value['month']; ?> <?php echo $value['date']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $ci++;
                                        if ($ci % 7 == 0) {
                                            echo '</div>';
                                        } elseif (count($day_data) == $ci) {
                                            echo '</div>';
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 m-auto resp_icon right">
                            <span class="week-control right" onclick="check_pos(this);"><i class="fa fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="time_slots_model" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&#8592;</button>
                    <h4 class="modal-title w-100 text-center m-0"><?php echo translate('select_a_time'); ?></h4>
                </div>
                <div class="modal-body" id="time_slots_model_body">
                </div>
            </div>
        </div>
    </div>

    <div id="confirm_model" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="confirm_back">
                    <h4 class="modal-title w-100 text-center m-0"><?php echo translate("booking"); ?></h4>
                </div>
                <div class="modal-body" id="confirm_model_body">
                    <form action="<?php echo site_url('booking-oncash'); ?>" id="BookForm" method="post">
                        <input type="hidden" name="amount" id="amount" value="<?php echo isset($event_payment_price) ? $event_payment_price : '0'; ?>">
                        <input type="hidden" id="user_slot_time" name="user_slot_time" value="<?php echo $slot_time; ?>"/>
                        <input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id; ?>"/>
                        <input type="hidden" id="discount_coupon_id" name="discount_coupon_id" value="0"/>
                        <input type="hidden" id="user_datetime" name="user_datetime"/>
                        <input type="hidden" id="event_payment_type" name="event_payment_type" value="<?php echo isset($event_payment_type) ? $event_payment_type : ""; ?>"/>
                        <input type="hidden" id="first_name" name="first_name" value="<?php echo isset($customer_data) ? $customer_data['first_name'] : ""; ?>"/>
                        <input type="hidden" id="last_name" name="last_name" value="<?php echo isset($customer_data) ? $customer_data['last_name'] : ""; ?>"/>
                        <input type="hidden" id="email" name="email" value="<?php echo isset($customer_data) ? $customer_data['email'] : ""; ?>"/>
                        <table class="table mdl-data-table">
                            <tr>
                                <th><?php echo translate('title'); ?></th>
                                <th><?php echo ($event_title); ?></th>
                            </tr>
                            <tr>
                                <th><?php echo translate('slot_time'); ?></th>
                                <th><?php echo $slot_time . " " . translate('minute'); ?></th>
                            </tr>
                            <?php if (isset($event_data['payment_type']) && $event_data['payment_type'] == 'P'): ?>
                                <tr>
                                    <th><?php echo translate('price'); ?></th>
                                    <th id="discount_coupon_price">$<?php echo $event_data['price']; ?></th>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <th><?php echo translate('price'); ?></th>
                                    <th><?php echo translate('free'); ?></th>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <th><?php echo translate('appointment_date'); ?></th>
                                <th id="datetime_list"></th>
                            </tr>
                        </table>
                        <div class="form-group">
                            <label for="description"><?php echo translate('booking_note'); ?><small class="required">*</small></label>
                            <textarea type="text" class="form-control" rows="5" placeholder="<?php echo translate('booking_note'); ?>" id="description" name="description" style="height: auto" required></textarea>
                        </div>

                        <?php if (isset($event_payment_type) && $event_payment_type == 'P'): ?>
                            <div class="form-group">
                                <p class="black-text"><?php echo translate('event_coupon'); ?></p>
                                <input type="text" class="form-control" onblur="apply_coupon_code()" name="discount_coupon" id="discount_coupon" placeholder="<?php echo translate('event_coupon'); ?>"/>
                                <p class="error" id="discount_coupon_error"></p>
                            </div>
                        <?php endif; ?>
                        <hr/>
                        <?php if (isset($event_payment_type) && $event_payment_type == 'P'): ?>
                            <div class="form-group">
                                <p class="black-text"><?php echo translate('payment_by'); ?><small class="required">*</small></p>

                                <!-- Set Cash ON method -->
                                <?php if (check_payment_method('on_cash')): ?>
                                    <button type="button" onclick="valid_on_cash();" class="btn btn-primary"><?php echo translate('on_cash'); ?></button>
                                <?php endif; ?>

                                <!-- Set Stripe method -->
                                <?php if (check_payment_method('stripe')): ?>
                                    <button type="button" onclick="valid_stripe();" class="btn btn-warning"><?php echo translate('stripe'); ?></button>
                                <?php endif; ?>

                                <!-- Set PayPal ON method -->
                                <?php if (check_payment_method('paypal')): ?>
                                    <button type="button" onclick="valid_paypal();" class="btn btn-info"><?php echo translate('paypal'); ?></button>
                                <?php endif; ?>

                                <?php echo form_error('payment_method'); ?>
                            </div>
                        <?php else: ?>
                            <button type="button" onclick="valid_free();" class="btn btn-primary"><?php echo translate('submit'); ?></button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (check_payment_method('stripe')) { ?>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script type="text/javascript">
                                var handler = StripeCheckout.configure({
                                    key: '<?php echo get_Stripepublish(); ?>',
                                    image: '',
                                    token: function (token) {
                                        $('#loadingmessage').show();
                                        $('#BookForm').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                                        $("#BookForm").attr("action", base_url + "booking-stripe");
                                        $("#BookForm").submit();
                                    }
                                });

                                function get_stripe() {
                                    var payment_price = $("#amount").val();
                                    var first_name = $("#first_name").val();
                                    var last_name = $("#last_name").val();
                                    var email = $("#email").val();

                                    var total = parseInt(payment_price) * 100;
                                    handler.open({
                                        name: first_name + " " + last_name,
                                        email: email,
                                        amount: total
                                    });
                                }
                                // Close Checkout on page navigation
                                $(window).on('popstate', function () {
                                    handler.close();
                                });
    </script>
<?php } ?>
<?php include VIEWPATH . 'front/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>day_book.js"></script>
<script>

                            function get_time_slots(e) {
                                $("#confirm_model").modal('hide');
                                $('#BookForm')[0].reset();
                                date = $(e).data("date");
                                if (<?php echo (int) $this->uri->segment(3); ?> > 0) {
                                    url = base_url + "time-slots/<?php echo $slot_time; ?>/<?php echo $this->uri->segment(3); ?>";
                                } else {
                                    url = base_url + "time-slots/<?php echo $slot_time; ?>";
                                }
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {date: date},
                                    beforeSend: function () {
                                        $('#loadingmessage').show();
                                    },
                                    success: function (html) {
                                        if (html == false) {
                                            window.location.href = base_url + 'login';
                                        }
                                        $("#time_slots_model_body").html(html);
                                        $("#time_slots_model").modal('show');
                                        $('#loadingmessage').hide();
                                        $("body").addClass("model-scroll");
                                    }
                                });
                            }
                            check_pos('body');
</script>