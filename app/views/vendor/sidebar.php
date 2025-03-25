<?php
$url_segment = trim($this->uri->segment(2));
$dashboard_active = "";
$event_active = "";
$event_category_active = "";
$appointment_active = "";
$payout_request_active = "";
$city_active = "";
$location_active = "";
$master_open = "";
$membership_active = "";
$slider_active = "";
$message_active = "";
$appointment_report_active = "";
$event_open = "";
$payment_history_active = "";
$event_coupon_active = "";

$eventArr = array("manage-event", "add-event", 'update-event', 'save-event', 'delete-event');
$appointmentArr = array("manage-appointment");
$eventCouponArr = array("manage-coupon", "add-coupon", 'update-coupon', 'save-coupon', 'delete-coupon');
$location_active_Arr = array("location", 'add-location', "save-location");
$sliderArr = array("manage-slider", "add-slider", 'update-slider', 'save-slider', 'delete-slider');
$city_active_Arr = array("city", 'add-city', "save-city");
$event_categoryArr = array("event-category", 'add-category', 'update-category', "save-category");
$membershipArr = array("membership", "membership-purchase", "purchase-details");
$messageArr = array("message", "message-action");
$appointment_reportArr = array("appointment-report");
$payout_reportArr = array("payout-request");
$payment_history_array = array("payment-history");

if (isset($url_segment) && in_array($url_segment, $eventArr)) {
    $event_open = "open";
    $event_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $payment_history_array)) {
    $payment_history_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $eventCouponArr)) {
    $event_open = 'open';
    $event_coupon_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $event_categoryArr)) {
    $event_open = "open";
    $event_category_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $appointmentArr)) {
    $appointment_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $sliderArr)) {
    $slider_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $payout_reportArr)) {
    $payout_request_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $membershipArr)) {
    $membership_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $messageArr)) {
    $message_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $appointment_reportArr)) {
    $appointment_report_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $location_active_Arr)) {
    $master_open = "open";
    $location_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $city_active_Arr)) {
    $master_open = "open";
    $city_active = "active";
} else {
    $dashboard_active = "active";
}
?>

<div id="dashboard-options-menu" class="side-bar dashboard left closed">
    <div class="svg-plus">
        <img src="<?php echo base_url() . img_path; ?>/sidebar/close-icon.png" alt="close"/>
    </div>
    <div class="side-bar-header">
        <div class="user-quickview text-center px-2">
            <div class="outer-ring">
                <a href="<?php echo base_url(); ?>">
                    <figure class="user-img">
                        <img src="<?php echo check_admin_image(UPLOAD_PATH . "sitesetting/" . get_CompanyLogo()); ?>" alt='side profile' class="img-fluid w-auto"/>
                    </figure>
                </a>
            </div>
            <p class="user-name"></p>
        </div>
    </div>
    <ul class="dropdown dark hover-effect interactive list-inline">
        <li class="<?php echo $dashboard_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/dashboard'); ?>">
                <i class="fa fa-dashboard pr-2"></i>
                <?php echo translate('dashboard'); ?>
            </a>
        </li>
        <li class="dropdown-item interactive p-0 <?php echo $event_active . $event_category_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-calendar pr-2"></i>
                <?php echo translate('event'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!--INNER DROPDOWN--> 
            <ul class="<?php echo $event_open; ?> inner-dropdown ">
                <li class="<?php echo $event_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('vendor/manage-event'); ?>">
                        <?php echo translate('event'); ?>
                    </a>
                </li>
                <li class="<?php echo $event_category_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('vendor/event-category'); ?>">
                        <?php echo translate('event_category'); ?>
                    </a>
                </li>
                <li class="<?php echo $event_coupon_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('vendor/manage-coupon'); ?>">
                        <?php echo translate('event_coupon'); ?>
                    </a>
                </li>
            </ul>
            <!--/INNER DROPDOWN--> 
        </li>  
        <li class="<?php echo $appointment_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/manage-appointment'); ?>">
                <i class="fa fa-users pr-2"></i>
                <?php echo translate('appointment'); ?>
            </a>
        </li>
        <li class="<?php echo $payment_history_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/payment-history'); ?>">
                <i class="fa fa-history pr-2"></i>
                <?php echo translate('appointment_payment_history'); ?>
            </a>
        </li>
        <li class="<?php echo $payout_request_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/payout-request'); ?>">
                <i class="fa fa-trophy pr-2"></i>
                <?php echo translate('payout_request'); ?>
            </a>
        </li>
        <li class="<?php echo $slider_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/manage-slider'); ?>">
                <i class="fa fa-sliders pr-2"></i>
                <?php echo translate('slider'); ?>
            </a>
        </li>
        <li class="<?php echo $message_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/message'); ?>">
                <i class="fa fa-envelope pr-2"></i>
                <?php echo translate('message'); ?>
            </a>
        </li>
        <li class="<?php echo $appointment_report_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('vendor/appointment-report'); ?>">
                <i class="fa fa-line-chart pr-2"></i>
                <?php echo translate('appointment_report'); ?>
            </a>
        </li>
        <li class="dropdown-item interactive p-0 <?php echo $city_active . $location_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-cog pr-2"></i>
                <?php echo translate('master'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!--INNER DROPDOWN--> 
            <ul class="<?php echo $master_open; ?> inner-dropdown ">
                <li class="<?php echo $city_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('vendor/city'); ?>">
                        <?php echo translate('city'); ?>
                    </a>
                </li>
                <li class="<?php echo $location_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('vendor/location'); ?>">
                        <?php echo translate('location'); ?>
                    </a>
                </li>
            </ul>
            <!--/INNER DROPDOWN--> 
        </li>  
    </ul>
</div>
<!-- End Sidebar -->
