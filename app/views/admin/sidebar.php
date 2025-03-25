<?php
$url_segment = trim($this->uri->segment(2));
$dashboard_active = "";
$customer_active = "";
$vendor_active = "";
$event_active = "";
$event_category_active = "";
$event_coupon_active = "";
$slider_active = "";
$package_active = "";
$appointment_active = "";
$sitesetting_open = "";
$sitesetting_active = "";
$sitesetting_email_active = "";
$sitesetting_display_active = "";
$sitesetting_business_active = "";
$city_active = "";
$location_active = "";
$master_open = "";
$vendor_open = "";
$package_open = "";
$package_payment_active = "";
$vendor_payment_active = "";
$report_open = "";
$payment_history_active = "";
$vendor_report_active = "";
$customer_report_active = "";
$appointment_report_active = "";
$message_active = "";
$event_open = '';
$language_active = $language_open = '';
$payment_setting_active = '';
$payout_request_active = '';


$customerArr = array("customer", "add-customer", 'update-customer', 'save-customer', 'delete-customer');
$vendorArr = array("vendor", "add-vendor", 'update-vendor', 'save-vendor', 'delete-vendor');
$eventArr = array("manage-event", "add-event", 'update-event', 'save-event', 'delete-event');
$eventCouponArr = array("manage-coupon", "add-coupon", 'update-coupon', 'save-coupon', 'delete-coupon');
$sliderArr = array("manage-slider", "add-slider", 'update-slider', 'save-slider', 'delete-slider');
$packageArr = array("manage-package", "add-package", 'update-package', 'save-package', 'delete-package');
$appointmentArr = array("manage-appointment");
$sitesetting_active_Arr = array("sitesetting", "save-sitesetting");
$displaysetting_active_Arr = array("display-setting", "save-display-setting");
$businesssetting_active_Arr = array("business-setting", "save-business--setting");
$sitesetting_email_Arr = array("email-setting", "save-email-setting");
$location_active_Arr = array("location", 'add-location', 'update-location', "save-location");
$city_active_Arr = array("manage-city", "city", 'add-city', 'update-city', "save-city");
$event_categoryArr = array("event-category", 'add-category', 'update-category', "save-category");
$package_paymentArr = array("package-payment");
$vendor_paymentArr = array("payout-request");
$vendor_reportArr = array("report");
$customer_reportArr = array("customer-report");
$payment_history_array = array("payment-history");
$appointment_reportArr = array("appointment-report");
$messageArr = array("message", "message-action");
$payment_settingArr = array("payment-setting", "save-payment-setting-save");
$language_settingArr = array("language", "manage-language", "language-setting", "update-language", "add-language", "save-language", "language-translate");

if (isset($url_segment) && in_array($url_segment, $customerArr)) {
    $customer_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $vendorArr)) {
    $vendor_open = "open";
    $vendor_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $language_settingArr)) {
    $language_open = "open";
    $language_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $vendor_paymentArr)) {
    $vendor_open = "open";
    $vendor_payment_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $payment_history_array)) {
    $payment_history_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $eventArr)) {
    $event_open = 'open';
    $event_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $event_categoryArr)) {
    $event_open = 'open';
    $event_category_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $eventCouponArr)) {
    $event_open = 'open';
    $event_coupon_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $sliderArr)) {
    $master_open = "open";
    $slider_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $packageArr)) {
    $package_open = "open";
    $package_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $package_paymentArr)) {
    $package_open = "open";
    $package_payment_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $vendor_reportArr)) {
    $report_open = "open";
    $vendor_report_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $customer_reportArr)) {
    $report_open = "open";
    $customer_report_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $appointment_reportArr)) {
    $report_open = "open";
    $appointment_report_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $appointmentArr)) {
    $appointment_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $messageArr)) {
    $message_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $payment_settingArr)) {
    $sitesetting_open = "open";
    $payment_setting_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $sitesetting_active_Arr)) {
    $sitesetting_open = "open";
    $sitesetting_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $sitesetting_email_Arr)) {
    $sitesetting_open = "open";
    $sitesetting_email_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $displaysetting_active_Arr)) {
    $sitesetting_open = "open";
    $sitesetting_display_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $businesssetting_active_Arr)) {
    $sitesetting_open = "open";
    $sitesetting_business_active = "active";
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
            <a href="<?php echo base_url('admin/dashboard'); ?>">
                <i class="fa fa-dashboard pr-2"></i>
                <?php echo translate('dashboard'); ?>
            </a>
        </li>
        <li class="<?php echo $customer_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin/customer'); ?>">
                <i class="fa fa-user pr-2"></i>
                <?php echo translate('customer'); ?>
            </a>
        </li>
        <li class="dropdown-item interactive p-0 <?php echo $vendor_active . $vendor_payment_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-user-plus pr-2"></i>
                <?php echo translate('vendor'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $vendor_open; ?> inner-dropdown ">
                <li class="<?php echo $vendor_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/vendor'); ?>">
                        <?php echo translate('vendor_list'); ?>
                    </a>
                </li>
                <li class="<?php echo $vendor_payment_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/payout-request'); ?>">
                        <?php echo translate('payout_request'); ?>
                    </a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>

        <li class="<?php echo $payment_history_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin/payment-history'); ?>">
                <i class="fa fa-history pr-2"></i>
                <?php echo translate('appointment_payment_history'); ?>
            </a>
        </li>

        <li class="dropdown-item interactive p-0 <?php echo $event_active . $event_category_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-calendar pr-2"></i>
                <?php echo translate('event'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $event_open; ?> inner-dropdown ">
                <li class="<?php echo $event_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/manage-event'); ?>">
                        <?php echo translate('event'); ?>
                    </a>
                </li>
                <li class="<?php echo $event_category_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/event-category'); ?>">
                        <?php echo translate('event_category'); ?>
                    </a>
                </li>
                <li class="<?php echo $event_coupon_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/manage-coupon'); ?>">
                        <?php echo translate('event_coupon'); ?>
                    </a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>

        <li class="dropdown-item interactive p-0 <?php echo $vendor_report_active . $customer_report_active . $appointment_report_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-line-chart pr-2"></i>
                <?php echo translate('report'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $report_open; ?> inner-dropdown ">
                <li class="<?php echo $vendor_report_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/report'); ?>">
                        <?php echo translate('vendor_report'); ?>
                    </a>
                </li>
                <li class="<?php echo $customer_report_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/customer-report'); ?>">
                        <?php echo translate('customer_report'); ?>
                    </a>
                </li>
                <li class="<?php echo $appointment_report_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/appointment-report'); ?>">
                        <?php echo translate('appointment_report'); ?>
                    </a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>
        <li class="<?php echo $appointment_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin/manage-appointment'); ?>">
                <i class="fa fa-users pr-2"></i>
                <?php echo translate('appointment'); ?>
            </a>
        </li>
        <li class="<?php echo $message_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin/message'); ?>">
                <i class="fa fa-envelope pr-2"></i>
                <?php echo translate('message'); ?>
            </a>
        </li>
        <li class="dropdown-item interactive p-0 <?php echo $sitesetting_active . $sitesetting_email_active . $payment_setting_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-cog pr-2"></i>
                <?php echo translate('site_setting'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $sitesetting_open; ?> inner-dropdown ">
                <li class="<?php echo $sitesetting_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/sitesetting'); ?>">
                        <?php echo translate('site_setting'); ?>
                    </a>
                </li>
                <li class="<?php echo $sitesetting_email_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/email-setting'); ?>">
                        <?php echo translate('email_setting'); ?>
                    </a>
                </li>
                <li class="<?php echo $sitesetting_business_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/business-setting'); ?>">
                        <?php echo translate('business') . ' ' . translate('setting'); ?>
                    </a>
                </li>
                <li class="<?php echo $sitesetting_display_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/display-setting'); ?>">
                        <?php echo translate('display_setting'); ?>
                    </a>
                </li>
                <li class="<?php echo $payment_setting_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/payment-setting'); ?>">
                        <?php echo translate('payment_setting'); ?>
                    </a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li> 

        <li class="<?php echo $language_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin/manage-language'); ?>">
                <i class="fa fa-language pr-2"></i>
                <?php echo translate('language_setting'); ?>
            </a>
        </li>

        <li class="dropdown-item interactive p-0 <?php echo $city_active . $location_active . $slider_active; ?>">
            <a href="javascript:void(0)">
                <i class="fa fa-gears pr-2"></i>
                <?php echo translate('master'); ?>
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $master_open; ?> inner-dropdown ">
                <li class="<?php echo $city_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/city'); ?>">
                        <?php echo translate('city'); ?>
                    </a>
                </li>
                <li class="<?php echo $location_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/location'); ?>">
                        <?php echo translate('location'); ?>
                    </a>
                </li>
                <li class="<?php echo $slider_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin/manage-slider'); ?>">
                        <?php echo translate('slider'); ?>
                    </a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>  
    </ul>
</div>
<!-- End Sidebar -->
