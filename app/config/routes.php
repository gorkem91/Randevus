<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'front';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
 * 
 * Frontend
 * 
 */

/* Front */

$route['front'] = "front/index";
$route['event-details/(:num)/(:num)'] = "front/event_details/$1/$2";
$route['day-slots/(:num)'] = "front/day_slots/$1";
$route['day-slots/(:num)/(:num)'] = "front/day_slots/$1/$2";
$route['time-slots/(:num)'] = "front/time_slots/$1";
$route['time-slots/(:num)/(:num)'] = "front/time_slots/$1/$2";

$route['discount_coupon'] = "front/discount_coupon";
$route['booking-oncash'] = "front/booking_oncash";
$route['booking-stripe'] = "front/booking_stripe";
$route['booking-paypal'] = "front/booking_paypal";
$route['booking-free'] = "front/booking_free";
$route['paypal_success'] = 'front/paypal_success';
$route['paypal_cancel'] = 'front/paypal_cancel';
$route['set_language/(:any)'] = 'front/set_language/$1';

$route['appointment'] = "front/appointment";
$route['delete-appointment/(:num)'] = "front/delete_appointment";
$route['update-appointment/(:num)'] = 'front/update_appointment/$1';
$route['update-appointment/(:num)/(:any)'] = 'front/update_appointment/$1/$2';
$route['profile-details/(:num)'] = "front/profile_details/$1";
$route['payment-history'] = 'front/payment_history';
$route['update-booking'] = 'front/update_booking';
$route['event-category/(:num)'] = 'front/event_category/$1';
$route['get-appointment-details/(:num)'] = 'front/get_appointment_details/$1';
$route['appointment-success/(:num)'] = 'front/appointment_success/$1';
$route['category-details/(:any)'] = 'front/category_details/$1';
$route['category-details'] = 'front/category_details/$1';

/* Content */

$route['login'] = 'content/login';
$route['logout'] = 'content/logout';
$route['profile'] = 'content/profile';
$route['register'] = 'content/register';
$route['login-action'] = 'content/login_action';
$route['profile-save'] = 'content/profile_save';
$route['register-save'] = 'content/register_save';
$route['vendor-register'] = 'content/vendor_register';
$route['vendor-register-save'] = 'content/vendor_register_save';
$route['forgot-password'] = 'content/forgot_password';
$route['forgot-password-action'] = 'content/forgot_password_action';
$route['reset-password-admin/(:any)/(:any)'] = 'content/reset_password';
$route['reset-password-admin-action'] = 'content/reset_password_action';
$route['change-password'] = 'content/update_password';
$route['update-password-action'] = 'content/update_password_action';
$route['check-vendor-email'] = 'content/check_vendor_email';
$route['check-vendor-phone'] = 'content/check_vendor_phone';
$route['verify-vendor/(:any)/(:any)'] = 'content/verify_vendor/$1/$2';
$route['vendor-verify-resend/(:num)'] = 'content/vendor_verify_resend/$1';

/* Message */
$route['message'] = 'front/message';
$route['message/(:num)'] = 'front/message/$1';
$route['message-action'] = 'front/message_action';

/*
 * 
 * Admin Folder
 * 
 */

/* Content */

$route['admin'] = 'admin/content/login';
$route['admin/login'] = 'admin/content/login';
$route['admin/logout'] = 'admin/content/logout';
$route['admin/profile'] = 'admin/content/profile';
$route['admin/login-action'] = 'admin/content/login_action';
$route['admin/profile-save'] = 'admin/content/profile_save';
$route['admin-forgot-password'] = 'admin/content/forgot_password';
$route['admin/forgot-password-action'] = 'admin/content/forgot_password_action';
$route['admin/reset-password-admin/(:any)/(:any)'] = 'admin/content/reset_password_admin';
$route['admin/reset-password-admin-action'] = 'admin/content/reset_password_admin_action';
$route['admin/update-password'] = 'admin/content/update_password';
$route['admin/update-password-action'] = 'admin/content/update_password_action';

/* Dashboard */

$route['admin/dashboard'] = 'admin/dashboard/index';
$route['admin/payment-history'] = 'admin/dashboard/payment_history';
$route['admin/mandatory-update'] = 'admin/dashboard/mandatory_update';

/* Customer */

$route['admin/customer'] = 'admin/customer/index';
$route['admin/delete-customer/(:any)'] = 'admin/customer/delete_customer/$1';
$route['admin/change-customer-status/(:any)'] = 'admin/customer/change_customer_tatus/$1';

$route['admin/payout-request'] = 'admin/dashboard/payout_request';
$route['admin/payment_update/(:num)'] = 'admin/dashboard/payment_update/$1';

/* Event */
$route['admin/manage-event'] = 'admin/event/index';
$route['admin/add-event'] = 'admin/event/add_event';
$route['admin/update-event/(:num)'] = 'admin/event/update_event/$1';
$route['admin/save-event'] = 'admin/event/save_event';
$route['admin/delete-event/(:num)'] = 'admin/event/delete_event/$1';


$route['admin/get-location/(:num)'] = 'admin/event/get_location/$1';
$route['admin/delete-event-image'] = 'admin/event/delete_event_image';
$route['admin/delete-event-seo-image'] = 'admin/event/delete_event_seo_image';
$route['admin/event-category'] = 'admin/event/event_category';
$route['admin/add-category'] = 'admin/event/add_category';
$route['admin/update-category/(:num)'] = 'admin/event/update_category/$1';
$route['admin/save-category'] = 'admin/event/save_category';
$route['admin/check-event-category-title'] = 'admin/event/check_event_category_title';
$route['admin/delete-category/(:num)'] = 'admin/event/delete_category/$1';

/* Slider */
$route['admin/manage-slider'] = 'admin/slider/index';
$route['admin/add-slider'] = 'admin/slider/add_slider';
$route['admin/update-slider/(:num)'] = 'admin/slider/update_slider/$1';
$route['admin/save-slider'] = 'admin/slider/save_slider';
$route['admin/delete-slider/(:num)'] = 'admin/slider/delete_slider/$1';

/* Package */
$route['admin/manage-package'] = 'admin/package/index';
$route['admin/add-package'] = 'admin/package/add_package';
$route['admin/save-package'] = 'admin/package/save_package';
$route['admin/update-package/(:num)'] = 'admin/package/update_package/$1';
$route['admin/delete-package/(:num)'] = 'admin/package/delete_package/$1';
$route['admin/package-payment'] = 'admin/package/package_payment/$1';

/* Vendor */
$route['admin/vendor'] = 'admin/vendor/index';
$route['admin/delete-vendor/(:any)'] = 'admin/vendor/delete_vendor/$1';
$route['admin/change-vendor-status/(:any)'] = 'admin/vendor/change_vendor_tatus/$1';
$route['admin/vendor-payment'] = 'admin/vendor/vendor_payment';
$route['admin/send-vendor-payment/(:num)'] = 'admin/vendor/send_vendor_payment/$1';

/* Report */
$route['admin/report'] = 'admin/report/index';
$route['admin/customer-report'] = 'admin/report/customer_report';
$route['admin/appointment-report'] = 'admin/report/appointment_report';

/* Appointment */

$route['admin/manage-appointment'] = 'admin/appointment/index';
$route['admin/manage-appointment/(:num)'] = 'admin/appointment/index/$1';
$route['admin/change-appointment/(:num)/(:any)'] = 'admin/appointment/change_appointment/$1/$2';
$route['admin/send-remainder'] = 'admin/appointment/send_remainder';

/* Site Setting */

$route['admin/sitesetting'] = 'admin/sitesetting/index';
$route['admin/save-sitesetting'] = 'admin/sitesetting/save_sitesetting';
$route['admin/email-setting'] = 'admin/sitesetting/email_setting';
$route['admin/save-email-setting'] = 'admin/sitesetting/save_email_setting';
$route['admin/display-setting'] = 'admin/sitesetting/display_setting';
$route['admin/save-display-setting'] = 'admin/sitesetting/save_display_setting';
$route['admin/business-setting'] = 'admin/sitesetting/business_setting';
$route['admin/save-business-setting'] = 'admin/sitesetting/save_businesss_setting';
$route['admin/payment-setting'] = 'admin/sitesetting/payment_setting';
$route['admin/save-payment-setting'] = 'admin/sitesetting/save_payment_setting';
$route['admin/update-display-setting'] = 'admin/sitesetting/update_display_setting';

/* City */

$route['admin/manage-city'] = 'admin/city/index';
$route['admin/add-city'] = 'admin/city/add_city';
$route['admin/update-city/(:num)'] = 'admin/city/update_city/$1';
$route['admin/save-city'] = 'admin/city/save_city';
$route['admin/check-city-title'] = 'admin/city/check_city_title';
$route['admin/delete-city/(:num)'] = 'admin/city/delete_city/$1';

/* Location */

$route['admin/manage-location'] = 'admin/location/index';
$route['admin/add-location'] = 'admin/location/add_location';
$route['admin/update-location/(:num)'] = 'admin/location/update_location/$1';
$route['admin/save-location'] = 'admin/location/save_location';
$route['admin/check-location-title'] = 'admin/location/check_location_title';
$route['admin/delete-location/(:num)'] = 'admin/location/delete_location/$1';

/* Message */
$route['admin/message'] = 'admin/message';
$route['admin/message/(:num)'] = 'admin/message/index/$1';
$route['admin/message-action'] = 'admin/message/message_action';

/* Discount Coupon Admin */
$route['admin/manage-coupon'] = 'admin/coupon/index';
$route['admin/add-coupon'] = 'admin/coupon/add_coupon';
$route['admin/update-coupon/(:num)'] = 'admin/coupon/update_coupon/$1';
$route['admin/save-coupon'] = 'admin/coupon/save_coupon';
$route['admin/delete-coupon/(:num)'] = 'admin/coupon/delete_coupon/$1';


/* language Setting */
$route['admin/manage-language'] = 'admin/language/index';
$route['admin/add-language'] = 'admin/language/add_language';
$route['admin/language-translate/(:num)'] = 'admin/language/language_translate/$1';
$route['admin/update-language/(:num)'] = 'admin/language/update_language/$1';
$route['admin/save-language'] = 'admin/language/save_language';
$route['admin/save-translated-language/(:num)'] = 'admin/language/save_translated_language/$1';
$route['admin/delete-language/(:num)'] = 'admin/language/delete_language/$1';


/* Discount Coupon vendor */
$route['vendor/manage-coupon'] = 'admin/coupon/index';
$route['vendor/add-coupon'] = 'admin/coupon/add_coupon';
$route['vendor/update-coupon/(:num)'] = 'admin/coupon/update_coupon/$1';
$route['vendor/save-coupon'] = 'admin/coupon/save_coupon';
$route['vendor/delete-coupon/(:num)'] = 'admin/coupon/delete_coupon/$1';


/*
 * 
 * Vendor Folder
 * 
 */

/* Vendor Content */
$route['vendor'] = 'vendor/content/login';
$route['vendor/login'] = 'vendor/content/login';
$route['vendor/logout'] = 'vendor/content/logout';

$route['vendor/profile'] = 'vendor/content/profile';
$route['vendor/login-action'] = 'vendor/content/login_action';
$route['vendor/profile-save'] = 'vendor/content/profile_save';
$route['vendor/forgot-password'] = 'vendor/content/forgot_password';
$route['vendor/forgot-password-action'] = 'vendor/content/forgot_password_action';
$route['vendor/reset-password/(:any)/(:any)'] = 'vendor/content/reset_password/$1/$2';
$route['vendor/reset-password-action'] = 'vendor/content/reset_password_action';
$route['vendor/update-password'] = 'vendor/content/update_password';
$route['vendor/update-password-action'] = 'vendor/content/update_password_action';

/* Dashboard */
$route['vendor/dashboard'] = 'vendor/dashboard/index';
$route['vendor/payment_status_update/(:num)'] = 'vendor/dashboard/payment_status_update/$1';
$route['admin/payment_status_update/(:num)'] = 'admin/dashboard/payment_status_update/$1';
$route['vendor/payment-history'] = 'vendor/dashboard/payment_history';

/* Payment Request Vendor */
$route['vendor/payout-request'] = 'vendor/dashboard/wallet';
$route['vendor/payment-request-save'] = 'vendor/dashboard/payment_request_save';

/* Event */

$route['vendor/manage-event'] = 'admin/event/index';
$route['vendor/add-event'] = 'admin/event/add_event';
$route['vendor/update-event/(:num)'] = 'admin/event/update_event/$1';
$route['vendor/save-event'] = 'admin/event/save_event';
$route['vendor/delete-event/(:num)'] = 'admin/event/delete_event/$1';
$route['vendor/get-location/(:num)'] = 'admin/event/get_location/$1';
$route['vendor/delete-event-image'] = 'admin/event/delete_event_image';
$route['vendor/delete-event-seo-image'] = 'admin/event/delete_event_seo_image';
$route['vendor/event-category'] = 'admin/event/event_category';
$route['vendor/add-category'] = 'admin/event/add_category';
$route['vendor/update-category/(:num)'] = 'admin/event/update_category/$1';
$route['vendor/save-category'] = 'admin/event/save_category';
$route['vendor/check-event-category-title'] = 'admin/event/check_event_category_title';
$route['vendor/delete-category/(:num)'] = 'admin/event/delete_category/$1';

/* Appointment */

$route['vendor/manage-appointment'] = 'admin/appointment/index';
$route['vendor/manage-appointment/(:num)'] = 'admin/appointment/index/$1';
$route['vendor/change-appointment/(:num)/(:any)'] = 'admin/appointment/change_appointment/$1/$2';
$route['vendor/send-remainder'] = 'admin/appointment/send_remainder';

/* City */

$route['vendor/city'] = 'admin/city/index';
$route['vendor/manage-city'] = 'admin/city/index';
$route['vendor/add-city'] = 'admin/city/add_city';
$route['vendor/update-city/(:num)'] = 'admin/city/update_city/$1';
$route['vendor/save-city'] = 'admin/city/save_city';
$route['vendor/check-city-title'] = 'admin/city/check_city_title';
$route['vendor/delete-city/(:num)'] = 'admin/city/delete_city/$1';

/* Location */

$route['vendor/location'] = 'admin/location/index';
$route['vendor/add-location'] = 'admin/location/add_location';
$route['vendor/update-location/(:num)'] = 'admin/location/update_location/$1';
$route['vendor/save-location'] = 'admin/location/save_location';
$route['vendor/check-location-title'] = 'admin/location/check_location_title';
$route['vendor/delete-location/(:num)'] = 'admin/location/delete_location/$1';

/* Membership */

$route['vendor/membership'] = 'vendor/membership/index';
$route['vendor/membership-purchase'] = 'vendor/membership/membership_purchase';
$route['vendor/purchase-details/(:num)'] = 'vendor/membership/purchase_details/$1';
$route['vendor/check-package-price/(:num)'] = 'vendor/membership/check_package_price/$1';
$route['vendor/package-purchase'] = 'vendor/membership/package_purchase';

/* Slider */
$route['vendor/manage-slider'] = 'admin/slider/index';
$route['vendor/add-slider'] = 'admin/slider/add_slider';
$route['vendor/update-slider/(:num)'] = 'admin/slider/update_slider/$1';
$route['vendor/save-slider'] = 'admin/slider/save_slider';
$route['vendor/delete-slider/(:num)'] = 'admin/slider/delete_slider/$1';

/* Message */
$route['vendor/message'] = 'admin/message';
$route['vendor/message/(:num)'] = 'admin/message/index/$1';
$route['vendor/message-action'] = 'admin/message/message_action';

/* Report */
$route['vendor/appointment-report'] = 'admin/report/appointment_report';

/* Location search */
$route['events/(:any)'] = 'front';


