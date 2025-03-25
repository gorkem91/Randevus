<?php

function get_thumb_image($image) {
    $data_array = explode(".", $image);
    $image_name = $data_array[0];
    $image_ext = $data_array[1];
    $thumb_image = $image_name . "_thumb." . $image_ext;
    return $thumb_image;
}

function get_vendor_amount($amount, $vendor_id) {
    $CI = & get_instance();
    $commission_percentage = get_site_setting('commission_percentage');
    $vendor_amount = ($amount - ($amount * ($commission_percentage / 100)));
    return number_format((float) $vendor_amount, 2, '.', '');
}

function get_admin_amount($amount) {
    $CI = & get_instance();
    $commission_percentage = get_site_setting('commission_percentage');
    $admin_amount = (($amount * ($commission_percentage / 100)));
    return number_format((float) $admin_amount, 2, '.', '');
}

function get_discount_price_by_date($event_id) {

    $CI = & get_instance();
//get Event data
    $CI->db->select('*');
    $CI->db->from('app_event');
    $where = "id=" . $event_id . " AND status='A'";
    $CI->db->where($where);
    $app_event_data = $CI->db->get()->row_array();

    if (count($app_event_data) > 0) {
        //get event price details
        $event_price = 0;
        $discountDate = date('Y-m-d');
        if (isset($app_event_data['discount']) && $app_event_data['discount'] > 0 && isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
            $event_price = $app_event_data['discounted_price'];
        } else {
            $event_price = $app_event_data['price'];
        }
        return $event_price;
    } else {
        return 0;
    }
}

function get_discount_price($event_id, $discount_coupon, $discount_coupon_id) {

    $CI = & get_instance();
//get Event data
    $CI->db->select('*');
    $CI->db->from('app_event');
    $where = "id=" . $event_id . " AND status='A'";
    $CI->db->where($where);
    $app_event_data = $CI->db->get()->row_array();

//get app_coupon data
    $CI->db->select('*');
    $CI->db->from('app_coupon');
    $wheres = "code='" . $discount_coupon . "' AND status='A'";
    $CI->db->where($wheres);
    $coupon_signle_data = $CI->db->get()->row_array();

    if (count($app_event_data) > 0) {
        if (count($coupon_signle_data) > 0) {

            $valid_till = $coupon_signle_data['valid_till'];
            $event_id_array = $coupon_signle_data['event_id'];
            $discount_type = $coupon_signle_data['discount_type'];
            $discount_value = $coupon_signle_data['discount_value'];

            //get event price details
            $event_price = 0;
            $discountDate = date('Y-m-d');
            if (isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
                $event_price = $app_event_data['discounted_price'];
            } else {
                $event_price = $app_event_data['price'];
            }

            $final_price = $event_price;
            //Apply coupon disocunt on event price
            if ($discount_type == 'P') {
                $final_price = ($final_price - ($final_price * ($discount_value / 100)));
            } else {
                $final_price = $final_price - $discount_value;
            }

            $event_id_ary = json_decode($event_id_array);

            if ($valid_till >= date('Y-m-d')) {

                if (in_array($event_id, $event_id_ary)) {
                    return number_format((float) $final_price, 2, '.', '');
                } else {
                    $discountDate = date('Y-m-d');
                    $event_price = $app_event_data['price'];
                    if (isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
                        $event_price = $app_event_data['discounted_price'];
                    }
                    return number_format((float) $event_price, 2, '.', '');
                }
            } else {
                $discountDate = date('Y-m-d');
                $event_price = $app_event_data['price'];
                if (isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
                    $event_price = $app_event_data['discounted_price'];
                }
                return number_format((float) $event_price, 2, '.', '');
            }
        } else {
            $discountDate = date('Y-m-d');
            $event_price = $app_event_data['price'];
            if (isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
                $event_price = $app_event_data['discounted_price'];
            }
            return number_format((float) $event_price, 2, '.', '');
        }
    } else {
        $event_price = isset($app_event_data['price']) ? $app_event_data['price'] : 0;
        return number_format((float) $event_price, 2, '.', '');
    }
}

function get_payment_setting($field) {
    $CI = & get_instance();
    $CI->db->select($field);
    $CI->db->from('app_payment_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $payment_data = $CI->db->get()->result_array();
    return isset($payment_data) && count($payment_data) > 0 ? $payment_data[0][$field] : '';
}

function get_site_setting($field) {
    $CI = & get_instance();
    $CI->db->select($field);
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $site_data = $CI->db->get()->result_array();
    return isset($site_data) && count($site_data) > 0 ? $site_data[0][$field] : '';
}

function get_CompanyName() {
    $CI = & get_instance();
    $CI->db->select('company_name');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0]['company_name'] : '';
}

function get_slote_count($id) {
    $CI = & get_instance();
    $type = $CI->session->userdata('Type_' . ucfirst($CI->uri->segment(1)));
    $vendor_id = $CI->session->userdata('Vendor_ID');
    $CI->db->select('COUNT(app_event_book.slot_time) as slot_time');
    $CI->db->join('app_event', 'app_event.id=app_event_book.event_id', 'left');
    $CI->db->from('app_event_book');
    if ($type == 'V') {
        $where = "event_id='$id' AND app_event.created_by='$vendor_id'";
    } else {
        $where = "event_id=" . $id;
    }
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0]['slot_time'] : 0;
}

function get_CompanyLogo() {
    $CI = & get_instance();
    $CI->db->select('company_logo');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0]['company_logo'] : '';
}

function get_time_zone() {
    $CI = & get_instance();
    $CI->db->select('time_zone');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 && $user_data[0]['time_zone'] != '' ? $user_data[0]['time_zone'] : 'Asia/Kolkata';
}

function tz_list() {
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
}

function get_CustomerDetails() {
    $CI = & get_instance();
    $id = $CI->session->userdata('CUST_ID');
    $CI->db->select('first_name, last_name, profile_image');
    $CI->db->from('app_customer');
    $where = "id='$id'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0] : '';
}

function get_VendorDetails($id = NULL) {
    $CI = & get_instance();
    if (is_null($id)) {
        $id = $CI->session->userdata('Vendor_ID');
    }
    $CI->db->select('id as user_id,first_name, last_name, profile_image,company_name');
    $CI->db->from('app_admin');
    $where = "id='$id'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0] : '';
}

function slugify($str) {
    $search = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
    $str = str_ireplace($search, $replace, strtolower(trim($str)));
    $str = preg_replace('/[^\w\d\-\]/', '', $str);
    $str = str_replace(' ', '-', $str);
    return preg_replace('/\- {
        2, }/', '-', $str);
}

function get_Langauge() {
    $CI = & get_instance();
    $CI->db->select('language');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    if (isset($user_data) && count($user_data) > 0) {
        $file = APPPATH . "/language/" . $user_data[0]['language'] . "/";
        if (is_dir($file)) {
            return strtolower($user_data[0]['language']);
        } else {
            return strtolower($CI->config->item('language'));
        }
    } else {
        return strtolower($CI->config->item('language'));
    }
}

function check_admin_image($image) {
    if (file_exists(dirname(BASEPATH) . "/" . $image) && pathinfo($image, PATHINFO_EXTENSION) != '') {
        return base_url() . $image;
    } else {
        return base_url() . img_path . "/no-image.png";
    }
}

function check_appointment_status($val) {
    $CI = & get_instance();
    if ($val == 'C') {
        return '<span class="alert alert-success">' . translate('completed') . '</span>';
    } elseif ($val == 'A') {
        return '<span class="alert alert-success">' . translate('approved') . '</span>';
    } elseif ($val == 'P') {
        return '<span class="alert alert-info">' . translate('pending') . '</span>';
    } elseif ($val == 'R') {
        return '<span class="alert alert-warning">' . translate('rejected') . '</span>';
    } else {
        return '<span class="alert alert-danger">' . translate('deleted') . '</span>';
    }
}

function check_appointment_pstatus($val) {
    $CI = & get_instance();
    if ($val == 'S') {
        return '<span class="alert alert-success">' . translate('success') . '</span>';
    } elseif ($val == 'P') {
        return '<span class="alert alert-warning">' . translate('pending') . '</span>';
    } else {
        return '<span class="alert alert-danger">' . translate('failed') . '</span>';
    }
}

function print_appointment_status($val) {
    $CI = & get_instance();
    if ($val == 'C') {
        return translate('completed');
    } elseif ($val == 'A') {
        return translate('approved');
    } elseif ($val == 'P') {
        return translate('pending');
    } elseif ($val == 'R') {
        return translate('rejected');
    } else {
        return translate('deleted');
    }
}

function validatecard($number) {
    global $type;
    $cardtype = array(
        "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex" => "/^3[47][0-9]{13}$/",
        "discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );
    if (preg_match($cardtype['visa'], $number)) {
        $type = "visa";
        return 'visa';
    } else if (preg_match($cardtype['mastercard'], $number)) {
        $type = "mastercard";
        return 'mastercard';
    } else if (preg_match($cardtype['amex'], $number)) {
        $type = "amex";
        return 'amex';
    } else if (preg_match($cardtype['discover'], $number)) {
        $type = "discover";
        return 'discover';
    } else {
        return false;
    }
}

function check_membership($vendor_id, $package_id) {
    $CI = & get_instance();
    $CI->db->select('remaining_event');
    $CI->db->from('app_membership_history');
    $CI->db->where("package_id = '$package_id' AND customer_id='$vendor_id' AND status='A'");
    $res = $CI->db->get()->result_array();
    if (isset($res) && count($res) > 0) {
        if ($res[0]['remaining_event'] == 0) {
            $CI->session->set_flashdata('msg_class', 'failure');
            $CI->session->set_flashdata('msg', translate('membership_expired'));
            redirect("vendor/membership-purchase");
        }
    } else {
        $CI->session->set_flashdata('msg_class', 'failure');
        $CI->session->set_flashdata('msg', translate('membership_not_select'));
        redirect("vendor/membership-purchase");
    }
}

function check_vendor_profile($profile_status = NULL) {
    $CI = & get_instance();
    $vendor_id = $CI->session->userdata('Vendor_ID');
    $CI->db->select('*');
    $CI->db->where('id', $vendor_id);
    $vendor_result = $CI->db->get('app_admin')->result_array();
    if (isset($vendor_result) && count($vendor_result) > 0) {
        if (!is_null($profile_status)) {
            if (isset($vendor_result[0]['status']) && $vendor_result[0]['status'] == 'P') {
                $CI->session->set_flashdata('msg_class', 'failure');
                $CI->session->set_flashdata('msg', translate('profile_under_review'));
                redirect("vendor/dashboard");
            }
        }
    } else {
        $CI->session->set_flashdata('msg_class', 'failure');
        $CI->session->set_flashdata('msg', translate('invalid_request'));
        redirect("vendor/login");
    }
}

function print_vendor_status($status) {
    $CI = & get_instance();
    if ($status == 'A') {
        return '<span class="alert alert-success">' . translate('active') . '</span>';
    } elseif ($status == 'P') {
        return '<span class="alert alert-warning">' . translate('pending') . '</span>';
    } elseif ($status == 'I') {
        return '<span class="alert alert-info">' . translate('inactive') . '</span>';
    } elseif ($status == 'D') {
        return '<span class="alert alert-danger">' . translate('deleted') . '</span>';
    }
}

function get_profile_slider($created_by) {
    $CI = & get_instance();
    $CI->db->select('image');
    $CI->db->where("created_by = '$created_by' AND status='A'");
    $slider = $CI->db->get('app_slider')->result_array();
    return $slider;
}

function get_message($date, $chat_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->where("DATE(created_on) = '$date' AND chat_id='$chat_id'");
    $message = $CI->db->get('app_chat')->result_array();
    return $message;
}

function check_unread_msg($chat_id, $vendor_id, $customer_id) {
    $CI = & get_instance();
    $CI->db->select('id');
    $CI->db->where("chat_id='$chat_id' AND to_id='$customer_id' AND from_id='$vendor_id' AND msg_read='N' AND chat_type='NC'");
    $message = $CI->db->get('app_chat')->result_array();
    return isset($message) && count($message) > 0 ? count($message) : 0;
}

function get_unread_msg($chat_id, $vendor_id, $customer_id) {
    $CI = & get_instance();
    $CI->db->select('id');
    $CI->db->where("chat_id='$chat_id' AND to_id='$vendor_id' AND from_id='$customer_id' AND msg_read='N' AND chat_type='C'");
    $message = $CI->db->get('app_chat')->result_array();
    return isset($message) && count($message) > 0 ? count($message) : 0;
}

function price_format($val) {
    return "$" . number_format((float) $val, 2, '.', '');
}

function get_StripeSecret() {
    $CI = & get_instance();
    $CI->db->select('stripe_secret,stripe');
    $CI->db->from('app_payment_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 && $user_data[0]['stripe'] == 'Y' ? $user_data[0]['stripe_secret'] : '';
}

function get_Stripepublish() {
    $CI = & get_instance();
    $CI->db->select('stripe_publish,stripe');
    $CI->db->from('app_payment_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 && $user_data[0]['stripe'] == 'Y' ? $user_data[0]['stripe_publish'] : '';
}

function check_payment_method($val) {
    $CI = & get_instance();
    $CI->db->select($val);
    $CI->db->from('app_payment_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 && $user_data[0][$val] == 'Y' ? true : false;
}

function event_rating($id) {
    $CI = & get_instance();
    $CI->db->select("SUM(rating) as rating,COUNT(user_id) as user");
    $CI->db->from('app_rating');
    $where = "event_id='$id'";
    $CI->db->where($where);
    $CI->db->group_by('event_id');
    $avr_rating = $CI->db->get()->result_array();
    return round(isset($avr_rating[0]['rating']) && $avr_rating[0]['rating'] != '' ? $avr_rating[0]['rating'] / $avr_rating[0]['user'] : 0);
}

function chek_rating($id) {
    $CI = & get_instance();
    $customer_id = $CI->session->userdata('CUST_ID');
    $CI->db->select("id");
    $CI->db->from('app_rating');
    $where = "event_id='$id' AND user_id='$customer_id'";
    $CI->db->where($where);
    $avr_rating = $CI->db->get()->result_array();
    return isset($avr_rating) && count($avr_rating) > 0 ? 'true' : 'false';
}

function get_fevicon() {
    $CI = & get_instance();
    $CI->db->select('fevicon_icon');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? base_url(UPLOAD_PATH . "sitesetting/" . $user_data[0]['fevicon_icon']) : '';
}

function get_single_row($table, $field, $where) {
    $CI = & get_instance();
    $CI->db->select($field);
    $CI->db->from($table);
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data;
}

function check_mandatory() {
    $CI = & get_instance();
    $categtory = $CI->db->select('id')->from('app_event_category')->get()->result_array();
    $city = $CI->db->select('city_id')->from('app_city')->get()->result_array();
    $location = $CI->db->select('loc_id')->from('app_location')->get()->result_array();
    $payment = $CI->db->select('id')->where("on_cash='Y' OR stripe='Y'")->get('app_payment_setting')->result_array();

    if (isset($categtory) && count($categtory) == 0 || isset($city) && count($city) == 0 || isset($location) && count($location) == 0 || isset($payment) && count($payment) == 0) {
        redirect("admin/mandatory-update");
    }
}

//return translation
if (!function_exists('translate')) {

    function translate($word) {

        $CI = & get_instance();
        $CI->load->database();

        $language_session = $CI->session->userdata('language');
        if (isset($language_session) && $language_session != "" && $language_session != NULL) {
            $language = isset($language_session) ? trim($language_session) : "english";
        } else {
            $language_data = $CI->db->select('language')->where("id=1")->get('app_site_setting')->row_array();
            $language = isset($language_data['language']) ? trim($language_data['language']) : "english";
        }
        $return = '';
        $result = $CI->db->select($language)->where("default_text='" . $word . "'")->get('app_language_data')->row_array();
        $english_result = $CI->db->select('english')->where("default_text='" . $word . "'")->get('app_language_data')->row_array();

        if (isset($result) && count($result) > 0) {
            if (isset($result[$language]) && $result[$language] != "" && $result[$language] != NULL) {
                $return = $result[$language];
            } else {
                $return = $english_result['english'];
            }
        } else {
            $return = $english_result['english'];
        }
        return $return;
    }

}

function get_languages() {
    $CI = & get_instance();
    return $languages = $CI->db->select('*')->where('status', 'A')->from('app_language')->get()->result_array();
}

?>
